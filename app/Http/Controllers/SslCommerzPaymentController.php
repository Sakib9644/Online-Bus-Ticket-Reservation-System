<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfzalSabbir\SSLaraCommerz\Library\SslCommerz\SslCommerzNotification;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request, $id)
    {
        $ids = explode(',', $id);
        $bookings = Booking::whereIn('id', $ids)->get();
        
        if ($bookings->isEmpty()) {
            return redirect()->back()->with('error', 'Bookings not found');
        }

        $total_amount = $bookings->sum('amount');

        $post_data = array();
        $post_data['total_amount'] = $total_amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email ?? 'customer@example.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Bus Ticket";
        $post_data['product_category'] = "Ticket";
        $post_data['product_profile'] = "non-physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $id; // Store Comma-separated Booking IDs
        $post_data['value_b'] = Auth::id();

        # Before going to initiate the payment order status need to update as Pending.
        DB::table('bookings')
            ->whereIn('id', $ids)
            ->update([
                'status' => 'Pending'
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        // Re-authenticate user via metadata to prevent SameSite cookie session drop
        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);

        $sslc = new SslCommerzNotification();

        #Check if first booking is pending
        $order_details = DB::table('bookings')
            ->whereIn('id', $ids)
            ->first();

        if ($order_details && $order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                $ticket_no = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

                DB::table('bookings')
                    ->whereIn('id', $ids)
                    ->update([
                        'status' => 'complete',
                        'ticket_no' => $ticket_no
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
        } else if ($order_details->status == 'complete') {
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
        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);
        DB::table('bookings')
            ->whereIn('id', $ids)
            ->update(['status' => 'Failed']);

        return redirect()->route('frontend.home')->with('error', 'Payment Failed');
    }

    public function cancel(Request $request)
    {
        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        $booking_id = $request->input('value_a');
        $ids = explode(',', $booking_id);
        DB::table('bookings')
            ->whereIn('id', $ids)
            ->update(['status' => 'Canceled']);

        return redirect()->route('frontend.home')->with('error', 'Payment Canceled');
    }

    public function ipn(Request $request)
    {
        if ($request->input('value_b')) {
            Auth::loginUsingId($request->input('value_b'));
        }

        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            $booking_id = $request->input('value_a');

            #Check order status in order tabel.
            $ids = explode(',', $booking_id);
            $order_details = DB::table('bookings')
                ->whereIn('id', $ids)
                ->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, 'BDT');
                if ($validation == TRUE) {
                    $ticket_no = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

                    DB::table('bookings')
                        ->whereIn('id', $ids)
                        ->update([
                            'status' => 'complete',
                            'ticket_no' => $ticket_no
                        ]);

                    Payment::create([
                        'user_id' => $order_details->user_id,
                        'transaction_id' => $tran_id,
                        'amount' => $order_details->amount,
                        'payment_mathod' => 'SSLCommerz',
                    ]);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    */
                    echo "Validation Failed";
                }
            } else if ($order_details->status == 'complete') {

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
