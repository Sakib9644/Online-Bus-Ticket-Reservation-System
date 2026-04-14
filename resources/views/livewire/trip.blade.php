<div>
    <style>
        .sb-search-input {
            width: 100%;
            height: 56px;
            background: #1c201b; /* Card bg */
            border: 1px solid #2c332a; /* Border */
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

    <form wire:submit.prevent style="margin-bottom: 50px;">
        <div class="row" style="margin-left: -8px; margin-right: -8px;">
            <div class="col-lg-3 col-md-6 mb-3" style="padding-left: 8px; padding-right: 8px;">
                <select class="sb-search-input" wire:model="from" required>
                    <option value="">Select From</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location_from }}">{{ $location->location_from }}</option>
                    @endforeach
                </select>
                @error('from')
                    <span class="text-danger" style="font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-lg-3 col-md-6 mb-3" style="padding-left: 8px; padding-right: 8px;">
                <select class="sb-search-input" wire:model="to" required>
                    <option value="">Select To</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                    @endforeach
                </select>
                @error('to')
                    <span class="text-danger" style="font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4 mb-3" style="padding-left: 8px; padding-right: 8px;" wire:ignore>
                <input type="text" id="fancy-date" class="sb-search-input" placeholder="Select Date" style="background: var(--card-bg) url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 448 512\' width=\'16\' fill=\'%23a1a1aa\'><path d=\'M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 64 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z\'/></svg>') no-repeat 95% center; cursor: pointer;" />
            </div>
        </div>
    </form>

    @if ($trips->count() > 0)
        <div class="row gx-4 gy-4" style="padding-bottom: 100px;">
            @foreach ($trips as $trip)
                <div class="col-md-4" style="margin-bottom: 32px;">
                    <div class="sb-card" style="padding: 0; display: flex; flex-direction: column; height: 100%;">
                        <div style="background: rgba(0,0,0,0.2); padding: 20px; border-bottom: 1px solid var(--border);">
                            <div style="font-size: 16px; font-weight: 700; color: #fff; display: flex; align-items: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <span>{{ $trip->location_from }}</span>
                                <i class="fa fa-arrow-right mx-2" style="color: var(--muted); font-size: 12px;"></i>
                                <span>{{ $trip->location_to }}</span>
                            </div>
                            <div style="font-size: 13px; color: var(--muted); margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                @if($trip->date) {{ date('M d, Y', strtotime($trip->date)) }} &bull; @endif {{ $trip->time ?? 'Time not set' }}
                            </div>
                        </div>
                        <div style="padding: 20px; flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px;">
                                <span style="color: var(--muted);">Fare</span>
                                <span style="font-weight: 700; color: var(--accent); font-size: 18px;">৳{{ $trip->fare }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px;">
                                <span style="color: var(--muted);">Bus</span>
                                <span style="font-weight: 500; color: #fff; text-align: right; max-width: 60%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $trip->bus->bus_name }} ({{ $trip->bus->bus_no }})</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px;">
                                <span style="color: var(--muted);">Type</span>
                                <span style="background: var(--seat-empty); color: #fff; padding: 2px 10px; border-radius: 100px; font-size: 12px; text-transform: uppercase;">{{ ucfirst($trip->bus->bus_type) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 14px;">
                                <span style="color: var(--muted);">Seats</span>
                                <span style="font-weight: 700; color: #fff;">{{ $trip->bus->seats->count() - $trip->bus->booking->count() }} Left</span>
                            </div>
                            <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="sb-btn sb-btn-accent" style="display: block; text-align: center; text-decoration: none; width: 100%; font-size: 15px;">Book Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if ($trips->count() >= $perPage)
            <div class="text-center" style="margin-bottom: 100px;">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="sb-btn" style="background: var(--card-bg); border: 1px solid var(--border); color: #fff; padding: 14px 30px; font-weight: 600;">
                    <span wire:loading.remove wire:target="loadMore">Load More Trips<i class="fa-solid fa-arrow-down ms-2"></i></span>
                    <span wire:loading wire:target="loadMore"><i class="fa fa-spinner fa-spin ms-2"></i> Loading...</span>
                </button>
            </div>
        @else
            <div style="padding-bottom: 100px;"></div>
        @endif
    @else
        <div class="sb-card text-center" style="padding: 60px 20px; border-style: dashed; margin-bottom: 100px;">
            <i class="fa fa-bus" style="font-size: 40px; color: var(--muted); margin-bottom: 16px;"></i>
            <h4 style="color: #fff; margin-bottom: 8px;">No trips found</h4>
            <p style="color: var(--muted);">Try adjusting your search criteria (Route, Date, Time).</p>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:load', function () {
            flatpickr("#fancy-date", {
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('date', dateStr);
                    @this.search();
                }
            });
        });
    </script>
</div>
