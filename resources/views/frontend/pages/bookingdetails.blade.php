@extends('frontend.index')
@section('content')

<div class="section-wrap" style="padding-top:60px; min-height: 80vh; background: var(--paper);">
    
    @if (session()->has('message') || session()->has('msg') || session()->has('success'))
        <div style="background: rgba(162, 224, 67, 0.12); border: 1px solid rgba(162, 224, 67, 0.35); border-radius: 12px; padding: 16px 20px; color: #a2e043; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('message') ?? session('msg') ?? session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 16px 20px; color: #f87171; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 8px;">My Booking History</h1>
            <p style="color: var(--muted); font-size: 15px;">Pending unpaid tickets are held for 15 minutes. Complete payment to secure your seats.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('frontend.reserve') }}" class="sb-btn" style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:var(--accent); color:#000; font-weight:800; border-radius:10px; text-decoration:none; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                <i class="fa fa-plus"></i> Book Another Trip
            </a>
        </div>
    </div>

    <div class="sb-card" style="padding: 0; overflow: hidden; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); background: var(--card-bg);">
        <div class="table-responsive">
            <table class="table" style="margin-bottom: 0; color: #fff; border-collapse: collapse;">
                <thead style="background: rgba(255,255,255,0.02);">
                    <tr>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Course Number</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Bus & Journey Detail</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Payment & Hold Status</th>
                        <th style="padding: 24px 20px; font-weight: 800; color: var(--muted); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Actions</th>
                    </tr>
                </thead>
                <tbody style="font-family: 'DM Sans', sans-serif;">
                    @forelse ($groupedDetails as $groupKey => $seatsGroup)
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
                            $seatNames = $seatsGroup->map(fn($s) => $s->seat?->name ?? 'N/A')->implode(', ');
                            $ticketRef = $first->ticket_no ?: ('TRIP-' . $first->trip_id);
                            $bus = $first->seat?->bus ?? $first->trip?->bus;
                            $courseNo = $bus?->coach_no ?? $bus?->bus_no ?? 'N/A';
                            $busName = $bus?->bus_name ?? 'Bus Service';
                            $pendingExpiryAt = $pendingSeats->min('expires_at');
                            $modalId = 'modal-' . md5($groupKey);
                        @endphp
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.1); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='rgba(0,0,0,0.1)'">
                            <td style="padding: 28px 20px; align-content: center;">
                                <div style="font-weight: 900; color: var(--accent); font-size: 26px; letter-spacing: 0.5px; line-height: 1;">{{ $courseNo }}</div>
                                <div style="font-size: 11px; color: var(--muted); margin-top: 8px; text-transform: uppercase;">Booking {{ $ticketRef }}</div>
                            </td>
                            <td style="padding: 28px 20px; align-content: center;">
                                <div style="display: flex; align-items: center; gap: 18px;">
                                    <div style="width: 44px; height: 44px; background: rgba(162, 224, 67, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(162, 224, 67, 0.2); flex-shrink:0;">
                                        <i class="fa fa-shuttle-van" style="color: var(--accent); font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: #fff; font-size: 17px; line-height: 1.2;">{{ $busName }}</div>
                                        <div style="font-size: 12px; color: var(--muted); margin-top: 6px; font-weight: 600;">Seats: <span style="color: #fff;">{{ $seatNames }}</span></div>
                                        <div style="font-size: 11px; color: var(--muted); margin-top: 3px; text-transform: uppercase; letter-spacing:0.5px; opacity:0.7;">{{ date('D, d M Y', strtotime($first->date)) }} | {{ $first->time }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 28px 20px; align-content: center;">
                                @if($pendingSeats->count() == 0)
                                    <div style="font-size: 12px; color: #2ecc71; font-weight: 700;"><i class="fa fa-check-circle me-1"></i> Fully Paid</div>
                                    <div style="font-size: 10px; color: var(--muted); margin-top: 4px;">Confirmed (SSLCommerz/Manual)</div>
                                @elseif($confirmedSeats->count() > 0)
                                    <div style="font-size: 12px; color: #f1c40f; font-weight: 700;"><i class="fa fa-circle-half-stroke me-1"></i> Partially Paid</div>
                                    <div style="font-size: 10px; color: var(--muted); margin-top: 4px; opacity:0.8;">Some seats are paid, remaining payment required</div>
                                    @if($pendingExpiryAt)
                                        <div class="pending-countdown-box" data-expiry="{{ $pendingExpiryAt->toIso8601String() }}" style="margin-top: 8px; display: inline-flex; align-items: center; gap: 6px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 6px; padding: 4px 10px; color: #fbbf24; font-size: 11px; font-weight: 700;">
                                            <i class="fa-solid fa-stopwatch"></i> <span class="countdown-display">Calculating...</span>
                                        </div>
                                    @endif
                                @else
                                    <div style="display:inline-flex; align-items:center; gap:6px; background:rgba(245, 158, 11, 0.12); border:1px solid rgba(245, 158, 11, 0.3); border-radius:6px; padding:3px 8px; color:#fbbf24; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:#f59e0b; display:inline-block; box-shadow:0 0 8px #f59e0b;"></span>
                                        Awaiting Payment
                                    </div>
                                    @if($pendingExpiryAt)
                                        <div class="pending-countdown-box" data-expiry="{{ $pendingExpiryAt->toIso8601String() }}" style="margin-top: 8px; display: flex; align-items: center; gap: 6px; color: #fbbf24; font-size: 12px; font-weight: 700; font-family: monospace;">
                                            <i class="fa-solid fa-stopwatch" style="color:#f59e0b;"></i> <span class="countdown-display">Calculating...</span>
                                        </div>
                                        <div style="font-size: 10px; color: var(--muted); margin-top: 2px;">Hold expires at {{ $pendingExpiryAt->format('h:i A, d M') }}</div>
                                    @endif
                                @endif
                            </td>
                            <td style="padding: 28px 20px; align-content: center;">
                                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                                    @if ($pendingSeats->count() > 0)
                                        <a class="sb-btn" href="{{ route('user.payment', $pendingIds) }}" style="padding: 12px 24px; font-size: 11px; font-weight: 900; border-radius: 6px; background: var(--accent); color: #000; text-decoration: none; border: none; text-transform: uppercase; letter-spacing:0.5px; box-shadow: 0 4px 15px rgba(162, 224, 67, 0.3); display:inline-flex; align-items:center; gap:6px;">
                                            <i class="fa fa-lock"></i> PAY ৳{{ $pendingAmount }}
                                        </a>
                                        <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='flex'" style="padding: 12px 20px; font-size: 10px; font-weight: 800; border-radius: 6px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; text-transform: uppercase; letter-spacing:0.5px;">Manage</button>
                                    @endif

                                    @if ($confirmedSeats->count() > 0)
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 7px 16px; border-radius: 50px; font-weight: 800; font-size: 10px; border: 1px solid rgba(46, 204, 113, 0.2); text-transform: uppercase; letter-spacing: 0.5px;">{{ $pendingSeats->count() > 0 ? 'PARTIAL CONFIRMED' : 'Paid & Confirmed' }}</div>
                                            <a href="{{ route('view.info', $confirmedIds) }}" style="color: #fff; font-weight: 800; font-size: 11px; text-decoration: none; border: 1px solid rgba(162, 224, 67, 0.4); padding: 8px 18px; border-radius: 8px; background: rgba(162, 224, 67, 0.08); text-transform: uppercase; letter-spacing:0.5px; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px;" onmouseover="this.style.background='var(--accent)'; this.style.color='#000'" onmouseout="this.style.background='rgba(162, 224, 67, 0.08)'; this.style.color='#fff'"><i class="fa-solid fa-file-pdf"></i> Download Ticket PDF</a>
                                        </div>
                                    @endif
                                </div>

                                @if ($pendingSeats->count() > 0)
                                    <!-- Modal: Manage Pending Seats -->
                                    <div id="{{ $modalId }}" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); align-items: center; justify-content: center; z-index: 9999;">
                                        <div style="background: var(--card-alt); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 40px; box-shadow: 0 40px 100px rgba(0,0,0,0.8); width: 95%; max-width: 500px; position: relative;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 16px;">
                                                <h3 style="color: #fff; font-size: 22px; font-weight: 800; margin: 0; letter-spacing:-0.5px;">Manage Pending Seats</h3>
                                                <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='none'" style="background: transparent; color: var(--muted); border: none; font-size: 32px; cursor: pointer; padding: 0; line-height:1;">&times;</button>
                                            </div>
                                            <div style="display:flex; flex-direction: column; gap: 12px; margin-bottom: 28px; max-height: 40vh; overflow-y: auto; padding-right:10px;">
                                                @foreach($seatsGroup as $indSeat)
                                                    @php $isPaid = (strtolower($indSeat->status) == 'complete'); @endphp
                                                    <div style="display:flex; justify-content: space-between; align-items: center; background: {{ $isPaid ? 'rgba(255, 94, 94, 0.05)' : 'rgba(255,255,255,0.02)' }}; padding: 16px; border-radius: 12px; border: 1px solid {{ $isPaid ? 'rgba(255, 94, 94, 0.2)' : 'rgba(255,255,255,0.05)' }};">
                                                        <div>
                                                            <div style="font-weight: 800; color: #fff; font-size: 15px;">SEAT: {{ $indSeat->seat?->name ?? 'N/A' }}</div>
                                                            @if($isPaid)
                                                                <div style="font-size: 10px; color: #ff5e5e; font-weight: 700; text-transform: uppercase; margin-top: 4px;">Verified Seat</div>
                                                            @endif
                                                        </div>
                                                        @if(!$isPaid)
                                                            <a href="{{ route('booking.delete', $indSeat->id) }}" data-confirm="Remove seat {{ $indSeat->seat?->name }} from this booking?" style="color: #ff5e5e; font-size: 11px; font-weight: 900; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">Remove</a>
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
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 70px 20px;">
                                <div style="max-width: 440px; margin: 0 auto;">
                                    <div style="width: 72px; height: 72px; background: rgba(162, 224, 67, 0.08); border: 1px solid rgba(162, 224, 67, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                        <i class="fa-solid fa-ticket-simple" style="font-size: 32px; color: var(--accent);"></i>
                                    </div>
                                    <h4 style="color: #fff; font-weight: 800; font-size: 22px; margin-bottom: 8px;">No Active Bookings</h4>
                                    <p style="color: var(--muted); font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
                                        You don't have any bookings yet. When you pick seats for a trip, your reservation is held here for <strong>15 minutes</strong> while you complete payment.
                                    </p>
                                    <a href="{{ route('frontend.reserve') }}" class="sb-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 30px; background: var(--accent); color: #000; font-weight: 800; border-radius: 10px; text-decoration: none; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">
                                        <i class="fa fa-magnifying-glass"></i> Browse Trips & Book
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function pad(n) { return n < 10 ? '0' + n : n; }

    function updateCountdowns() {
        var now = new Date().getTime();
        document.querySelectorAll('.pending-countdown-box').forEach(function(el) {
            var expiryIso = el.getAttribute('data-expiry');
            if (!expiryIso) return;

            var target = new Date(expiryIso).getTime();
            var diff = target - now;
            var display = el.querySelector('.countdown-display');

            if (diff <= 0) {
                if (display) display.textContent = 'Hold Expired';
                el.style.color = '#ef4444';
            } else {
                var totalSec = Math.floor(diff / 1000);
                var mins = Math.floor(totalSec / 60);
                var secs = totalSec % 60;
                if (display) {
                    display.textContent = pad(mins) + ':' + pad(secs) + ' remaining';
                }
            }
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>

@endsection
