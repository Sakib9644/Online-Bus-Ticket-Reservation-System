<div>
    @if (session()->has('message'))
        <!-- Modal Overlay -->
        <div id="flash-modal-popup" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); display: flex; align-items: center; justify-content: center; z-index: 9999;">
            <div style="background: var(--card-bg); border: 1px solid var(--border); border-radius: 20px; padding: 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); max-width: 400px; text-align: center; position: relative;">
                <div style="width: 60px; height: 60px; background: rgba(162, 224, 67, 0.1); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 20px;">
                    <i class="fa fa-info-circle"></i>
                </div>
                <h3 class="syne" style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 12px;">Notice</h3>
                <p style="color: var(--muted); font-size: 15px; margin-bottom: 24px;">{{ session('message') }}</p>
                <button type="button" onclick="document.getElementById('flash-modal-popup').style.display='none'" class="sb-btn" style="background: var(--accent); color: #0d1a09; border: none; padding: 12px 30px; border-radius: 100px; font-weight: 800; width: 100%;">Acknowledge</button>
            </div>
        </div>
    @endif

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
</div>
