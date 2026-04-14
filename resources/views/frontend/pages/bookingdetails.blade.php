@extends('frontend.index')
@section('content')

<div class="section-wrap" style="padding-top:60px; min-height: 80vh; background: var(--paper);">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="syne" style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 8px;">My Booking History</h1>
            <p style="color: var(--muted); font-size: 15px;">Review all your pending and completed bus ticket reservations.</p>
        </div>
    </div>

    <div class="sb-card" style="padding: 0; overflow: hidden; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); background: var(--card-bg);">
        <div class="table-responsive">
            <table class="table" style="margin-bottom: 0; color: #fff; border-collapse: collapse;">
                <thead style="background: rgba(255,255,255,0.02);">
                    <tr>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">SL</th>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">Route & Bus</th>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">Schedule</th>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">Seat Name</th>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">Amount</th>
                        <th style="padding: 20px; font-weight: 700; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 13px; text-transform: uppercase;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($groupedDetails) && $groupedDetails->count() > 0)
                        @php $counter = 1; @endphp
                        @foreach ($groupedDetails as $groupKey => $seatsGroup)
                            @php
                                $first = $seatsGroup->first();
                                $totalAmount = $seatsGroup->sum('amount');
                                $seatNames = $seatsGroup->pluck('seat.name')->implode(', ');
                                $bookingIds = $seatsGroup->pluck('id')->implode(',');
                                $modalId = 'modal-' . md5($groupKey);
                            @endphp
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 20px; align-content: center; color: var(--muted);">{{ $counter++ }}</td>
                                <td style="padding: 20px; align-content: center;">
                                    <div style="font-weight: 700; color: #fff; font-size: 16px;">{{ $first->seat->bus->bus_name ?? 'N/A' }}</div>
                                    <div style="font-size: 12px; color: var(--muted); margin-top: 4px;">Passenger: {{ auth()->user()->name }}</div>
                                </td>
                                <td style="padding: 20px; align-content: center;">
                                    <div style="font-weight: 600; color: #ddd;">{{ date('D, d M Y', strtotime($first->date)) }}</div>
                                    <div style="font-size: 13px; color: var(--muted);">{{ $first->time }}</div>
                                </td>
                                <td style="padding: 20px; align-content: center; max-width: 150px;">
                                    <span style="background: rgba(255,255,255,0.05); color: #fff; padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid var(--border); display: inline-block; word-break: break-all;">{{ $seatNames }}</span>
                                </td>
                                <td style="padding: 20px; align-content: center; font-weight: 800; font-family: 'Syne', sans-serif; font-size: 18px; color: #fff;">৳{{ $totalAmount }}</td>
                                <td style="padding: 20px; align-content: center;">
                                    @if ($first->status == 'pending')
                                        <div style="display: flex; gap: 8px;">
                                            <a class="sb-btn" href="{{ route('user.payment', $bookingIds) }}" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px; background: #a2e043; color: #0d1a09; text-decoration: none; border: none;">Pay Now</a>
                                            <button type="button" class="sb-btn" onclick="document.getElementById('{{ $modalId }}').style.display='flex'" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px; background: transparent; color: #fff; border: 1px solid var(--border); text-decoration: none;">Manage Tickets</button>
                                        </div>

                                        <!-- Manage Ticket Bundle Modal -->
                                        <div id="{{ $modalId }}" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); align-items: center; justify-content: center; z-index: 9999;">
                                            <div style="background: var(--card-bg); border: 1px solid var(--border); border-radius: 20px; padding: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); width: 90%; max-width: 500px; position: relative;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 16px;">
                                                    <h3 class="syne" style="color: #fff; font-size: 20px; font-weight: 700; margin: 0;">Manage Ticket Bundle</h3>
                                                    <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='none'" style="background: transparent; color: var(--muted); border: none; font-size: 24px; cursor: pointer; padding: 0;">&times;</button>
                                                </div>
                                                <div style="display:flex; flex-direction: column; gap: 12px; margin-bottom: 24px; max-height: 50vh; overflow-y: auto;">
                                                    @foreach($seatsGroup as $indSeat)
                                                        <div style="display:flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02); padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border);">
                                                            <div style="display:flex; align-items: center; gap: 12px;">
                                                                <span style="font-weight: 700; color: #fff;">Seat: {{ $indSeat->seat->name ?? 'N/A' }}</span>
                                                                <span style="color: var(--muted); font-size: 12px;">৳{{ $indSeat->amount }}</span>
                                                            </div>
                                                            <a href="{{ route('booking.delete', $indSeat->id) }}" class="sb-btn" style="padding: 6px 12px; background: rgba(255,0,0,0.1); color: #ff4d4d; border: 1px solid rgba(255,0,0,0.2); border-radius: 6px; font-size: 11px; text-decoration: none;">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div style="display:flex; justify-content: space-between; align-items: center;">
                                                     <span style="color: var(--muted); font-size: 14px;">Total Deal: <span style="color: #fff; font-weight: 700;">৳{{ $totalAmount }}</span></span>
                                                     <a href="{{ route('user.payment', $bookingIds) }}" class="sb-btn" style="padding: 10px 24px; background: #a2e043; color: #0d1a09; font-weight: 700; border-radius: 8px; text-decoration: none;">Checkout Bundle</a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span style="background: rgba(141,198,63,0.1); color: #a2e043; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 12px; border: 1px solid rgba(141,198,63,0.2);">
                                            <i class="fa fa-check-circle me-1"></i> Completed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 60px;">
                                <i class="fa-solid fa-ticket" style="font-size: 40px; color: var(--muted); margin-bottom: 20px; opacity: 0.3;"></i>
                                <div style="color: var(--muted); font-size: 15px;">No booking history found.</div>
                                <a href="{{ route('frontend.reserve') }}" class="sb-btn mt-3" style="background: transparent; color: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 10px 24px; font-weight: 600;">Find Trips</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
