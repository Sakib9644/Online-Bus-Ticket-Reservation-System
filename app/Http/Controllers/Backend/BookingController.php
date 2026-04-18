<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::with(['user', 'trip.bus', 'seat'])->latest();

            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('pnr', function($row) {
                    $courseNo = $row->trip->bus->coach_no ?? 'N/A';
                    return '<div>
                                <div style="font-weight:700; color:var(--accent); font-size:14.5px;">'.$courseNo.'</div>
                                <div style="font-size:10px; color:var(--muted); margin-top:2px;">PNR: <span style="color:#fff;">'.($row->ticket_no ?? 'N/A').'</span></div>
                                <div style="font-size:10px; color:var(--muted); opacity:0.7;">'.$row->created_at->format('d M Y, h:i A').'</div>
                            </div>';
                })
                ->addColumn('passenger', function($row) {
                    $name = $row->user->name ?? 'N/A';
                    $email = $row->user->email ?? '';
                    return '<div>
                                <div style="font-weight:700; color:#1e293b;">'.$name.'</div>
                                <div style="font-size:12px; color:var(--muted);">'.$email.'</div>
                            </div>';
                })
                ->addColumn('bus_route', function($row) {
                    $bus = $row->trip->bus->bus_name ?? 'Bus';
                    $courseNo = $row->trip->bus->coach_no ?? 'N/A';
                    $from = $row->trip->location_from ?? '';
                    $to = $row->trip->location_to ?? '';
                    return '<div>
                                <div style="font-weight:600; font-size:13px; color:#1e293b;">'.$bus.' <span style="color:var(--accent); font-size:11px; margin-left:5px;">['.$courseNo.']</span></div>
                                <div style="font-size:12px; color:var(--muted); display:flex; align-items:center; gap:5px;">
                                    <span>'.$from.'</span>
                                    <i class="fas fa-arrow-right" style="font-size:10px; opacity:0.5;"></i>
                                    <span>'.$to.'</span>
                                </div>
                            </div>';
                })
                ->addColumn('seats_display', function($row) {
                    $seat = $row->seat->name ?? 'N/A';
                    return '<span style="background:rgba(255,255,255,0.05); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700; color:var(--accent); border:1px solid rgba(162, 224, 67, 0.1);">'
                            .$seat.
                           '</span>';
                })
                ->addColumn('amount_display', function($row) {
                    return '<div style="font-weight:800; color:#0f172a; font-size:15px;">৳'.number_format($row->amount).'</div>';
                })
                ->addColumn('status_display', function($row) {
                    if($row->status == 'complete') {
                        return '<span class="badge-success">Confirmed</span>';
                    }
                    return '<span class="badge-warning">Pending</span>';
                })
                ->addColumn('actions', function($row) {
                    $printBtn = '<a href="'.route('view.info', $row->id).'" target="_blank" class="btn-outline-admin" style="padding:6px 12px; font-size:12px; height:32px; display:inline-flex; align-items:center;">
                                    <i class="fas fa-print"></i> Ticket
                                </a>';
                    $deleteBtn = '<a onclick="return confirm(\'Delete this specific seat booking?\')" href="'.route('admin.booking.delete', $row->id).'" class="btn-danger-admin" style="padding:6px 12px; font-size:12px; height:32px; display:inline-flex; align-items:center;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>';
                    return '<div style="display:flex; gap:8px;">'.$printBtn.$deleteBtn.'</div>';
                })
                ->rawColumns(['pnr', 'passenger', 'bus_route', 'seats_display', 'amount_display', 'status_display', 'actions'])
                ->make(true);
        }

        return view('admin.pages.Booking.booking-list');
    }

    public function bookingStatus($id){
      $booking=Booking::find($id);
      $booking->update([
          'status'=>'complete'
      ]);
      return redirect()->back();
    }

    
        public function cancle($id){
            $cancle=Booking::find($id);
            $cancle->delete();
            return redirect()->back();
           
        }   
    public function bookingdelete($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->delete();
        }
        return redirect()->route('admin.booking.list')->with('msg', 'Seat Booking Deleted successfully.');
    }
        
        }


