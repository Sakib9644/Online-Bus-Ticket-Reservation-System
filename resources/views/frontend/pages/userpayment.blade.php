@extends('frontend.index')
@section('content')

@php
    $sslActive = setting('sslcommerz_active', '1') == '1';
    $bkashActive = setting('bkash_active', '1') == '1';
    $nagadActive = setting('nagad_active', '1') == '1';
    $rocketActive = setting('rocket_active', '0') == '1';

    $hasAnyMethod = $sslActive || $bkashActive || $nagadActive || $rocketActive;
    $defaultTab = $sslActive ? 'ssl' : ($bkashActive ? 'bkash' : ($nagadActive ? 'nagad' : ($rocketActive ? 'rocket' : 'none')));
@endphp

<div class="section-wrap" style="padding-top:60px; min-height: 80vh; background: var(--paper);">
    <div class="container py-4">
        <div style="display: flex; justify-content: center; align-items: flex-start; min-height: 60vh;">
            <div style="width: 100%; max-width: 600px;">
                <div class="sb-card" style="border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); overflow: hidden; background: var(--card-bg); border-radius: 20px;">
                    <div style="background: #111410; padding: 22px 28px; color: #fff; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 class="syne mb-0" style="font-size: 22px; color: #fff; font-weight: 800; letter-spacing: -0.5px;">Complete Payment</h3>
                            <p style="margin: 0; font-size: 12px; color: var(--muted); margin-top: 2px;">Secure checkout for your reserved seats</p>
                        </div>
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(162, 224, 67, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>

                    <div style="padding: 28px;">
                        {{-- Booking overview --}}
                        <div class="mb-4" style="background: rgba(255,255,255,0.02); padding: 18px 20px; border-radius: 14px; border: 1px solid var(--border);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Vehicle / Coach</span>
                                <span style="font-family: monospace; font-weight: 800; color: #fff; font-size: 15px;">{{ $bookings->first()->trip?->bus?->coach_no ?? $bookings->first()->trip?->bus?->bus_no ?? 'Coach #N/A' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--muted); font-size: 13px;">{{ $bookings->first()->trip?->bus?->bus_name ?? 'Bus' }} ({{ $bookings->count() }} seat{{ $bookings->count() > 1 ? 's' : '' }})</span>
                                <span style="font-size: 13px; font-weight: 700; color: #fff;">
                                    {{ $bookings->map(fn($b) => $b->seat?->name)->filter()->implode(', ') }}
                                </span>
                            </div>
                        </div>

                        {{-- Pending Hold 15-Minute Countdown --}}
                        @if(!$view && !empty($pendingExpiresAtIso))
                            <div style="background: rgba(241, 196, 15, 0.08); border: 1px solid rgba(241, 196, 15, 0.25); border-radius: 14px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <div style="font-size: 11px; color: #f1c40f; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #f1c40f; display: inline-block; box-shadow: 0 0 8px #f1c40f;"></span>
                                        Reservation Hold
                                    </div>
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 2px;">Expires at {{ $pendingExpiresAtHuman }}</div>
                                </div>
                                <div id="payment-expiry-countdown" style="font-size: 18px; font-weight: 800; color: #fbbf24; font-family: monospace;">--:--</div>
                            </div>
                        @endif

                        {{-- Total Amount Pill --}}
                        <div style="background: rgba(162, 224, 67, 0.05); padding: 16px 20px; border-radius: 14px; border: 1px solid rgba(162, 224, 67, 0.2); margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #cbd5e1; font-weight: 600; font-size: 14px;">Total Payable</span>
                            <span style="font-weight: 900; color: var(--accent); font-size: 26px;">৳{{ $totalAmount }}</span>
                        </div>

                        @if($view == true)
                            <div style="background: rgba(141,198,63,0.1); border: 1px solid rgba(141,198,63,0.25); padding: 20px; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
                                <i class="fa-solid fa-circle-check" style="color: #a2e043; font-size: 32px;"></i>
                                <div>
                                    <div style="font-weight: 800; color: #a2e043; font-size: 16px;">Payment Received</div>
                                    <div style="font-size: 13px; color: var(--muted);">This booking bundle is fully confirmed and paid.</div>
                                </div>
                            </div>
                            <a href="{{ route('view.info', ['id' => $id]) }}" class="sb-btn" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; background: var(--accent); color: #000; font-weight: 800; border-radius: 12px; text-decoration: none;">
                                <i class="fa fa-file-pdf"></i> View & Print Ticket
                            </a>
                        @else
                            {{-- PAYMENT METHOD SELECTOR TABS --}}
                            <div style="margin-bottom: 20px;">
                                <label style="font-size: 12px; text-transform: uppercase; color: var(--muted); font-weight: 700; letter-spacing: 0.8px; margin-bottom: 10px; display: block;">Select Payment Method</label>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 10px;">
                                    @if($sslActive)
                                        <button type="button" class="pay-method-tab {{ $defaultTab == 'ssl' ? 'active' : '' }}" onclick="switchPayTab('ssl', this)" style="padding: 12px 10px; border-radius: 10px; border: 1.5px solid var(--border); background: rgba(255,255,255,0.03); color: #fff; cursor: pointer; text-align: center; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                            <i class="fa-solid fa-credit-card" style="display: block; font-size: 18px; margin-bottom: 4px; color: #3b82f6;"></i>
                                            SSLCommerz
                                        </button>
                                    @endif

                                    @if($bkashActive)
                                        <button type="button" class="pay-method-tab {{ $defaultTab == 'bkash' ? 'active' : '' }}" onclick="switchPayTab('bkash', this)" style="padding: 12px 10px; border-radius: 10px; border: 1.5px solid var(--border); background: rgba(255,255,255,0.03); color: #fff; cursor: pointer; text-align: center; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                            <span style="display: block; font-size: 16px; font-weight: 900; color: #e2136e; margin-bottom: 4px;">bKash</span>
                                            bKash
                                        </button>
                                    @endif

                                    @if($nagadActive)
                                        <button type="button" class="pay-method-tab {{ $defaultTab == 'nagad' ? 'active' : '' }}" onclick="switchPayTab('nagad', this)" style="padding: 12px 10px; border-radius: 10px; border: 1.5px solid var(--border); background: rgba(255,255,255,0.03); color: #fff; cursor: pointer; text-align: center; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                            <span style="display: block; font-size: 16px; font-weight: 900; color: #ed1c24; margin-bottom: 4px;">Nagad</span>
                                            Nagad
                                        </button>
                                    @endif

                                    @if($rocketActive)
                                        <button type="button" class="pay-method-tab {{ $defaultTab == 'rocket' ? 'active' : '' }}" onclick="switchPayTab('rocket', this)" style="padding: 12px 10px; border-radius: 10px; border: 1.5px solid var(--border); background: rgba(255,255,255,0.03); color: #fff; cursor: pointer; text-align: center; font-size: 12px; font-weight: 700; transition: all 0.2s;">
                                            <span style="display: block; font-size: 16px; font-weight: 900; color: #8c3494; margin-bottom: 4px;">Rocket</span>
                                            Rocket
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- TAB CONTENT: SSLCOMMERZ --}}
                            @if($sslActive)
                                <div id="tab-content-ssl" class="pay-content-panel" style="display: {{ $defaultTab == 'ssl' ? 'block' : 'none' }};">
                                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 14px; padding: 20px; margin-bottom: 20px;">
                                        <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px; font-size: 26px; color: #fff; opacity: 0.85;">
                                            <i class="fa-brands fa-cc-visa"></i>
                                            <i class="fa-brands fa-cc-mastercard"></i>
                                            <span style="font-size: 12px; font-weight: 800; background: #e2136e; padding: 2px 8px; border-radius: 4px;">bKash</span>
                                            <span style="font-size: 12px; font-weight: 800; background: #ed1c24; padding: 2px 8px; border-radius: 4px;">Nagad</span>
                                            <span style="font-size: 11px; font-weight: 600; color: var(--muted);">& more</span>
                                        </div>
                                        <p style="font-size: 13px; color: var(--muted); margin: 0; line-height: 1.5;">
                                            Pay securely using any Visa, Mastercard, AMEX, Internet Banking, or Mobile Wallet via the SSLCommerz gateway.
                                        </p>
                                    </div>

                                    <a href="{{ route('pay.sslcommerz', ['id' => $id]) }}" id="proceed-payment-btn" class="sb-btn" style="width: 100%; display: flex; font-size: 16px; padding: 16px; background: #a2e043; color: #0d1a09; font-weight: 800; border-radius: 12px; text-decoration: none; justify-content: center; border: none; align-items: center; gap: 8px;">
                                        <i class="fa fa-lock"></i> Proceed to Pay ৳{{ $totalAmount }}
                                    </a>
                                </div>
                            @endif

                            {{-- TAB CONTENT: BKASH --}}
                            @if($bkashActive)
                                <div id="tab-content-bkash" class="pay-content-panel" style="display: {{ $defaultTab == 'bkash' ? 'block' : 'none' }};">
                                    <div style="background: rgba(226, 19, 110, 0.06); border: 1.5px solid rgba(226, 19, 110, 0.3); border-radius: 14px; padding: 18px; margin-bottom: 20px;">
                                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                            <div style="width: 44px; height: 44px; background: #e2136e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <span style="font-weight: 900; font-size: 16px; color: #fff;">b</span>
                                            </div>
                                            <div>
                                                <div style="font-size: 15px; font-weight: 800; color: #fff;">Pay with bKash</div>
                                                <div style="font-size: 12px; color: var(--muted);">Direct payment via bKash Checkout</div>
                                            </div>
                                        </div>
                                        <p style="font-size: 12px; color: var(--muted); margin: 0; line-height: 1.5;">
                                            Click the button below to pay securely through bKash. You will be redirected to bKash to complete the payment, then returned here automatically.
                                        </p>
                                    </div>

                                    <a href="{{ route('bkash.pay', ['id' => $id]) }}" class="sb-btn" style="width: 100%; display: flex; font-size: 16px; padding: 16px; background: #e2136e; color: #fff; font-weight: 800; border-radius: 12px; text-decoration: none; justify-content: center; border: none; align-items: center; gap: 10px; box-shadow: 0 4px 20px rgba(226, 19, 110, 0.4); transition: all 0.2s;">
                                        <i class="fa fa-lock"></i> Pay ৳{{ $totalAmount }} with bKash
                                    </a>

                                    <div style="text-align: center; margin-top: 10px;">
                                        <span style="font-size: 11px; color: #64748b;"><i class="fa fa-shield-halved" style="margin-right: 4px;"></i> Secured by bKash Tokenized Checkout (Sandbox)</span>
                                    </div>
                                </div>
                            @endif

                            {{-- TAB CONTENT: NAGAD --}}
                            @if($nagadActive)
                                <div id="tab-content-nagad" class="pay-content-panel" style="display: {{ $defaultTab == 'nagad' ? 'block' : 'none' }};">
                                    <div style="background: rgba(237, 28, 36, 0.06); border: 1.5px solid rgba(237, 28, 36, 0.3); border-radius: 14px; padding: 18px; margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #ed1c24; letter-spacing: 0.5px;">Nagad {{ setting('nagad_type', 'Personal') }} Number</span>
                                            <span style="font-size: 10px; background: #ed1c24; color: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 700;">{{ setting('nagad_type', 'Personal') }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(237, 28, 36, 0.2);">
                                            <span style="font-family: monospace; font-size: 18px; font-weight: 800; color: #fff;" id="nagadNumText">{{ setting('nagad_number', '01855621000') }}</span>
                                            <button type="button" onclick="copyNumber('nagadNumText', this)" style="background: rgba(237, 28, 36, 0.2); border: 1px solid #ed1c24; color: #fff; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; cursor: pointer;">
                                                <i class="fa fa-copy"></i> Copy
                                            </button>
                                        </div>
                                        <p style="font-size: 12px; color: var(--muted); margin-top: 10px; margin-bottom: 0; line-height: 1.4;">
                                            {{ setting('nagad_instructions', 'Send Money or Payment to the number above, then submit your Nagad Transaction ID below.') }}
                                        </p>
                                    </div>

                                    <form action="{{ route('user.payment.store', ['id' => $id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="Nagad">

                                        <div style="margin-bottom: 14px;">
                                            <label style="font-size: 12px; font-weight: 700; color: #cbd5e1; display: block; margin-bottom: 6px;">Sender Nagad Number (Optional)</label>
                                            <input type="text" name="sender_number" class="admin-input" placeholder="e.g. 018XXXXXXXX" style="background: rgba(255,255,255,0.03); color: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 12px 14px; width: 100%;">
                                        </div>

                                        <div style="margin-bottom: 18px;">
                                            <label style="font-size: 12px; font-weight: 700; color: #cbd5e1; display: block; margin-bottom: 6px;">Nagad Transaction ID (TrxID) <span style="color: #ef4444;">*</span></label>
                                            <input type="text" name="transaction_id" required class="admin-input" placeholder="e.g. 8M3N6P9QR1" style="background: rgba(255,255,255,0.03); color: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 12px 14px; width: 100%; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                                        </div>

                                        <button type="submit" class="sb-btn" style="width: 100%; display: flex; font-size: 15px; padding: 15px; background: #ed1c24; color: #fff; font-weight: 800; border-radius: 12px; border: none; justify-content: center; align-items: center; gap: 8px; cursor: pointer;">
                                            <i class="fa fa-check-circle"></i> Verify & Confirm Nagad Payment
                                        </button>
                                    </form>
                                </div>
                            @endif

                            {{-- TAB CONTENT: ROCKET --}}
                            @if($rocketActive)
                                <div id="tab-content-rocket" class="pay-content-panel" style="display: {{ $defaultTab == 'rocket' ? 'block' : 'none' }};">
                                    <div style="background: rgba(140, 52, 148, 0.06); border: 1.5px solid rgba(140, 52, 148, 0.3); border-radius: 14px; padding: 18px; margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #a855f7; letter-spacing: 0.5px;">Rocket Account Number</span>
                                            <span style="font-size: 10px; background: #8c3494; color: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 700;">{{ setting('rocket_type', 'Personal') }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(140, 52, 148, 0.2);">
                                            <span style="font-family: monospace; font-size: 18px; font-weight: 800; color: #fff;" id="rocketNumText">{{ setting('rocket_number', '019855621008') }}</span>
                                            <button type="button" onclick="copyNumber('rocketNumText', this)" style="background: rgba(140, 52, 148, 0.2); border: 1px solid #8c3494; color: #fff; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; cursor: pointer;">
                                                <i class="fa fa-copy"></i> Copy
                                            </button>
                                        </div>
                                        <p style="font-size: 12px; color: var(--muted); margin-top: 10px; margin-bottom: 0; line-height: 1.4;">
                                            {{ setting('rocket_instructions', 'Send Money or Payment to the number above, then submit your Rocket Transaction ID below.') }}
                                        </p>
                                    </div>

                                    <form action="{{ route('user.payment.store', ['id' => $id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="Rocket">

                                        <div style="margin-bottom: 14px;">
                                            <label style="font-size: 12px; font-weight: 700; color: #cbd5e1; display: block; margin-bottom: 6px;">Sender Rocket Number (Optional)</label>
                                            <input type="text" name="sender_number" class="admin-input" placeholder="e.g. 019XXXXXXXX" style="background: rgba(255,255,255,0.03); color: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 12px 14px; width: 100%;">
                                        </div>

                                        <div style="margin-bottom: 18px;">
                                            <label style="font-size: 12px; font-weight: 700; color: #cbd5e1; display: block; margin-bottom: 6px;">Rocket Transaction ID <span style="color: #ef4444;">*</span></label>
                                            <input type="text" name="transaction_id" required class="admin-input" placeholder="e.g. 7X9Y1Z2AB3" style="background: rgba(255,255,255,0.03); color: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 12px 14px; width: 100%; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                                        </div>

                                        <button type="submit" class="sb-btn" style="width: 100%; display: flex; font-size: 15px; padding: 15px; background: #8c3494; color: #fff; font-weight: 800; border-radius: 12px; border: none; justify-content: center; align-items: center; gap: 8px; cursor: pointer;">
                                            <i class="fa fa-check-circle"></i> Verify & Confirm Rocket Payment
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if(!$hasAnyMethod)
                                <div style="text-align: center; padding: 30px 20px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 14px;">
                                    <i class="fa fa-circle-exclamation" style="font-size: 28px; color: #ef4444; margin-bottom: 10px; display: block;"></i>
                                    <div style="font-weight: 700; color: #f87171;">No Payment Gateway Currently Active</div>
                                    <p style="font-size: 12px; color: var(--muted); margin-top: 4px; margin-bottom: 0;">Please contact customer support hotline at {{ setting('helpline', '16374') }} to complete this reservation.</p>
                                </div>
                            @endif

                            {{-- Pay Later Link --}}
                            <a href="{{ route('booking.details') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; margin-top: 14px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: #94a3b8; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-clock"></i> Pay Later (Held in My Bookings for 15 mins)
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pay-method-tab.active {
    border-color: var(--accent) !important;
    background: rgba(162, 224, 67, 0.12) !important;
    color: var(--accent) !important;
    box-shadow: 0 0 15px rgba(162, 224, 67, 0.2);
}
</style>

<script>
function switchPayTab(tabName, btn) {
    document.querySelectorAll('.pay-method-tab').forEach(function(t) {
        t.classList.remove('active');
    });
    btn.classList.add('active');

    document.querySelectorAll('.pay-content-panel').forEach(function(p) {
        p.style.display = 'none';
    });

    var targetPanel = document.getElementById('tab-content-' + tabName);
    if (targetPanel) {
        targetPanel.style.display = 'block';
    }
}

function copyNumber(elementId, btn) {
    var text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(function() {
        var originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
        setTimeout(function() {
            btn.innerHTML = originalHtml;
        }, 2000);
    });
}

@if(!$view && !empty($pendingExpiresAtIso))
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
@endif
</script>

@endsection
