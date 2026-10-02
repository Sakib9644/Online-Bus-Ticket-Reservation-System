<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BkashPaymentController extends Controller
{
    /**
     * bKash Tokenized Checkout Sandbox Credentials
     */
    private function getConfig()
    {
        return [
            'base_url'   => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout',
            'username'   => 'sandboxTokenizedUser02',
            'password'   => 'sandboxTokenizedUser02@12345',
            'app_key'    => '4f6o0cjiki2rfm34kfdadl1eqq',
            'app_secret' => '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b',
        ];
    }

    /**
     * Get or refresh the bKash auth token (cached for 55 minutes).
     */
    private function getToken()
    {
        return Cache::remember('bkash_token', 55 * 60, function () {
            $config = $this->getConfig();

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'username'     => $config['username'],
                'password'     => $config['password'],
            ])->post($config['base_url'] . '/token/grant', [
                'app_key'    => $config['app_key'],
                'app_secret' => $config['app_secret'],
            ]);

            $data = $response->json();

            if (isset($data['id_token'])) {
                return $data['id_token'];
            }

            Log::error('bKash Token Grant Failed', $data ?? []);
            return null;
        });
    }

    /**
     * Step 1: Create a bKash payment and redirect user to bKash checkout.
     */
    public function createPayment($id)
    {
        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)
            ->where('user_id', Auth::id())
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.details')->with('error', 'Booking not found.');
        }

        $totalAmount = $bookings->sum('amount');
        $invoiceId = 'SB-' . date('ymdHis') . '-' . Auth::id();

        $token = $this->getToken();
        if (!$token) {
            return redirect()->route('user.payment', ['id' => $id])
                ->with('error', 'Could not connect to bKash. Please try again.');
        }

        $config = $this->getConfig();

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'X-APP-Key'     => $config['app_key'],
        ])->post($config['base_url'] . '/create', [
            'mode'                => '0011',
            'payerReference'      => 'booking_' . $id,
            'callbackURL'         => route('bkash.callback', ['id' => $id]),
            'amount'              => number_format($totalAmount, 2, '.', ''),
            'currency'            => 'BDT',
            'intent'              => 'sale',
            'merchantInvoiceNumber' => $invoiceId,
        ]);

        $data = $response->json();

        if (isset($data['bkashURL'])) {
            // Store paymentID in session for callback
            session(['bkash_payment_id' => $data['paymentID']]);
            return redirect()->away($data['bkashURL']);
        }

        Log::error('bKash Create Payment Failed', $data ?? []);
        return redirect()->route('user.payment', ['id' => $id])
            ->with('error', 'bKash payment creation failed: ' . ($data['statusMessage'] ?? 'Unknown error'));
    }

    /**
     * Step 2: bKash callback after user completes payment.
     */
    public function callback(Request $request, $id)
    {
        $paymentID = $request->query('paymentID');
        $status = $request->query('status');

        if ($status === 'cancel') {
            return redirect()->route('user.payment', ['id' => $id])
                ->with('error', 'bKash payment was cancelled.');
        }

        if ($status === 'failure') {
            return redirect()->route('user.payment', ['id' => $id])
                ->with('error', 'bKash payment failed. Please try again.');
        }

        if ($status !== 'success' || !$paymentID) {
            return redirect()->route('user.payment', ['id' => $id])
                ->with('error', 'Invalid bKash payment response.');
        }

        // Execute the payment
        $token = $this->getToken();
        if (!$token) {
            return redirect()->route('user.payment', ['id' => $id])
                ->with('error', 'Could not verify bKash payment. Contact support.');
        }

        $config = $this->getConfig();

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $token,
            'X-APP-Key'     => $config['app_key'],
        ])->post($config['base_url'] . '/execute', [
            'paymentID' => $paymentID,
        ]);

        $data = $response->json();

        if (isset($data['transactionStatus']) && $data['transactionStatus'] === 'Completed') {
            // Payment successful — mark bookings as complete
            $bookingIds = explode(',', $id);
            $bookings = Booking::whereIn('id', $bookingIds)
                ->where('user_id', Auth::id())
                ->get();

            $pendingBookings = $bookings->filter(fn($b) => strtolower((string) $b->status) === 'pending');

            if ($pendingBookings->isEmpty()) {
                return redirect()->route('view.info', ['id' => $id])
                    ->with('message', 'Payment already processed.');
            }

            $totalAmount = $pendingBookings->sum('amount');
            $ticketNo = $pendingBookings->first()->ticket_no ?: ('SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)));

            Payment::create([
                'user_id'        => Auth::id(),
                'payment_mathod' => 'bKash (Direct)',
                'transaction_id' => $data['trxID'] ?? $paymentID,
                'amount'         => $totalAmount,
            ]);

            \Illuminate\Support\Facades\DB::table('bookings')
                ->whereIn('id', $pendingBookings->pluck('id'))
                ->update([
                    'status'     => 'complete',
                    'ticket_no'  => $ticketNo,
                    'expires_at' => null,
                ]);

            return redirect()->route('view.info', ['id' => $id])
                ->with('message', 'bKash payment of ৳' . $totalAmount . ' successful! TrxID: ' . ($data['trxID'] ?? $paymentID));
        }

        Log::error('bKash Execute Payment Failed', $data ?? []);
        return redirect()->route('user.payment', ['id' => $id])
            ->with('error', 'bKash payment could not be verified: ' . ($data['statusMessage'] ?? 'Unknown error'));
    }
}
