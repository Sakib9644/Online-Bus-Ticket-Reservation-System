@extends('frontend.index')
@section('content')

<div class="section-wrap" style="padding-top:60px; min-height: 80vh; background: var(--paper);">
    <div class="container py-5">
        <div style="display: flex; justify-content: center; align-items: flex-start; min-height: 60vh;">
            <div style="width: 100%; max-width: 550px;">
                <div class="sb-card" style="border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); overflow: hidden; background: var(--card-bg);">
                    <div style="background: #111410; padding:24px; color:#fff; border-bottom: 1px solid var(--border);">
                        <h3 class="syne mb-0" style="font-size:24px; color: #fff; text-align: center;">Complete Payment</h3>
                    </div>
                    <div style="padding: 36px 30px;">
                        <div class="mb-4">
                            <label style="color:var(--muted); font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight: 700; margin-bottom: 6px; display: block;">Bus Number</label>
                            <div style="font-weight:800; font-size:20px; color: #fff;">{{ $bookings->first()->trip->bus->bus_no }}</div>
                            <div style="font-size:14px; color:var(--muted); margin-top: 4px;">Includes {{ $bookings->count() }} seat(s).</div>
                        </div>

                        @if(!$view && !empty($pendingExpiresAtIso))
                            <div style="background: rgba(241, 196, 15, 0.08); border: 1px solid rgba(241, 196, 15, 0.22); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px;">
                                <div style="font-size: 11px; color: #f1c40f; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 800; margin-bottom: 4px;">Pending Hold</div>
                                <div id="payment-expiry-countdown" style="font-size: 20px; font-weight: 800; color: #fff; line-height: 1.2;">--:--</div>
                                <div style="font-size: 12px; color: var(--muted); margin-top: 4px;">Expires at {{ $pendingExpiresAtHuman }}</div>
                            </div>
                        @endif

                        <div style="background:rgba(255,255,255,0.02); padding:20px; border-radius:12px; border:1px solid var(--border); margin-bottom:30px;">
                            <div style="display:flex; justify-content:space-between; align-items: center; margin-bottom:12px;">
                                <span style="color:var(--muted); font-weight: 500;">Total Bundle Amount</span>
                                <span style="font-weight:800; color: var(--accent); font-size:24px;">৳{{ $totalAmount }}</span>
                            </div>
                            <div style="font-size:13px; color:var(--muted);">Inclusive of all service charges and {{ $bookings->count() }} seats</div>
                        </div>

                        <div style="margin-bottom: 32px;">
                            <p style="font-size:14px; color:var(--muted); margin-bottom:14px; font-weight:600;">Supported Payment Methods</p>
                            <div style="display:flex; gap:16px; flex-wrap:wrap; font-size: 28px; color: #fff; opacity: 0.8;">
                                <i class="fa-brands fa-cc-visa"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                                <div style="font-size: 14px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; background: #e2136e; padding: 0 10px; border-radius: 4px; height: 28px;">bKash</div>
                                <div style="font-size: 14px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; background: #ed1c24; padding: 0 10px; border-radius: 4px; height: 28px;">Nagad</div>
                            </div>
                        </div>

                        @if($view == true)
                            <div style="background: rgba(141,198,63,0.1); border: 1px solid rgba(141,198,63,0.2); padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
                                <i class="fa-solid fa-circle-check" style="color: #a2e043; font-size: 32px;"></i>
                                <div>
                                    <div style="font-weight:700; color: #a2e043; font-size: 16px;">Payment Received</div>
                                    <div style="font-size:13px; color: var(--muted);">This booking bundle is completed.</div>
                                </div>
                            </div>
                            <!-- A button to view details if available -->
                        @else
                            <a href="{{ route('pay.sslcommerz', ['id' => $id]) }}" id="proceed-payment-btn" class="sb-btn" style="width: 100%; display: flex; font-size:16px; padding: 16px; background: #a2e043; color: #0d1a09; font-weight: 800; border-radius: 12px; text-decoration: none; justify-content: center; border: none; align-items: center; transition: background 0.2s;">
                                <i class="fa fa-lock ms-0 me-2" style="font-size: 14px;"></i> Proceed to Pay ৳{{ $totalAmount }}
                            </a>
                            <p class="text-center mt-3" style="font-size:12px; color:var(--muted); text-align: center; margin-top: 16px;">
                                Secure payment powered by SSLCommerz
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$view && !empty($pendingExpiresAtIso))
<script>
document.addEventListener('DOMContentLoaded', function () {
    var expiryTimestamp = new Date("{{ $pendingExpiresAtIso }}").getTime();
    var countdownEl = document.getElementById('payment-expiry-countdown');
    var payBtn = document.getElementById('proceed-payment-btn');

    if (!countdownEl) {
        return;
    }

    function pad(value) {
        return value < 10 ? '0' + value : '' + value;
    }

    function updateCountdown() {
        var now = new Date().getTime();
        var diff = expiryTimestamp - now;

        if (diff <= 0) {
            countdownEl.textContent = 'Expired';

            if (payBtn) {
                payBtn.removeAttribute('href');
                payBtn.style.pointerEvents = 'none';
                payBtn.style.opacity = '0.55';
                payBtn.style.background = '#6b7280';
                payBtn.innerHTML = '<i class="fa fa-clock me-2" style="font-size: 14px;"></i> Booking Expired';
            }

            return;
        }

        var totalSeconds = Math.floor(diff / 1000);
        var minutes = Math.floor(totalSeconds / 60);
        var seconds = totalSeconds % 60;

        countdownEl.textContent = pad(minutes) + ':' + pad(seconds) + ' remaining';
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endif

@endsection
