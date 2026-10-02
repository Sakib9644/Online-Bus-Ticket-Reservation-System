<div>
    <style>
        select.mini-input,
        .mini-input,
        .sb-search-input {
            color-scheme: dark;
        }

        select.mini-input option,
        .mini-input option,
        .sb-search-input option,
        option {
            background-color: #14171d !important;
            color: #ffffff !important;
            padding: 10px 14px;
        }
        
        /* ─── LAYOUT GRID ─── */
        .trip-layout-grid {
            display: grid;
            grid-template-columns: 310px minmax(0, 1fr);
            gap: 40px;
        }
        @media (max-width: 992px) {
            .trip-layout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ─── VIBRANT BG OVERLAY (behind glass cards) ─── */
        .trip-results-area {
            position: relative;
        }
        .trip-results-area::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -60px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(162, 224, 67, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        .trip-results-area::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: -40px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(108, 92, 231, 0.06) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ─── SIDEBAR ─── */
        .sidebar-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.06); 
            border-radius: 20px;
            padding: 28px 24px;
            position: sticky;
            top: 100px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.04);
            z-index: 10;
        }
        .sidebar-title {
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.3px;
        }
        .sidebar-title i { color: #a2e043; }

        /* ─── TRIP CARD (PURE BLACK & NEON GLOW) ─── */
        /* ─── SHOHOZ / BUSBD STYLE TICKET CARD ─── */
        .ticket-card {
            position: relative;
            background: #080808;
            border: 1.5px solid rgba(162, 224, 67, 0.35);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            margin-bottom: 16px;
            gap: 16px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(162, 224, 67, 0.06);
            animation: cardIn 0.4s ease-out both;
            animation-delay: calc(var(--card-index, 0) * 0.05s);
            box-sizing: border-box;
            width: 100%;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ticket-card:hover {
            border-color: #a2e043;
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.95), 0 0 30px rgba(162, 224, 67, 0.25);
        }

        /* ─── SEGMENT LEFT: OPERATOR & ROUTE ─── */
        .segment-operator {
            flex: 0 1 220px;
            min-width: 170px;
            max-width: 240px;
        }

        .operator-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .operator-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(162, 224, 67, 0.12);
            border: 1.5px solid rgba(162, 224, 67, 0.35);
            color: #a2e043;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 0 12px rgba(162, 224, 67, 0.15);
        }

        .operator-title {
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 2px 0;
            line-height: 1.2;
            letter-spacing: -0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .operator-subline {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .operator-route {
            font-size: 11px;
            color: #8e99aa;
            line-height: 1.35;
            margin-top: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .operator-route strong {
            color: #a2e043;
            font-weight: 700;
        }

        /* ─── SEGMENT MIDDLE: TIMELINE & SCHEDULE ─── */
        .segment-schedule {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0 16px;
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .schedule-node {
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-width: 85px;
        }

        .schedule-time {
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .schedule-date {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            margin: 3px 0 2px;
        }

        .schedule-city {
            font-size: 12px;
            color: #cbd5e1;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 105px;
        }

        /* Shohoz Journey Timeline Progress Bar */
        .schedule-timeline {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1 1 auto;
            min-width: 60px;
            max-width: 130px;
        }

        .timeline-duration {
            font-size: 11px;
            color: #a2e043;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .timeline-track {
            position: relative;
            width: 100%;
            height: 20px;
            display: flex;
            align-items: center;
        }

        .timeline-line {
            width: 100%;
            height: 2px;
            background: #a2e043;
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(162, 224, 67, 0.5);
        }

        .timeline-bus-icon {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #a2e043;
            color: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            box-shadow: 0 0 12px rgba(162, 224, 67, 0.7);
        }

        .timeline-endpoint {
            position: absolute;
            right: 0;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #a2e043;
            box-shadow: 0 0 6px rgba(162, 224, 67, 0.7);
        }

        /* ─── SEGMENT RIGHT: FARE & BOOK TICKET (NEON BUTTON) ─── */
        .segment-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 0 0 145px;
            min-width: 145px;
            gap: 6px;
        }

        .fare-amount {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 2px;
        }

        .fare-amount .currency {
            font-size: 20px;
            font-weight: 800;
            color: #a2e043;
            margin-right: 2px;
            text-shadow: 0 0 10px rgba(162, 224, 67, 0.5);
        }

        .btn-book-ticket {
            background: #a2e043 !important;
            color: #000000 !important;
            font-weight: 900;
            font-size: 13px;
            letter-spacing: 0.8px;
            padding: 10px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            transition: all 0.25s ease;
            box-shadow: 0 0 20px rgba(162, 224, 67, 0.4);
            text-transform: uppercase;
        }

        .btn-book-ticket:hover {
            background: #b5ec58 !important;
            transform: translateY(-2px);
            box-shadow: 0 0 35px rgba(162, 224, 67, 0.8);
            color: #000000 !important;
        }

        .seats-avail-tag {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            text-align: center;
            margin-top: 2px;
            white-space: nowrap;
        }

        .seats-avail-tag strong {
            color: #a2e043;
            font-weight: 800;
        }

        /* ─── MINI FORM ─── */
        .mini-fg { margin-bottom: 16px; }
        .mini-label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-bottom: 6px;
            letter-spacing: 0.8px;
        }
        .mini-input-wrap { position: relative; }
        .mini-input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.15);
            font-size: 12px;
            z-index: 1;
        }
        .mini-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 13px 14px 13px 40px;
            color: #fff;
            color-scheme: dark;
            font-size: 13px;
            outline: none;
            transition: all 0.25s ease;
            font-family: 'Poppins', sans-serif;
        }
        .mini-input:focus {
            border-color: rgba(162, 224, 67, 0.35);
            background: rgba(255,255,255,0.06);
            box-shadow: 0 0 20px rgba(162, 224, 67, 0.04);
        }
        .mini-btn {
            width: 100%;
            background: linear-gradient(135deg, #a2e043 0%, #7ab32f 100%);
            color: #0c1200;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(162, 224, 67, 0.12);
        }
        .mini-btn:hover {
            background: linear-gradient(135deg, #b4f056 0%, #8cc93a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(162, 224, 67, 0.2);
        }

        /* ─── DRAWER ─── */
        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(14px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }
        .drawer-overlay.active { opacity: 1; visibility: visible; }
        .drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 420px;
            height: 100vh;
            background: rgba(10, 11, 15, 0.98);
            backdrop-filter: blur(24px);
            border-left: 1px solid rgba(255,255,255,0.05);
            z-index: 9999;
            padding: 60px 36px;
            transition: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: -20px 0 60px rgba(0,0,0,0.8);
            color: #fff;
            overflow-y: auto;
        }
        .drawer.active { right: 0; }
        .close-drawer {
            position: absolute;
            top: 22px;
            right: 22px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: rgba(255,255,255,0.3);
            cursor: pointer;
            border: none;
            background: rgba(255,255,255,0.03);
            border-radius: 10px;
            transition: all 0.3s;
        }
        .close-drawer:hover { color: #fff; background: rgba(255,255,255,0.07); }

        .user-profile-mini { text-align: center; }
        .user-avatar {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #a2e043, #6db329);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #0c1200;
            margin: 0 auto 18px;
            font-weight: 800;
            border: 3px solid rgba(162, 224, 67, 0.12);
            box-shadow: 0 8px 28px rgba(162, 224, 67, 0.1);
        }
        .user-name { color: #fff; font-weight: 700; font-size: 17px; margin-bottom: 3px; }
        .user-email { color: rgba(255,255,255,0.25); font-size: 13px; margin-bottom: 28px; }
        .quick-links { display: flex; flex-direction: column; gap: 8px; }
        .quick-link {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.6);
            padding: 13px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-size: 14px;
            text-align: left;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .quick-link:hover {
            background: rgba(162, 224, 67, 0.05);
            color: #a2e043;
            border-color: rgba(162, 224, 67, 0.08);
            padding-left: 22px;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 1080px) {
            .ticket-card {
                flex-direction: column;
                align-items: stretch;
                padding: 20px;
                gap: 16px;
            }
            .segment-operator {
                max-width: 100%;
                width: 100%;
            }
            .segment-schedule {
                border-left: none;
                border-right: none;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                padding: 16px 0;
                width: 100%;
            }
            .segment-action {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                flex: 1 1 100%;
            }
            .btn-book-ticket {
                width: auto;
                min-width: 150px;
            }
            .drawer { width: 100%; right: -100%; padding: 50px 24px; }
            .trip-layout-grid { margin-left: 0; }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <div class="section-wrap" style="padding-top: 20px; padding-bottom: 100px;">
        <div class="trip-layout-grid">
            {{-- Sidebar Filters --}}
            <aside class="left-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-title">
                        <i class="fa-solid fa-sliders"></i>
                        Filters
                    </div>
                    <form wire:submit.prevent="search">
                        <div class="mini-fg">
                            <label class="mini-label">From</label>
                            <select class="mini-input" wire:model.live="from" style="padding-left: 16px;">
                                <option value="">Origin</option>
                                @foreach ($origins as $origin)
                                    <option value="{{ $origin }}">{{ $origin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-fg">
                            <label class="mini-label">To</label>
                            <select class="mini-input" wire:model.live="to" style="padding-left: 16px;">
                                <option value="">Destination</option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination }}">{{ $destination }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-fg">
                            <label class="mini-label">Journey Date</label>
                            <input type="date" class="mini-input" wire:model.live="date" style="color-scheme: dark; padding-left: 16px;">
                        </div>
                        <div class="mini-fg">
                            <label class="mini-label">Departure</label>
                            <select class="mini-input" wire:model.live="time" style="padding-left: 16px;">
                                <option value="">All Times</option>
                                @foreach ($times as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-fg">
                            <label class="mini-label">Coach Type</label>
                            <select class="mini-input" wire:model.live="type" style="padding-left: 16px;">
                                <option value="">All Types</option>
                                <option value="ac">AC Coach</option>
                                <option value="non-ac">Non-AC Coach</option>
                            </select>
                        </div>
                        <button type="button" wire:click="resetFilters" class="mini-btn" style="background: rgba(255,255,255,0.03); color: #888; margin-top: 8px; border: 1px solid rgba(255,255,255,0.05); box-shadow: none;">
                            Reset Filters
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Results Area --}}
            <main class="middle-content trip-results-area" style="padding-top: 0;">
                @if ($trips->count() > 0)
                    <div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 18px;">
                        <h4 style="color: #fff; margin: 0; font-weight: 700; font-size: 20px; letter-spacing: -0.3px;">
                            Available Trips
                            <span style="color: #a2e043; font-weight: 800; margin-left: 4px;">{{ $trips->count() }}</span>
                        </h4>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 18px;">
                        @foreach ($trips as $index => $trip)
                            @php
                                $timeRaw = $trip->time;
                                preg_match('/(\d{1,2}:\d{2}\s?(AM|PM))/i', $timeRaw, $matches);
                                $timeToParse = $matches[0] ?? $timeRaw;
                                try {
                                    $startTime = \Carbon\Carbon::parse($timeToParse);
                                    $endTime = $startTime->copy()->addHours(8);
                                    $displayStart = $startTime->format('h:i A');
                                    $displayEnd = $endTime->format('h:i A');
                                } catch (\Exception $e) {
                                    $displayStart = $timeRaw;
                                    $displayEnd = '--:--';
                                }
                                $totalSeats = $trip->bus->seats->count();
                                $availSeats = $totalSeats - $trip->bookings->count();
                                $seatPct = $totalSeats > 0 ? round(($availSeats / $totalSeats) * 100) : 0;
                            @endphp

                            <div class="ticket-card" style="--card-index: {{ $index }};">
                                {{-- 1. LEFT: Operator Logo, Name, Subline, Route --}}
                                <div class="segment-operator">
                                    <div class="operator-header">
                                        <div class="operator-logo">
                                            <i class="fa-solid fa-bus"></i>
                                        </div>
                                        <div class="operator-meta">
                                            <h4 class="operator-title">{{ $trip->bus->bus_name }}</h4>
                                            <div class="operator-subline">
                                                Coach {{ $trip->bus->coach_no }} • {{ strtoupper($trip->bus->bus_type) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="operator-route">
                                        <strong>Route:</strong> {{ $trip->location_from }} - {{ $trip->location_to }}
                                    </div>
                                </div>

                                {{-- 2. MIDDLE: Departure, Progress Timeline, Arrival --}}
                                <div class="segment-schedule">
                                    {{-- Departure Node --}}
                                    <div class="schedule-node departure">
                                        <span class="schedule-time">{{ $displayStart }}</span>
                                        <span class="schedule-date">{{ date('D, j M', strtotime($trip->date)) }}</span>
                                        <span class="schedule-city">{{ $trip->location_from }}</span>
                                    </div>

                                    {{-- Timeline --}}
                                    <div class="schedule-timeline">
                                        <span class="timeline-duration">5h 0m</span>
                                        <div class="timeline-track">
                                            <div class="timeline-line"></div>
                                            <div class="timeline-bus-icon">
                                                <i class="fa-solid fa-bus"></i>
                                            </div>
                                            <div class="timeline-endpoint"></div>
                                        </div>
                                    </div>

                                    {{-- Arrival Node --}}
                                    <div class="schedule-node arrival">
                                        <span class="schedule-time">{{ $displayEnd }}</span>
                                        <span class="schedule-date">{{ date('D, j M', strtotime($trip->date)) }}</span>
                                        <span class="schedule-city">{{ $trip->location_to }}</span>
                                    </div>
                                </div>

                                {{-- 3. RIGHT: Fare, Book Button, Available Seats --}}
                                <div class="segment-action">
                                    <div class="fare-amount">
                                        <span class="currency">৳</span>{{ number_format($trip->fare) }}
                                    </div>
                                    @auth
                                        <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="btn-book-ticket">BOOK TICKET</a>
                                    @else
                                        <button onclick="toggleDrawer()" class="btn-book-ticket">BOOK TICKET</button>
                                    @endauth
                                    <div class="seats-avail-tag">
                                        <strong>{{ $availSeats }}</strong> Seat(s) Available
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (isset($totalCount) && $totalCount > $trips->count())
                        <div style="text-align: center; margin-top: 32px;">
                            <button type="button" wire:click="loadMore" class="mini-btn" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; width: auto; padding: 14px 32px; background: rgba(162, 224, 67, 0.1); color: #a2e043; border: 1px solid rgba(162, 224, 67, 0.3); border-radius: 12px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='var(--accent)'; this.style.color='#000';" onmouseout="this.style.background='rgba(162, 224, 67, 0.1)'; this.style.color='#a2e043';">
                                <i class="fa-solid fa-angles-down"></i> Load More Trips (Showing {{ $trips->count() }} of {{ $totalCount }})
                            </button>
                        </div>
                    @endif
                @else
                    <div style="text-align: center; padding: 80px 20px; position: relative; z-index: 1;">
                        <div style="font-size: 44px; color: rgba(255,255,255,0.06); margin-bottom: 18px;">
                            <i class="fa-solid fa-bus"></i>
                        </div>
                        <h3 style="color: rgba(255,255,255,0.3); font-weight: 600; font-size: 18px;">No trips found</h3>
                        <p style="color: rgba(255,255,255,0.15); margin-top: 6px; font-size: 14px;">Try adjusting your filters to see available schedules.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>

    {{-- Drawer --}}
    <div id="drawerOverlay" class="drawer-overlay" onclick="toggleDrawer()"></div>
    <div id="drawer" class="drawer">
        <button class="close-drawer" onclick="toggleDrawer()"><i class="fa-solid fa-xmark"></i></button>

        @auth
            <div class="user-profile-mini">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-email">{{ auth()->user()->email }}</div>
                <div class="quick-links">
                    <a href="#" class="quick-link">
                        <span><i class="fa-solid fa-user-gear me-2"></i> My Profile</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
                    </a>
                    <a href="{{ route('booking.details') }}" class="quick-link">
                        <span><i class="fa-solid fa-ticket me-2"></i> My Bookings</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
                    </a>
                    <a href="{{ route('user.logout') }}" class="quick-link w-100" style="background: rgba(220, 53, 69, 0.04); color: #ff6b6b; justify-content: center; font-weight: 600; text-decoration: none;">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>
        @else
            <div class="sidebar-title" style="margin-bottom: 22px;">
                <i class="fa-solid fa-circle-user"></i> Login
            </div>
            <form action="{{ route('user.do.login') }}" method="POST">
                @csrf
                <div class="mini-fg">
                    <label class="mini-label">Email</label>
                    <div class="mini-input-wrap">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="mini-input" placeholder="email@example.com" required>
                    </div>
                </div>
                <div class="mini-fg">
                    <label class="mini-label">Password</label>
                    <div class="mini-input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" class="mini-input" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="mini-btn">Sign In</button>
                <div style="text-align: center; margin-top: 22px;">
                    <a href="{{ route('user.registration') }}" style="color: #a2e043; text-decoration: none; font-size: 13px; font-weight: 700;">Create Account →</a>
                </div>
            </form>
        @endauth

        <div class="sidebar-card" style="margin-top: 36px; background: rgba(162, 224, 67, 0.03); border-color: rgba(162, 224, 67, 0.05);">
            <div style="color: #a2e043; font-size: 15px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-headset"></i> Need Help?
            </div>
            <p style="color: rgba(255,255,255,0.3); font-size: 13px; line-height: 1.6; margin-bottom: 0;">24/7 support team ready to assist with your bookings.</p>
        </div>
    </div>

    <script>
        function toggleDrawer() {
            const d = document.getElementById('drawer');
            const o = document.getElementById('drawerOverlay');
            if(d && o) { d.classList.toggle('active'); o.classList.toggle('active'); }
        }
    </script>
</div>
