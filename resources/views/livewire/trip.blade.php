<div>
    <style>
        .sb-search-input {
            width: 100%;
            height: 56px;
            background: #1c201b;
            border: 1px solid #2c332a;
            border-radius: 12px;
            padding: 0 20px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #fff;
            color-scheme: dark;
            outline: none;
            transition: border-color .2s;
            cursor: pointer;
        }
        .sb-search-input:focus { border-color: var(--accent); }
    </style>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="glass-card" style="padding: 30px; margin-bottom: 50px; margin-top: -30px; position: relative; z-index: 10;">
        <form wire:submit.prevent="search">
            <div class="row g-3">
                <div class="col-lg-3 col-md-4">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">From</label>
                    <select class="sb-search-input" wire:model="from" required>
                        <option value="">Select Origin</option>
                        @foreach ($locations->unique('location_from') as $location)
                            <option value="{{ $location->location_from }}">{{ $location->location_from }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">To</label>
                    <select class="sb-search-input" wire:model="to" required>
                        <option value="">Select Destination</option>
                        @foreach ($locations->unique('location_to') as $location)
                            <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Journey Date</label>
                    <input type="date" class="sb-search-input" wire:model="date" style="color-scheme: dark;">
                </div>
                <div class="col-lg-3 col-md-12">
                    <label style="visibility: hidden; font-size: 11px; margin-bottom: 8px; display: block;">Search</label>
                    <button type="submit" class="sb-btn sb-btn-accent" style="width: 100%; height: 56px; border-radius: 12px; font-weight: 700;">
                        <i class="fa fa-search me-2"></i> REFRESH SEARCH
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if ($trips->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 24px; padding-bottom: 100px;">
            <div style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                <h4 class="syne" style="color: #fff; margin: 0;">Available Trips ({{ $trips->count() }})</h4>
                <div style="color: var(--muted); font-size: 13px;">Showing results for your selected route</div>
            </div>
            @foreach ($trips as $trip)
                <div class="ticket-card" style="min-height: 180px;">
                    <div class="ticket-left" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <span class="sb-badge" style="background: rgba(141,198,63,0.1); color: var(--accent); margin-bottom: 8px;">{{ strtoupper($trip->bus->bus_type) }} COACH</span>
                                <div style="display: flex; align-items: center; gap: 24px; margin-top: 15px;">
                                    <div>
                                        <div class="syne" style="font-size: 26px; font-weight: 800; color: #fff;">{{ $trip->location_from }}</div>
                                        <div style="font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px;">Departure</div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 0 15px;">
                                        <div style="width: 60px; height: 1px; background: var(--border);"></div>
                                        <i class="fa fa-shuttle-van" style="color: var(--accent); font-size: 16px;"></i>
                                        <div style="width: 60px; height: 1px; background: var(--border);"></div>
                                    </div>
                                    <div>
                                        <div class="syne" style="font-size: 26px; font-weight: 800; color: #fff;">{{ $trip->location_to }}</div>
                                        <div style="font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px;">Arrival</div>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 18px; font-weight: 800; color: #fff;">{{ $trip->time }}</div>
                                <div style="font-size: 13px; color: var(--muted);">{{ date('M d, Y', strtotime($trip->date)) }}</div>
                                <div style="margin-top: 10px;">
                                    <span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; color: var(--muted);">REF #{{ $trip->id }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 32px; align-items: center; padding-top: 24px; border-top: 1px dashed rgba(255,255,255,0.1);">
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
                                <i class="fa fa-bus" style="color: var(--accent);"></i>
                                <span style="color: #fff; font-weight: 600;">{{ $trip->bus->bus_name }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
                                <i class="fa-solid fa-couch" style="color: var(--accent);"></i>
                                <span style="color: #fff; font-weight: 600;">{{ $trip->bus->seats->count() - $trip->bus->booking->count() }} Seats Available</span>
                            </div>
                             <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
                                <i class="fa-solid fa-bolt" style="color: var(--accent);"></i>
                                <span style="color: var(--muted);">Fast Booking</span>
                            </div>
                        </div>
                    </div>
                    <div class="ticket-right">
                        <div style="font-size: 12px; color: var(--muted); margin-bottom: 4px;">Per Seat</div>
                        <div class="syne" style="font-size: 36px; font-weight: 900; color: #fff;">৳{{ $trip->fare }}</div>
                        <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="sb-btn sb-btn-accent" style="width: 100%; text-align: center; text-decoration: none; margin-top: 24px; padding: 14px 0; font-weight: 800; letter-spacing: 1px;">SELECT SEAT</a>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if ($trips->count() >= $perPage)
            <div class="text-center" style="margin-bottom: 100px;">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="sb-btn" style="padding: 16px 40px; font-weight: 700;">
                    <span wire:loading.remove wire:target="loadMore">SHOW MORE RESULTS <i class="fa-solid fa-arrow-down ms-2"></i></span>
                    <span wire:loading wire:target="loadMore"><i class="fa fa-spinner fa-spin ms-2"></i> LOADING...</span>
                </button>
            </div>
        @endif
    @else
        <div class="glass-card text-center" style="padding: 100px 40px; border-style: dashed; margin-bottom: 100px;">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i class="fa fa-bus" style="font-size: 40px; color: var(--muted);"></i>
            </div>
            <h3 class="syne" style="color: #fff; margin-bottom: 12px;">No trips available</h3>
            <p style="color: var(--muted); max-width: 400px; margin: 0 auto;">We couldn't find any trips for this route. Try changing the cities or selecting another date.</p>
            <button wire:click="$set('from', '')" class="sb-btn" style="margin-top: 30px;">Clear Filters</button>
        </div>
    @endif
</div>
