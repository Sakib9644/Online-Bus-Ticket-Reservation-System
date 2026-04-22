<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Raziul\Sslcommerz\Facades\Sslcommerz;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingExpiryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SslCommerzPaymentController extends Controller
{
    private function releaseExpiredPendingBookings()
    {
        app(BookingExpiryService::class)->releaseExpiredPending();
    }

    public function index(Request $request, $id)
    {
        $this->releaseExpiredPendingBookings();

        $ids = explode(',', $id);
        $bookings = Booking::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.details')->with('error', 'Booking not found or payment window expired.');
        }

        $pendingBookings = $bookings->filter(function ($booking) {
            return strtolower((string) $booking->status) === 'pending';
        });

        if ($pendingBookings->isEmpty()) {
            return redirect()->route('view.info', ['id' => $id])->with('message', 'This booking bundle is already paid.');
        }

        $pendingIds = $pendingBookings->pluck('id')->values()->all();
        $id = implode(',', $pendingIds);

        $total_amount = $pendingBookings->sum('amount');

        $tran_id = uniqid();

        # Before going to initiate the payment order status need to update as Pending.
        DB::table('bookings')
            ->whereIn('id', $pendingIds)
            ->update([
                'status' => 'Pending'
            ]);

        $response = Sslcommerz::setOrder($total_amount, $tran_id, 'Bus Ticket', 'Ticket')
            ->setCustomer(
                Auth::user()->name,
                Auth::user()->email ?? 'customer@example.com',
                '8801XXXXXXXXX',
                'Customer Address'
            )
            ->makePayment([
                'value_a' => $id,
                'value_b' => Auth::id(),
                'product_profile' => 'non-physical-goods',
                'shipping_method' => 'NO',
            ]);

        if ($response->success()) {
            return redirect($response->gatewayPageURL());
        } else {
            return redirect()->back()->with('error', $response->failedReason() ?? 'Payment initiation failed.');
        }
    }

    public function success(Request $request)
    {
        $this->releaseExpiredPendingBookings();

        // Re-authenticate user via metadata to prevent SameSite cookie session drop
        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);

        $bookings = Booking::whereIn('id', $ids)->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.details')->with('error', 'Payment window expired. Please book again.');
        }

        $order_details = $bookings->first();
        $currentStatus = strtolower((string) $order_details->status);

        if ($currentStatus == 'pending') {
            $validation = Sslcommerz::validatePayment($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                $ticket_no = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

                DB::table('bookings')
                    ->whereIn('id', $ids)
                    ->update([
                        'status' => 'complete',
                        'ticket_no' => $ticket_no,
                        'expires_at' => null,
                    ]);

                Payment::create([
                    'user_id' => $order_details->user_id,
                    'transaction_id' => $tran_id,
                    'amount' => $amount,
                    'payment_mathod' => 'SSLCommerz',
                ]);

                return redirect()->route('view.info', ['id' => $booking_id])->with('message', 'Transaction is successfully Completed');
            } else {
                /*
                That means IPN worked, but Transation validation failed.
                */
                return redirect()->route('frontend.home')->with('error', 'Validation Failed');
            }
        } else if ($currentStatus == 'complete') {
            /*
             That means through IPN Order status already updated.
             Now you can just show the customer that transaction is completed.
             */
            return redirect()->route('view.info', ['id' => $booking_id])->with('message', 'Transaction is successfully Completed');
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->route('frontend.home')->with('error', 'Invalid Transaction');
        }
    }

    public function fail(Request $request)
    {
        $this->releaseExpiredPendingBookings();

        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);
        DB::table('bookings')
            ->whereIn('id', $ids)
            ->update([
                'status' => 'Failed',
                'expires_at' => null,
            ]);

        return redirect()->route('frontend.home')->with('error', 'Payment Failed');
    }

    public function cancel(Request $request)
    {
        $this->releaseExpiredPendingBookings();

        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);
        DB::table('bookings')
            ->whereIn('id', $ids)
            ->update([
                'status' => 'Canceled',
                'expires_at' => null,
            ]);

        return redirect()->route('frontend.home')->with('error', 'Payment Canceled');
    }

    public function ipn(Request $request)
    {
        $this->releaseExpiredPendingBookings();

        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            $booking_id = $request->input('value_a');

            $ids = explode(',', $booking_id);
            $bookings = Booking::whereIn('id', $ids)->get();

            if ($bookings->isEmpty()) {
                echo "Invalid Transaction";
                return;
            }

            $order_details = $bookings->first();
            $currentStatus = strtolower((string) $order_details->status);
            $expectedAmount = $bookings->sum('amount');

            if ($currentStatus == 'pending') {
                $validation = Sslcommerz::validatePayment($request->all(), $tran_id, $expectedAmount, 'BDT');
                if ($validation == TRUE) {
                    $ticket_no = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

                    DB::table('bookings')
                        ->whereIn('id', $ids)
                        ->update([
                            'status' => 'complete',
                            'ticket_no' => $ticket_no,
                            'expires_at' => null,
                        ]);

                    Payment::create([
                        'user_id' => $order_details->user_id,
                        'transaction_id' => $tran_id,
                        'amount' => $expectedAmount,
                        'payment_mathod' => 'SSLCommerz',
                    ]);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    */
                    echo "Validation Failed";
                }
            } else if ($currentStatus == 'complete') {

                #That means Order status already updated. No need to udate again.
                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
