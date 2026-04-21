<div>
    <style>
        .sb-search-input option {
            background-color: #000;
            color: #fff;
            padding: 12px;
        }
        
        /* Trip Card Pure Black & Solid Line */
        .ticket-card {
            background: #000 !important;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; 
            display: flex;
            align-items: stretch;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 25px;
            height: 210px !important; /* Absolute uniform height */
            width: 1100px !important; /* Absolute uniform height */
            max-height: 210px;
            max-width: 1200px!important;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }
        
        .ticket-card:hover {
            border-color: rgba(162, 224, 67, 0.6);
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(162, 224, 67, 0.25); /* Green Glow */
            background: #050505 !important;
        }

        .card-segment {
            padding: 35px 40px; /* Increased Padding for pro-feel */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .segment-left { flex: 1.2; border-right: 2px solid rgba(255,255,255,0.08); }
        .segment-middle { flex: 1.5; border-right: 2px solid rgba(255,255,255,0.08); align-items: flex-start; }
        .segment-right { 
            flex: 1; 
            align-items: center; 
            background: rgba(255,255,255,0.02); 
            justify-content: center; /* Perfect Vertical Balance */
            padding: 30px;
            border-left: 1px solid rgba(255,255,255,0.05);
        }

        .badge-group { display: flex; gap: 8px; margin-bottom: 18px; }
        .badge-ac { background: #a2e043; color: #000; padding: 6px 14px; border-radius: 8px; font-weight: 800; font-size: 11px; letter-spacing: 0.5px; }
        .badge-non-ac { background: transparent; color: #999; padding: 5px 14px; border-radius: 8px; font-weight: 700; font-size: 11px; border: 1px solid rgba(255,255,255,0.1); }

        .bus-title { 
            font-family: 'DM Sans', sans-serif; 
            font-size: 24px; 
            font-weight: 800; 
            color: #fff; 
            margin-bottom: 6px; 
            letter-spacing: -0.5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }
        .coach-sub { color: #555; font-size: 14px; font-weight: 600; }

        .journey-info { display: flex; align-items: center; gap: 40px; width: 100%; }
        .city-box { text-align: left; }
        .city-name-lg { font-size: 28px; font-weight: 800; color: #fff; display: block; line-height: 1.1; letter-spacing: -0.5px; }
        .time-label-gr { font-size: 14px; color: #a2e043; font-weight: 700; margin-top: 10px; display: block; }

        .timeline-visual { flex: 1; position: relative; display: flex; align-items: center; justify-content: center; min-width: 160px; margin-top: -5px; }
        .timeline-line-dashed { width: 100%; height: 2px; background: rgba(162, 224, 67, 0.4); box-shadow: 0 0 10px rgba(162, 224, 67, 0.2); }
        .bus-icon-center { position: absolute; background: #000; padding: 0 18px; color: #a2e043; font-size: 26px; z-index: 2; }

        .price-box { text-align: center; margin-bottom: 20px; }
        .price-label-sm { font-size: 11px; color: #555; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 5px; display: block; font-weight: 700; }
        .price-val-lg { font-size: 42px; font-weight: 800; color: #a2e043; line-height: 1; display: flex; align-items: center; justify-content: center; }
        .price-sub { font-size: 13px; color: #555; margin-top: 4px; display: block; font-weight: 600; }

        .btn-select-seats {
            background: #a2e043;
            color: #000 !important;
            width: 100%;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 13px;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: block;
        }
        .btn-select-seats:hover { background: #fff; transform: translateY(-3px); }
        .seats-left-txt { 
            font-size: 13px; 
            font-weight: 700; 
            color: #fff; /* Clean White */
            text-align: center; 
            margin-top: 15px; 
            display: inline-block;
            opacity: 0.9;
        }
        /* ── SECTION WRAPPER ── */
        .section-wrap { max-width: 1200px; margin: 0 auto; padding: 60px 20px; }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="section-wrap">
        <div class="sb-filter-container" style="margin-bottom: 80px;"> {{-- Added significant gap --}}
            <form wire:submit.prevent="search">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="sb-search-label">From</label>
                        <select class="sb-search-input" wire:model.live="from" required>
                            <option value="">Origin</option>
                            @foreach ($origins as $origin)
                                <option value="{{ $origin }}">{{ $origin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="sb-search-label">To</label>
                        <select class="sb-search-input" wire:model.live="to" required>
                            <option value="">Destination</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination }}">{{ $destination }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="sb-search-label">Journey Date</label>
                        <input type="date" class="sb-search-input" wire:model.live="date" style="color-scheme: dark;">
                    </div>
                    <div class="col-lg-3 col-md-6" style="margin-bottom: 24px;">
                        <label class="sb-search-label">Departure</label>
                        <select class="sb-search-input" wire:model.live="time">
                            <option value="">All Times</option>
                            @foreach ($times as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sb-search-label">Coach Type</label>
                        <select class="sb-search-input" wire:model.live="type">
                            <option value="">All Types</option>
                            <option value="ac">AC Coach</option>
                            <option value="non-ac">Non-AC Coach</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sb-search-label">Course Number</label>
                        <select class="sb-search-input" wire:model.live="coach_no">
                            <option value="">All Courses</option>
                            @foreach ($coachNumbers as $no)
                                <option value="{{ $no }}">{{ $no }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="sb-search-label">Transport Name</label>
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
                    <h4 style="color: #fff; margin: 0; font-weight: 800; font-family: 'DM Sans', sans-serif;">Available Trips ({{ $trips->count() }})</h4>
                    <div style="color: var(--muted); font-size: 13px; font-family: 'DM Sans', sans-serif;">Showing results for your selected route</div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 25px; padding-bottom: 60px;">
                    @foreach ($trips as $trip)
                        <div class="ticket-card">
                            {{-- Segment 1: Identity --}}
                            <div class="card-segment segment-left">
                                <div class="badge-group">
                                    @if(strtolower($trip->bus->bus_type) == 'ac')
                                        <span class="badge-ac">AC</span>
                                        <span class="badge-non-ac">NON-AC</span>
                                    @else
                                        <span class="badge-non-ac" style="background: rgba(255,255,255,0.05);">AC</span>
                                        <span class="badge-ac">NON-AC</span>
                                    @endif
                                </div>
                                <h3 class="bus-title">{{ $trip->bus->bus_name }}</h3>
                                <div class="coach-sub">Coach No. {{ $trip->bus->coach_no }}</div>
                            </div>

                            {{-- Segment 2: Journey --}}
                            <div class="card-segment segment-middle">
                                @php
                                    $timeRaw = $trip->time;
                                    preg_match('/(\d{1,2}:\d{2}\s?(AM|PM))/i', $timeRaw, $matches);
                                    $timeToParse = $matches[0] ?? $timeRaw;
                                    try {
                                        $startTime = \Carbon\Carbon::parse($timeToParse);
                                        $displayStart = $startTime->format('h:i');
                                        $displayStartSuffix = $startTime->format('A');
                                        $endTime = $startTime->copy()->addHours(8); // Mockup standard
                                        $displayEnd = $endTime->format('H:i');
                                        $displayEndSuffix = $endTime->format('A');
                                    } catch (\Exception $e) {
                                        $displayStart = $timeRaw; $displayStartSuffix = '';
                                        $displayEnd = '16:00'; $displayEndSuffix = 'PM';
                                    }
                                @endphp

                                <div class="journey-info">
                                    <div class="city-box">
                                        <span class="city-name-lg">{{ $trip->location_from }}</span>
                                        <span class="time-label-gr">{{ $displayStart }} {{ $displayStartSuffix }}</span>
                                    </div>

                                    <div class="timeline-visual">
                                        <div class="timeline-line-dashed"></div>
                                        <div class="bus-icon-center">
                                            <i class="fa-solid fa-shuttle-van"></i> {{-- Closer to the mockup's boxy bus --}}
                                        </div>
                                    </div>

                                    <div class="city-box">
                                        <span class="city-name-lg">{{ $trip->location_to }}</span>
                                        <span class="time-label-gr">{{ $displayEnd }} {{ $displayEndSuffix }}</span>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: center; width: 100%;">
                                    <div class="seats-left-txt">
                                        <i class="fa-solid fa-chair" style="margin-right: 5px; font-size: 11px;"></i>
                                        {{ $trip->bus->seats->count() - $trip->bookings->count() }} Seats Available
                                    </div>
                                </div>
                            </div>

                            {{-- Segment 3: Action --}}
                            <div class="card-segment segment-right">
                                <div style="width: 100%;">
                                    <div class="price-box">
                                        <span class="price-label-sm">PRICE</span>
                                        <div class="price-val-lg">
                                            <span style="font-size: 32px; margin-right: 2px;">৳</span>{{ $trip->fare }}
                                        </div>
                                        <span class="price-sub">per seat</span>
                                    </div>
                                    
                                    <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="btn-select-seats">
                                        SELECT SEATS
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($hasFilters && $trips->count() == 0)
            <div style="text-align: center; padding: 100px 20px;">
                <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 60px; max-width: 600px; margin: 0 auto;">
                    <i class="fa-solid fa-bus-simple" style="font-size: 60px; color: #333; margin-bottom: 25px;"></i>
                    <h3 style="color: #fff; margin-bottom: 12px; font-family: 'DM Sans', sans-serif;">No trips available</h3>
                    <p style="color: var(--muted); font-family: 'DM Sans', sans-serif;">We couldn't find any trips matching your selection. Please try different filters.</p>
                </div>
            </div>
        @elseif(!$hasFilters)
            <div style="text-align: center; padding: 100px 20px;">
                <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 60px; max-width: 600px; margin: 0 auto;">
                    <i class="fa-solid fa-search" style="font-size: 60px; color: #333; margin-bottom: 25px;"></i>
                    <h3 style="color: #fff; margin-bottom: 12px; font-family: 'DM Sans', sans-serif;">Find Your Trip</h3>
                    <p style="color: var(--muted); font-family: 'DM Sans', sans-serif;">Please select your origin and destination and click search to view available buses.</p>
                </div>
            </div>
        @endif

        @if ($trips->count() >= $perPage)
            <div class="text-center" style="margin-bottom: 100px;">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="sb-btn" style="padding: 16px 40px; font-weight: 700;">
                    <span wire:loading.remove wire:target="loadMore">SHOW MORE RESULTS <i class="fa-solid fa-arrow-down ms-2"></i></span>
                    <span wire:loading wire:target="loadMore"><i class="fa fa-spinner fa-spin ms-2"></i> LOADING...</span>
                </button>
            </div>
        @endif
    </div>
</div>
