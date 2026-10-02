<div>
    <!-- Simple Seat Limit Modal (Clean Design, Normal Font) -->
    <div id="seat-limit-modal" class="custom-modal-overlay" style="display: none;" onclick="if(event.target === this) closeSeatLimitModal()">
        <div class="custom-modal-card">
            <!-- Close Button -->
            <button type="button" class="custom-modal-close" onclick="closeSeatLimitModal()" aria-label="Close">&times;</button>
            
            <!-- Simple Clean Icon -->
            <div class="custom-modal-icon-simple">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <!-- Title -->
            <h3 class="custom-modal-title">Seat Limit Exceeded</h3>

            <!-- Message Body -->
            <div class="custom-modal-message">
                <p id="seat-limit-modal-text">
                    You cannot select more than <strong>6 seats</strong> per booking.
                </p>
                <div class="custom-modal-subtext">
                    To reserve additional seats, please complete this reservation first or book remaining seats separately.
                </div>
            </div>

            <!-- Action Button -->
            <button type="button" class="custom-modal-btn" onclick="closeSeatLimitModal()">
                <span>Understood</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <!-- Flash Modal Overlay -->
        <div id="flash-modal-popup" class="custom-modal-overlay" onclick="if(event.target === this) this.style.display='none'">
            <div class="custom-modal-card">
                <button type="button" class="custom-modal-close" onclick="document.getElementById('flash-modal-popup').style.display='none'">&times;</button>
                <div class="custom-modal-icon-wrap">
                    <div class="custom-modal-icon-pulse" style="background: radial-gradient(circle, rgba(162, 224, 67, 0.35) 0%, transparent 70%);"></div>
                    <div class="custom-modal-icon-inner" style="border-color: rgba(162, 224, 67, 0.5); color: #a2e043; background: linear-gradient(135deg, rgba(162, 224, 67, 0.2), rgba(162, 224, 67, 0.08));">
                        <i class="fa fa-info-circle"></i>
                    </div>
                </div>
                <div class="custom-modal-badge" style="color: #a2e043; border-color: rgba(162, 224, 67, 0.25); background: rgba(162, 224, 67, 0.12);">
                    <i class="fa-solid fa-circle-check"></i> NOTICE
                </div>
                <h3 class="custom-modal-title">Booking Information</h3>
                <div class="custom-modal-message">
                    <p style="font-size: 18px; color: #f1f5f9; font-weight: 600; line-height: 1.6;">{{ session('message') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('flash-modal-popup').style.display='none'" class="custom-modal-btn" style="background: linear-gradient(135deg, #a2e043, #7ab32f); color: #0c1200;">
                    <span>Acknowledge</span>
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    @endif

    <style>
        /* ─── SIMPLE CLEAN MODAL (Normal Font, Minimal Design) ─── */
        .custom-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            animation: modalFadeIn 0.2s ease-out forwards;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .custom-modal-card {
            background: #111418;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 30px 26px 26px;
            max-width: 410px;
            width: 100%;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.8);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            animation: modalZoomIn 0.2s ease-out forwards;
        }

        @keyframes modalZoomIn {
            from { transform: scale(0.96); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .custom-modal-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 22px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: color 0.2s, background 0.2s;
        }
        .custom-modal-close:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .custom-modal-icon-simple {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .custom-modal-title {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.2px;
            margin: 0 0 10px;
            line-height: 1.3;
        }

        .custom-modal-message p {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            font-size: 15px;
            font-weight: 500;
            color: #cbd5e1;
            line-height: 1.5;
            margin: 0 0 8px;
        }

        .custom-modal-message strong {
            color: #ffffff;
            font-weight: 700;
        }

        .custom-modal-subtext {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .custom-modal-btn {
            width: 100%;
            height: 44px;
            border-radius: 10px;
            background: #a2e043;
            color: #000000;
            border: none;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .custom-modal-btn:hover {
            background: #b5ec58;
            transform: translateY(-1px);
        }

        .custom-modal-btn:active {
            transform: translateY(0);
        }
    </style>

    <div class="mb-5 d-flex justify-content-center align-items-center" style="color: #fff; font-size: 20px; font-weight: 600; font-family: 'DM Sans', sans-serif;">
        <a href="javascript:history.back()" style="color: var(--muted); text-decoration: none; margin-right: 16px; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 50%; transition: all .2s;"><i class="fa fa-chevron-left" style="font-size: 14px;"></i></a>
        <span style="color: var(--muted);">{{ $trip->location_from }}</span>
        <i class="fa fa-exchange-alt mx-3" style="color: var(--muted); font-size: 12px;"></i>
        <span>{{ $trip->location_to }}</span>
    </div>

    <div class="row gx-4 align-items-start">
        
        <!-- Left Column: Trip Summary -->
        <div class="col-lg-3 mb-4">
            <div class="sb-card" style="padding: 24px; border-radius: 20px; background: var(--card-bg); border: 1px solid var(--border);">
                <div style="font-size: 11px; text-transform: uppercase; color: var(--muted); letter-spacing: 1px; font-weight: 700; margin-bottom: 24px;">Trip Summary</div>
                <h2 class="mb-4" style="font-size: clamp(18px, 2vw, 24px); font-weight: 800; color: #fff; display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
                    <span style="word-break: break-word;">{{ $trip->location_from }}</span> 
                    <i class="fa fa-arrow-right" style="font-size: 14px; color: var(--muted);"></i> 
                    <span style="word-break: break-word;">{{ $trip->location_to }}</span>
                </h2>
                <hr style="border-color: var(--border); margin-bottom: 24px;">
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; align-items: center;">
                    <span style="color: var(--muted); font-size: 14px;">Fare</span>
                    <span style="color: #fff; font-weight: 800; font-size: 20px;">৳{{ $trip->fare }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; align-items: center;">
                    <span style="color: var(--muted); font-size: 14px;">Bus Name</span>
                    <span style="color: #fff; font-weight: 600; font-size: 14px;">{{ $trip->bus->bus_name ?? 'N/A' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
                    <span style="color: var(--muted); font-size: 14px;">Bus Number</span>
                    <span style="color: #fff; font-weight: 700; font-size: 14px;">{{ $trip->bus->bus_no ?? 'N/A' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--muted); font-size: 14px;">Type</span>
                    <span style="background: rgba(255,255,255,0.1); color: #eee; font-weight: 700; font-size: 11px; padding: 4px 12px; border-radius: 12px; letter-spacing: 1px;">{{ strtoupper($trip->bus->bus_type ?? 'N/A') }}</span>
                </div>
            </div>
        </div>

        <!-- Middle Column: Date + Cabin -->
        <div class="col-lg-5 mb-4">
            
            <div style="background: var(--card-bg); padding: 20px 24px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 24px;">
                <label style="font-size: 11px; text-transform: uppercase; color: var(--muted); letter-spacing: 1px; display: block; margin-bottom: 8px;">Departure Date</label>
                <div style="font-weight: 800; font-size: 16px; color: #fff; margin-bottom: 4px;">{{ date('D, d M Y', strtotime($trip->date)) }}</div>
                <div style="font-size: 13px; color: var(--muted);">{{ $trip->time }} (Scheduled)</div>
            </div>

            @if (count($seats) > 0)
                <div class="bus-cabin" style="background: var(--card-bg); padding: 40px 20px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); max-width: 100%; border: 1px solid var(--border);">
                    <!-- Header Section -->
                    <div style="text-align:center; margin-bottom:30px;">
                        <h3 class="mb-1" style="font-size:20px; font-weight:800; color: #fff; text-transform: uppercase; letter-spacing: 1px;">{{ $trip->bus->bus_name ?? 'Select Your Seats' }}</h3>
                        <div style="display:flex; align-items:center; justify-content:center; gap:8px; font-size:12px; font-weight:600;">
                            <span style="color:var(--muted);">{{ $trip->location_from }}</span>
                            <span style="color:var(--muted); font-size:10px;"><i class="fa fa-arrow-right"></i></span>
                            <span style="color:var(--muted);">{{ $trip->location_to }}</span>
                        </div>
                    </div>

                    <!-- Legend Section -->
                    <div class="seat-legend" style="margin-bottom: 40px;">
                        <div class="legend-item"><div class="legend-box empty" style="font-weight: 400; font-size: 14px;">+</div><span>Available</span></div>
                        <div class="legend-item"><div class="legend-box chosen" style="font-size: 10px;">▶</div><span>Selected</span></div>
                        <div class="legend-item"><div class="legend-box filled" style="font-weight: 400; font-size: 14px;">✖</div><span>Booked</span></div>
                    </div>

                    <!-- Driver Box -->
                    <div style="margin: 0 auto 40px; width: 140px; background: var(--seat-empty); border-radius: 8px; padding: 8px; text-align: center; font-size: 13px; font-weight: 700; color: #fff; box-shadow: inset 0 2px 2px rgba(255,255,255,0.05), 0 4px 6px rgba(0,0,0,0.3); border: 1px solid var(--border);">
                        Driver
                    </div>

                    <!-- Seat Grid -->
                    <div class="seat-grid" style="padding: 0 10px;">
                        @php $seatGroups = $seats->chunk(4); @endphp
                        @foreach ($seatGroups as $index => $group)
                            <div style="grid-column: 1; font-size: 11px; font-weight: 700; color: #666; display: flex; align-items: center; justify-content: center;">{{ $index + 1 }}</div>

                            @foreach ($group->take(2) as $seat)
                                @php $isBooked = $booked->contains('seat_id', $seat->id); @endphp
                                <label class="seat-item {{ $isBooked ? 'booked' : 'available' }}" title="Seat {{ $seat->name }}">
                                    <input type="checkbox" value="{{ $seat->id }}" wire:model.live="selectedSeats" @if($isBooked) disabled @endif>
                                    <span class="seat-visual" style="font-size: 13px;">{{ $isBooked ? '✖' : $seat->name }}</span>
                                </label>
                            @endforeach

                            <div class="aisle"></div>

                            @foreach ($group->slice(2) as $seat)
                                @php $isBooked = $booked->contains('seat_id', $seat->id); @endphp
                                <label class="seat-item {{ $isBooked ? 'booked' : 'available' }}" title="Seat {{ $seat->name }}">
                                    <input type="checkbox" value="{{ $seat->id }}" wire:model.live="selectedSeats" @if($isBooked) disabled @endif>
                                    <span class="seat-visual" style="font-size: 13px;">{{ $isBooked ? '✖' : $seat->name }}</span>
                                </label>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-5" style="background: var(--card-bg); border-radius: 14px; border: 1px dashed var(--border);">
                    <i class="fa-solid fa-bus-simple mb-3" style="font-size: 40px; color: var(--seat-empty);"></i>
                    <p style="color: var(--muted);">Click "Refresh Availability" to see the bus layout.</p>
                </div>
            @endif
        </div>

        <!-- Right Column: Refresh & Summary -->
        <div class="col-lg-4 mb-4">
            <button wire:click.prevent="searchSeat" wire:loading.attr="disabled" class="sb-btn" style="width: 100%; margin-bottom: 24px; background: var(--accent); color: #0d1a09; border: none; padding: 16px; border-radius: 100px; font-weight: 800; font-size: 15px; box-shadow: 0 8px 25px rgba(162, 224, 67, 0.2); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;">
                 <span wire:loading.remove wire:target="searchSeat">Refresh Availability</span>
                 <span wire:loading wire:target="searchSeat"><i class="fa fa-spinner fa-spin"></i> Checking Matrix...</span>
            </button>

            <div class="booking-summary-fancy" style="position: sticky; top: 100px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border-radius: 20px; background: var(--card-bg); border: 1px solid var(--border);">
                <h4 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 16px;">Booked Summary</h4>
                
                @if(!empty($selectedSeats))
                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 14px;">
                        <span style="color:var(--muted); min-width: 100px;">Selected Seats:</span>
                        <span style="font-weight:700; color:#fff; text-align: right; word-wrap: break-word; max-width: 65%;">
                            {{ implode(', ', \App\Models\Seat::whereIn('id', $selectedSeats)->pluck('name')->toArray()) }}
                        </span>
                    </div>
                    <div class="summary-row total" style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 14px;">
                        <span style="color:var(--muted);">Total Price:</span>
                        <span style="font-weight:800; color:var(--accent); font-size: 20px;">৳{{ $totalPrice }}</span>
                    </div>


                    <button wire:click="book" wire:loading.attr="disabled" class="sb-btn-full" style="background: var(--accent); width: 100%; border: none; padding: 16px; border-radius: 12px; font-weight: 800; color: #0d1a09; font-size: 16px; box-shadow: 0 8px 25px rgba(162, 224, 67, 0.2); transition: all 0.3s;">
                        <span wire:loading.remove>Confirm Booking</span>
                        <span wire:loading><i class="fa fa-spinner fa-spin me-2"></i>Processing...</span>
                    </button>
                    
                    <a href="{{ route('booking.details') }}" class="sb-btn" style="display: block; text-align: center; text-decoration: none; width: 100%; margin-top: 12px; background: transparent; border: 1px dashed var(--border); color: #fff; font-weight: 600; border-radius: 12px;">Show Booking Details</a>
                @else
                    <div style="margin-top:20px; text-align:center; color:var(--muted); font-size:13px; padding:30px 20px; border:1px dashed var(--border); border-radius:12px;">
                        Pick your preferred seats to continue. <br>Your selections will appear here.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function showSeatLimitModal(message) {
            const modal = document.getElementById('seat-limit-modal');
            const textEl = document.getElementById('seat-limit-modal-text');
            if (modal) {
                if (textEl && message) {
                    textEl.innerHTML = message.replace('6 seats', '<strong>6 seats</strong>');
                }
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSeatLimitModal() {
            const modal = document.getElementById('seat-limit-modal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSeatLimitModal();
            }
        });

        // Listen for Livewire seat limit events
        window.addEventListener('seat-limit-exceeded', function(event) {
            const msg = event.detail?.message 
                     || (Array.isArray(event.detail) ? event.detail[0]?.message : null)
                     || 'You cannot select more than 6 seats per booking.';
            showSeatLimitModal(msg);
        });

        // Instant client-side click interceptor for seat checkboxes
        document.addEventListener('click', function(e) {
            const checkbox = e.target.closest('.seat-item input[type="checkbox"]');
            if (!checkbox) return;

            // Only check when the user is checking an unchecked seat
            if (checkbox.checked) {
                const checkedBoxes = document.querySelectorAll('.seat-grid .seat-item input[type="checkbox"]:checked');
                if (checkedBoxes.length > 6) {
                    e.preventDefault();
                    e.stopPropagation();
                    checkbox.checked = false;
                    showSeatLimitModal('You cannot select more than 6 seats per booking.');
                    return false;
                }
            }
        }, true);

        // Also intercept keyboard/change events
        document.addEventListener('change', function(e) {
            const checkbox = e.target.closest('.seat-item input[type="checkbox"]');
            if (!checkbox) return;

            if (checkbox.checked) {
                const checkedBoxes = document.querySelectorAll('.seat-grid .seat-item input[type="checkbox"]:checked');
                if (checkedBoxes.length > 6) {
                    e.preventDefault();
                    e.stopPropagation();
                    checkbox.checked = false;
                    showSeatLimitModal('You cannot select more than 6 seats per booking.');
                    return false;
                }
            }
        }, true);
    </script>
</div>
