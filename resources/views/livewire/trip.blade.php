<div>
    <style>
        .sb-search-input {
            width: 100%;
            height: 56px;
            background: #1a1f1a;
            border: 1px solid rgba(125, 95, 255, 0.2);
            border-radius: 12px;
            padding: 0 20px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #fff;
            color-scheme: dark;
            outline: none;
            transition: all .2s;
            cursor: pointer;
        }
        .sb-search-input:focus { border-color: var(--accent); box-shadow: 0 0 15px rgba(162, 224, 67, 0.1); }
    </style>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="glass-card" style="padding: 30px; margin-bottom: 50px; margin-top: -30px; position: relative; z-index: 10;">
        <form wire:submit.prevent="search">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">From</label>
                    <select class="sb-search-input" wire:model.live="from" required>
                        <option value="">Origin</option>
                        @foreach ($origins as $origin)
                            <option value="{{ $origin }}">{{ $origin }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">To</label>
                    <select class="sb-search-input" wire:model.live="to" required>
                        <option value="">Destination</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination }}">{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Journey Date</label>
                    <input type="date" class="sb-search-input" wire:model.live="date" style="color-scheme: dark;">
                </div>
                <div class="col-lg-3 col-md-6" style="margin-bottom: 24px;">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Departure</label>
                    <select class="sb-search-input" wire:model.live="time">
                        <option value="">All Times</option>
                        @foreach ($times as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Coach Type</label>
                    <select class="sb-search-input" wire:model.live="type">
                        <option value="">All Types</option>
                        <option value="ac">AC Coach</option>
                        <option value="non-ac">Non-AC Coach</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Course Number</label>
                    <select class="sb-search-input" wire:model.live="coach_no">
                        <option value="">All Courses</option>
                        @foreach ($coachNumbers as $no)
                            <option value="{{ $no }}">{{ $no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label style="color: var(--muted); font-size: 11px; text-transform: uppercase; font-weight: 700; margin-bottom: 8px; display: block;">Transport Name</label>
                    <select class="sb-search-input" wire:model.live="bus_name">
                        <option value="">All Names</option>
                        @foreach ($busNames as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if ($trips->count() > 0)
        <div style="margin-bottom: 50px;">
            <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                <h4 style="color: #fff; margin: 0; font-weight: 800;">Available Trips ({{ $trips->count() }})</h4>
                <div style="color: var(--muted); font-size: 13px;">Showing results for your selected route</div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 24px; padding-bottom: 60px;">
                @foreach ($trips as $trip)
                    <div class="ticket-card" style="flex-direction: row; align-items: stretch;">
                        <div class="ticket-content" style="flex: 3; display: flex; flex-direction: column; justify-content: space-between;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                 <div class="ticket-tag-green">{{ strtoupper($trip->bus->bus_type) }} COACH</div>
                                 <div style="text-align: right;">
                                    <div class="trip-time">{{ $trip->time }}</div>
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">{{ \Carbon\Carbon::parse($trip->date)->format('M d, Y') }}</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 40px; margin: 25px 0;">
                                <div style="min-width: 150px;">
                                    <div class="city-name">{{ $trip->location_from }}</div>
                                    <div class="city-label">Origin</div>
                                </div>
                                <div style="color: var(--accent); font-size: 20px; opacity: 0.6; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </div>
                                <div style="min-width: 150px;">
                                    <div class="city-name">{{ $trip->location_to }}</div>
                                    <div class="city-label">Destination</div>
                                </div>
                                <div style="flex: 1; display: flex; justify-content: flex-end;">
                                    <div style="display: inline-block; background: rgba(162, 224, 67, 0.08); color: #d1ffc4; padding: 4px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; border: 1px solid rgba(162, 224, 67, 0.1); letter-spacing: 0.5px;">COURSE {{ $trip->bus->coach_no }}</div>
                                </div>
                            </div>

                            <div class="trip-meta">
                                <div class="icon-text-group"><i class="fa fa-bus"></i> {{ $trip->bus->bus_name }}</div>
                                <div class="icon-text-group"><i class="fa-solid fa-couch"></i> {{ $trip->bus->seats->count() - $trip->bookings->count() }} Seats Available</div>
                            </div>
                        </div>

                        <div class="ticket-footer" style="flex: 1; flex-direction: column; justify-content: center; background: rgba(0,0,0,0.3); border-left: 1px solid rgba(162, 224, 67, 0.05); border-top: none; min-width: 220px; gap: 20px;">
                            <div class="fare-badge" style="text-align: center;">
                                <div class="fare-amount">৳{{ $trip->fare }}</div>
                                <div class="fare-label">Per Person</div>
                            </div>
                            <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="premium-btn" style="width: 100%; justify-content: center;">
                                SELECT SEATS <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
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
