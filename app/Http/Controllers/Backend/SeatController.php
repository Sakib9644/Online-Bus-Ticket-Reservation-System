<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Bus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SeatController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $buses = Bus::withCount('seats')
                ->with(['seats' => function($q) {
                    $q->orderBy('name');
                }])
                ->latest()
                ->get();

            return DataTables::of($buses)
                ->addIndexColumn()
                ->addColumn('bus_info', function($row){
                    $coach = $row->coach_no ?? $row->bus_no ?? 'N/A';
                    return '<div>
                                <div style="font-weight:700; color:#0f172a; font-size:15px;">'.e($row->bus_name).'</div>
                                <div style="font-size:12px; color:var(--muted); margin-top:2px;">Coach: <span style="font-family:monospace; font-weight:600; color:#475569;">'.e($coach).'</span></div>
                            </div>';
                })
                ->addColumn('bus_type', function($row){
                    $type = strtoupper($row->bus_type ?? 'N/A');
                    $isAc = str_contains($type, 'AC') && !str_contains($type, 'NON');
                    $bg = $isAc ? '#e0f2fe' : '#f1f5f9';
                    $color = $isAc ? '#0369a1' : '#475569';
                    $border = $isAc ? '#bae6fd' : '#e2e8f0';
                    return '<span style="background:'.$bg.'; color:'.$color.'; border:1px solid '.$border.'; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px; letter-spacing:0.5px;">'.$type.'</span>';
                })
                ->addColumn('seat_count', function($row){
                    if ($row->seats_count > 0) {
                        return '<span style="display:inline-flex; align-items:center; gap:6px; font-weight:700; color:#059669; background:#ecfdf5; border:1px solid #a7f3d0; padding:4px 12px; border-radius:20px; font-size:12px;">
                                    <i class="fas fa-chair"></i> '.$row->seats_count.' Seats Configured
                                </span>';
                    } else {
                        return '<span style="display:inline-flex; align-items:center; gap:6px; font-weight:600; color:#d97706; background:#fffbeb; border:1px solid #fde68a; padding:4px 12px; border-radius:20px; font-size:12px;">
                                    <i class="fas fa-exclamation-circle"></i> 0 Seats Configured
                                </span>';
                    }
                })
                ->addColumn('seat_preview', function($row){
                    if ($row->seats->isEmpty()) {
                        return '<span style="color:var(--muted); font-size:12px; font-style:italic;">No seats created yet</span>';
                    }
                    $seatChips = '';
                    $displayLimit = 8;
                    $firstFew = $row->seats->take($displayLimit);
                    foreach ($firstFew as $seat) {
                        $label = e($seat->seat_no ?: $seat->name);
                        $seatChips .= '<span style="display:inline-block; background:#f8fafc; color:#334155; border:1px solid #cbd5e1; font-family:monospace; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px; margin:2px 2px;">'.$label.'</span>';
                    }
                    if ($row->seats->count() > $displayLimit) {
                        $remaining = $row->seats->count() - $displayLimit;
                        $seatChips .= '<span style="display:inline-block; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px; margin:2px 2px;">+'.$remaining.' more</span>';
                    }
                    return '<div style="max-width:320px; display:flex; flex-wrap:wrap; align-items:center;">'.$seatChips.'</div>';
                })
                ->addColumn('actions', function($row){
                    $addUrl = route('admin.seat.create', ['bus_id' => $row->id]);
                    $clearUrl = route('admin.seat.clearBus', $row->id);
                    
                    $actions = '<div style="display:flex; gap:6px; align-items:center;">';
                    
                    $actions .= '<button type="button" class="btn-outline-admin view-bus-seats-btn" data-bus-id="'.$row->id.'" data-bus-name="'.e($row->bus_name).'" data-coach="'.e($row->coach_no ?? $row->bus_no).'" data-count="'.$row->seats_count.'" style="padding:6px 12px; font-size:12px; color:#2563eb; cursor:pointer;" title="View all seats layout">
                                    <i class="fas fa-th"></i> View Seats
                                </button>';
                    
                    $actions .= '<a href="'.$addUrl.'" class="btn-outline-admin" style="padding:6px 12px; font-size:12px; color:#059669;" title="Add/Generate seats for this bus">
                                    <i class="fas fa-plus"></i> Add
                                </a>';
                    
                    if ($row->seats_count > 0) {
                        $actions .= '<form action="'.$clearUrl.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to clear all '.$row->seats_count.' seats for this bus?\')">
                                        '.csrf_field().'
                                        '.method_field('DELETE').'
                                        <button type="submit" class="btn-danger-admin" style="padding:6px 10px; font-size:12px;" title="Clear all seats for this bus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['bus_info', 'bus_type', 'seat_count', 'seat_preview', 'actions'])
                ->make(true);
        }

        return view('admin.pages.Seat.seat-list');
    }

      public function create(){
         $buses=Bus::all();
         return view('admin.pages.Seat.seat-create', compact('buses'));
      }

      public function store(Request $request){

         $request->validate([
            'bus_id'=>'required',
            'total_seats'=>'required_without:name|nullable|numeric|min:1|max:60',
            'name'=>'required_without:total_seats|nullable|string',
        ]);

        if ($request->total_seats) {
            // Bulk Generation Logic
            $rows = 'ABCDEFGHIJKLMN';
            $seatsPerRow = 4;
            $count = 0;
            
            for ($i = 0; $i < ceil($request->total_seats / $seatsPerRow); $i++) {
                $rowChar = $rows[$i];
                for ($j = 1; $j <= $seatsPerRow; $j++) {
                    if ($count >= $request->total_seats) break;
                    
                    Seat::create([
                        'name' => $rowChar . $j,
                        'bus_id' => $request->bus_id,
                    ]);
                    $count++;
                }
            }
            return redirect()->route('admin.seat')->with('message', $count . ' seats automatically generated for the selected bus.');
        }

        Seat::create([
            'name'=>$request->name,
            'bus_id'=>$request->bus_id,
        ]);
        return redirect()->route('admin.seat')->with('message','Seat created successfully!');
      }

public function seatEdit($id){
   // dd($id);
   $seat = Seat::find($id);
   // dd($product);
   $seats = Seat::all();
   $buses=Bus::all();
   if ($seat) {
       return view('admin.pages.Seat.seat-edit',compact('seat','buses'));
   }
}

public function seatUpdate(Request $request,$id){
   // dd($request->all());
   // dd($id);
   $seat = Seat::find($id);
   // dd($seat);
   if ($seat) {
       $seat->update([
         'name'=>$request->name,
         'bus_id'=>$request->bus_id,
       ]);

       return redirect()->route('admin.seat')->with('success','Seat Updated!');
   }
}
public function seatDelete($id){
    Seat::find($id)->delete();
    if (request()->ajax()) {
        return response()->json(['success' => true, 'message' => 'Seat deleted successfully']);
    }
    return redirect()->route('admin.seat')->with('msg','Seat Deleted.');
}

public function getBusSeatsAjax($bus_id)
{
    $bus = Bus::with(['seats' => function($q) {
        $q->orderBy('name');
    }])->findOrFail($bus_id);

    return response()->json([
        'bus_id' => $bus->id,
        'bus_name' => $bus->bus_name,
        'coach_no' => $bus->coach_no ?? $bus->bus_no,
        'bus_type' => strtoupper($bus->bus_type ?? 'N/A'),
        'total_seats' => $bus->seats->count(),
        'seats' => $bus->seats->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->seat_no ?: $s->name,
                'delete_url' => route('admin.seat.delete', $s->id)
            ];
        })
    ]);
}

public function clearBusSeats($bus_id)
{
    $deleted = Seat::where('bus_id', $bus_id)->delete();
    return redirect()->route('admin.seat')->with('message', $deleted . ' seats successfully cleared for this bus.');
}
}