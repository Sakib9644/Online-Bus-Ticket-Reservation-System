@extends('frontend.index')
@section('content')

<div class="section-wrap" style="padding-top:60px; min-height: 80vh; background: var(--paper);">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 8px;">My Booking History</h1>
            <p style="color: var(--muted); font-size: 15px;">Each row is one booking reference. The same bus can appear multiple times if booked in separate orders.</p>
        </div>
    </div>

    <div class="sb-card" style="padding: 0; overflow: hidden; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); background: var(--card-bg);">
        <div class="table-responsive">
            <table class="table" style="margin-bottom: 0; color: #fff; border-collapse: collapse;">
                <thead style="background: rgba(255,255,255,0.02);">
                    <tr>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Course Number</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Bus & Journey Detail</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Payment Mode</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Current Status</th>
                    </tr>
                </thead>
                <tbody style="font-family: 'DM Sans', sans-serif;">
                    @if (isset($groupedDetails) && $groupedDetails->count() > 0)
                        @foreach ($groupedDetails as $groupKey => $seatsGroup)
                            @php
                                $first = $seatsGroup->first();
                                $allIds = $seatsGroup->pluck('id')->implode(',');
                                $pendingSeats = $seatsGroup->filter(function($seatBooking) {
                                    return strtolower((string) $seatBooking->status) === 'pending';
                                });
                                $confirmedSeats = $seatsGroup->filter(function($seatBooking) {
                                    return strtolower((string) $seatBooking->status) === 'complete';
                                });
                                $pendingAmount = $pendingSeats->sum('amount');
                                $pendingIds = $pendingSeats->pluck('id')->implode(',');
                                $confirmedIds = $confirmedSeats->pluck('id')->implode(',');
                                $seatNames = $seatsGroup->pluck('seat.name')->implode(', ');
                                $ticketRef = $first->ticket_no ?: ('TRIP-' . $first->trip_id);
                                $courseNo = $first->seat->bus->coach_no ?? 'N/A';
                                $pendingExpiryAt = $pendingSeats->min('expires_at');
                                $modalId = 'modal-' . md5($groupKey);
                            @endphp
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.1); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='rgba(0,0,0,0.1)'">
                                <td style="padding: 28px 20px; align-content: center;">
                                    <div style="font-weight: 900; color: var(--accent); font-size: 30px; letter-spacing: 0.5px; line-height: 1;">{{ $courseNo }}</div>
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 8px; text-transform: uppercase;">Booking {{ $ticketRef }}</div>
                                </td>
                                <td style="padding: 28px 20px; align-content: center;">
                                    <div style="display: flex; align-items: center; gap: 18px;">
                                        <div style="width: 44px; height: 44px; background: rgba(162, 224, 67, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(162, 224, 67, 0.2); flex-shrink:0;">
                                            <i class="fa fa-shuttle-van" style="color: var(--accent); font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: #fff; font-size: 17px; line-height: 1.2;">{{ $first->seat->bus->bus_name ?? 'N/A' }}</div>
                                            <div style="font-size: 12px; color: var(--muted); margin-top: 6px; font-weight: 600;">Seats: <span style="color: #fff;">{{ $seatNames }}</span></div>
                                            <div style="font-size: 11px; color: var(--muted); margin-top: 3px; text-transform: uppercase; letter-spacing:0.5px; opacity:0.7;">{{ date('D, d M Y', strtotime($first->date)) }} | {{ $first->time }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 28px 20px; align-content: center;">
                                    @if($pendingSeats->count() == 0)
                                        <div style="font-size: 12px; color: #2ecc71; font-weight: 700;"><i class="fa fa-check-circle me-1"></i> Fully Paid</div>
                                        <div style="font-size: 10px; color: var(--muted); margin-top: 4px;">Verified (SSLCommerz/Manual)</div>
                                    @elseif($confirmedSeats->count() > 0)
                                        <div style="font-size: 12px; color: #f1c40f; font-weight: 700;"><i class="fa fa-circle-half-stroke me-1"></i> Partially Paid</div>
                                        <div style="font-size: 10px; color: var(--muted); margin-top: 4px; opacity:0.8;">Some seats are paid, remaining payment required</div>
                                        @if($pendingExpiryAt)
                                            <div style="font-size: 10px; color: #f1c40f; margin-top: 4px; opacity: 0.9;">Pending seats auto-release at {{ $pendingExpiryAt->format('h:i A, d M') }}</div>
                                        @endif
                                    @else
                                        <div style="font-size: 12px; color: var(--muted); font-weight: 700;"><i class="fa fa-clock me-1"></i> Awaiting Payment</div>
                                        <div style="font-size: 10px; color: var(--muted); margin-top: 4px; opacity:0.6;">Manual/Online Required</div>
                                        @if($pendingExpiryAt)
                                            <div style="font-size: 10px; color: #f1c40f; margin-top: 4px; opacity: 0.9;">Auto-release at {{ $pendingExpiryAt->format('h:i A, d M') }}</div>
                                        @endif
                                    @endif
                                </td>
                                <td style="padding: 28px 20px; align-content: center;">
                                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                                        @if ($pendingSeats->count() > 0)
                                            <a class="sb-btn" href="{{ route('user.payment', $pendingIds) }}" style="padding: 12px 24px; font-size: 11px; font-weight: 900; border-radius: 6px; background: var(--accent); color: #000; text-decoration: none; border: none; text-transform: uppercase; letter-spacing:0.5px; box-shadow: 0 4px 15px rgba(162, 224, 67, 0.3);">PAY ৳{{ $pendingAmount }}</a>
                                            <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='flex'" style="padding: 12px 20px; font-size: 10px; font-weight: 800; border-radius: 6px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; text-transform: uppercase; letter-spacing:0.5px;">Manage</button>
                                        @endif

                                        @if ($confirmedSeats->count() > 0)
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 7px 16px; border-radius: 50px; font-weight: 800; font-size: 10px; border: 1px solid rgba(46, 204, 113, 0.2); text-transform: uppercase; letter-spacing: 0.5px;">{{ $pendingSeats->count() > 0 ? 'PARTIAL CONFIRMED' : 'Paid & Confirmed' }}</div>
                                                <a href="{{ route('view.info', $confirmedIds) }}" style="color: #fff; font-weight: 800; font-size: 12px; text-decoration: none; border: 1px solid rgba(255,255,255,0.1); padding: 8px 18px; border-radius: 8px; background: rgba(255,255,255,0.02); text-transform: uppercase; letter-spacing:0.5px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--accent)'; this.style.color='var(--accent)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='#fff'">Download <i class="fa fa-arrow-down-long ms-2" style="font-size: 10px;"></i></a>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($pendingSeats->count() > 0)
                                        <!-- Modal (Normalized Typography) -->
                                        <div id="{{ $modalId }}" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); align-items: center; justify-content: center; z-index: 9999;">
                                            <div style="background: var(--card-alt); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 40px; box-shadow: 0 40px 100px rgba(0,0,0,0.8); width: 95%; max-width: 500px; position: relative;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 16px;">
                                                    <h3 style="color: #fff; font-size: 22px; font-weight: 800; margin: 0; letter-spacing:-0.5px;">Manage Pending Seats</h3>
                                                    <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='none'" style="background: transparent; color: var(--muted); border: none; font-size: 32px; cursor: pointer; padding: 0; line-height:1;">&times;</button>
                                                </div>
                                                <div style="display:flex; flex-direction: column; gap: 12px; margin-bottom: 28px; max-height: 40vh; overflow-y: auto; padding-right:10px;">
                                                    @foreach($seatsGroup as $indSeat)
                                                        @php $isPaid = ($indSeat->status == 'complete'); @endphp
                                                        <div style="display:flex; justify-content: space-between; align-items: center; background: {{ $isPaid ? 'rgba(255, 94, 94, 0.05)' : 'rgba(255,255,255,0.02)' }}; padding: 16px; border-radius: 12px; border: 1px solid {{ $isPaid ? 'rgba(255, 94, 94, 0.2)' : 'rgba(255,255,255,0.05)' }};">
                                                            <div>
                                                                <div style="font-weight: 800; color: #fff; font-size: 15px;">SEAT: {{ $indSeat->seat->name ?? 'N/A' }}</div>
                                                                @if($isPaid)
                                                                    <div style="font-size: 10px; color: #ff5e5e; font-weight: 700; text-transform: uppercase; margin-top: 4px;">Verified Seat</div>
                                                                @endif
                                                            </div>
                                                            @if(!$isPaid)
                                                                <a href="{{ route('booking.delete', $indSeat->id) }}" style="color: #ff5e5e; font-size: 11px; font-weight: 900; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">Remove</a>
                                                            @else
                                                                <span style="color: var(--muted); font-size: 10px; font-weight: 800; opacity: 0.5;"><i class="fa fa-lock"></i> Locked</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div style="display:flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.06);">
                                                     <div style="color: var(--muted); font-size: 12px; font-weight: 800; text-transform: uppercase;">TO PAY: <span style="color: var(--accent); font-size: 24px; margin-left:12px; font-weight:900;">৳{{ $pendingAmount }}</span></div>
                                                     <a href="{{ route('user.payment', $pendingIds) }}" style="padding: 12px 28px; background: var(--accent); color: #000; font-weight: 900; border-radius: 8px; text-decoration: none; font-size: 12px; text-transform: uppercase; letter-spacing:1px; box-shadow: 0 10px 25px rgba(162, 224, 67, 0.3);">CHECKOUT</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
