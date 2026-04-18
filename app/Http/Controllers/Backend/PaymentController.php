<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if ($request->ajax()) {
            $payment = Payment::with('userRelation')->orderBy('id','DESC')->get();
            return \Yajra\DataTables\Facades\DataTables::of($payment)
                ->addIndexColumn()
                ->addColumn('passenger', function($row){
                    $name = $row->userRelation->name ?? 'N/A';
                    $email = $row->userRelation->email ?? '';
                    return '<div>
                                <div style="font-weight:700; color:#1e293b;">'.$name.'</div>
                                <div style="font-size:12px; color:var(--muted);">'.$email.'</div>
                            </div>';
                })
                ->addColumn('method', function($row){
                    $method = $row->payment_method ?? 'Cash';
                    return '<span class="badge-info">'.strtoupper($method).'</span>';
                })
                ->addColumn('amount_display', function($row){
                    return '<div style="font-weight:800; color:var(--accent); font-size:15px;">৳'.number_format($row->amount).'</div>';
                })
                ->addColumn('date', function($row){
                    return '<div style="font-size:13px; font-weight:600; color:#475569;">'
                            .$row->created_at->format('d M, Y').
                           '</div>';
                })
                ->rawColumns(['passenger', 'method', 'amount_display', 'date'])
                ->make(true);
        }
        return view('admin.pages.Payment.payment');
    }
}  