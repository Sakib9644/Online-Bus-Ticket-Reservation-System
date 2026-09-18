<div>
    <style>
        .sb-search-input option {
            background-color: #000;
            color: #fff;
            padding: 12px;
        }
        
        /* ─── LAYOUT GRID ─── */
        .trip-layout-grid {
            display: grid;
            grid-template-columns: 310px minmax(0, 1fr);
            gap: 40px;
            margin-left: -50px;
        }
        @media (max-width: 992px) {
            .trip-layout-grid {
                grid-template-columns: 1fr;
                margin-left: 0;
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

        /* ─── TRIP CARD (TRUE GLASS) ─── */
        .ticket-card {
            position: relative;
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            transition: all 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            margin-bottom: 18px;
            min-height: 170px;
            width: 100% !important;
            max-width: 100% !important;
            z-index: 1;
            animation: cardIn 0.5s ease-out both;
            animation-delay: calc(var(--card-index, 0) * 0.07s);
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Vibrant left accent strip (always visible) */
        .ticket-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #a2e043 0%, #6C5CE7 100%);
            opacity: 1;
            z-index: 2;
        }

        .ticket-card:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(162, 224, 67, 0.2);
            transform: translateY(-4px);
            box-shadow: 0 20px 50px -12px rgba(162, 224, 67, 0.15), 0 8px 20px -6px rgba(0,0,0,0.3);
        }

        /* ─── CARD SEGMENTS ─── */
        .card-segment {
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .segment-left {
            flex: 0.9;
            border-right: 1px solid rgba(255,255,255,0.05);
            padding-left: 32px;
        }
        .segment-middle {
            flex: 1.8;
            border-right: 1px solid rgba(255,255,255,0.05);
            align-items: flex-start;
            padding: 20px 28px;
        }
        .segment-right {
            flex: 0.7;
            align-items: center;
            justify-content: center;
            padding: 20px 28px;
        }

        /* ─── BUS ICON ─── */
        .bus-icon-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }
        .bus-icon-circle {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            background: linear-gradient(135deg, rgba(162, 224, 67, 0.15), rgba(162, 224, 67, 0.05));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a2e043;
            font-size: 20px;
            border: 1px solid rgba(162, 224, 67, 0.1);
        }
        .bus-meta { flex: 1; min-width: 0; }
        .bus-name {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bus-coach {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            font-weight: 500;
            display: block;
            margin-top: 1px;
        }

        /* ─── BADGES ─── */
        .badge-row {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 9px;
            letter-spacing: 0.7px;
            text-transform: uppercase;
        }
        .badge-ac {
            background: linear-gradient(135deg, #a2e043, #8cc93a);
            color: #0c1200;
            box-shadow: 0 2px 8px rgba(162, 224, 67, 0.2);
        }
        .badge-non-ac {
            background: rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.35);
            border: 1px solid rgba(255,255,255,0.06);
        }

        /* ─── JOURNEY (HERO) ─── */
        .journey-hero {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 16px;
        }
        .journey-node {
            text-align: center;
            flex-shrink: 0;
            min-width: 80px;
        }
        .journey-time {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.5px;
            display: block;
        }
        .journey-city {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-top: 6px;
            white-space: nowrap;
        }
        .journey-arrow {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            min-width: 60px;
        }
        .journey-line {
            width: 100%;
            height: 2px;
            background: rgba(255,255,255,0.06);
            position: relative;
            border-radius: 2px;
            overflow: hidden;
        }
        .journey-line-fill {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 60%;
            background: linear-gradient(90deg, #a2e043, rgba(162, 224, 67, 0.2));
            border-radius: 2px;
        }
        .journey-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            background: #a2e043;
            z-index: 2;
            box-shadow: 0 0 12px rgba(162, 224, 67, 0.3);
        }
        .journey-dot.start { left: -1px; }
        .journey-dot.end { 
            right: -1px; 
            background: rgba(162, 224, 67, 0.2);
            box-shadow: none;
        }
        .journey-bus-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(11, 12, 16, 0.9);
            backdrop-filter: blur(8px);
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #a2e043;
            font-size: 13px;
            z-index: 3;
            border: 1.5px solid rgba(162, 224, 67, 0.12);
            transition: all 0.3s ease;
        }
        .ticket-card:hover .journey-bus-icon {
            border-color: rgba(162, 224, 67, 0.3);
            box-shadow: 0 0 24px rgba(162, 224, 67, 0.12);
        }
        .journey-duration {
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            text-align: center;
            display: block;
            margin-top: 6px;
        }

        /* ─── SEAT STATUS ROW ─── */
        .seat-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.04);
            width: 100%;
        }
        .seat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #a2e043;
            flex-shrink: 0;
            box-shadow: 0 0 8px rgba(162, 224, 67, 0.3);
        }
        .seat-text {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
        }
        .seat-text strong {
            color: #a2e043;
            font-weight: 700;
        }

        /* ─── PRICE ─── */
        .price-wrap {
            text-align: center;
        }
        .price-label {
            font-size: 9px;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }
        .price-amount {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
            letter-spacing: -0.5px;
        }
        .price-amount .currency {
            font-size: 18px;
            color: #a2e043;
            font-weight: 700;
        }

        /* ─── BOOK BUTTON ─── */
        .btn-book {
            background: linear-gradient(135deg, #a2e043, #7ab32f);
            color: #0c1200 !important;
            width: 100%;
            padding: 13px 16px;
            border-radius: 12px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1.2px;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            margin-top: 16px;
            box-shadow: 0 4px 16px rgba(162, 224, 67, 0.2);
            position: relative;
            overflow: hidden;
        }
        .btn-book::after {
            content: '→';
            transition: transform 0.3s ease;
        }
        .btn-book:hover {
            background: linear-gradient(135deg, #b4f056, #8cc93a);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(162, 224, 67, 0.3);
            color: #0c1200 !important;
        }
        .btn-book:hover::after {
            transform: translateX(4px);
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
        @media (max-width: 768px) {
            .ticket-card {
                flex-direction: column;
                min-height: auto;
            }
            .segment-left, .segment-middle, .segment-right {
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.04);
                padding: 18px 20px;
            }
            .segment-right { border-bottom: none; }
            .journey-hero { flex-wrap: wrap; gap: 10px; }
            .journey-node { min-width: 65px; }
            .journey-time { font-size: 22px; }
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
                                <div class="card-segment segment-left">
                                    <div class="bus-icon-wrap">
                                        <div class="bus-icon-circle">
                                            <i class="fa-solid fa-bus"></i>
                                        </div>
                                        <div class="bus-meta">
                                            <span class="bus-name">{{ $trip->bus->bus_name }}</span>
                                            <span class="bus-coach">Coach {{ $trip->bus->coach_no }}</span>
                                        </div>
                                    </div>
                                    <div class="badge-row">
                                        @if(strtolower($trip->bus->bus_type) == 'ac')
                                            <span class="badge badge-ac">AC</span>
                                            <span class="badge badge-non-ac">Non-AC</span>
                                        @else
                                            <span class="badge badge-non-ac">AC</span>
                                            <span class="badge badge-ac">Non-AC</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-segment segment-middle">
                                    <div class="journey-hero">
                                        <div class="journey-node">
                                            <span class="journey-time">{{ $displayStart }}</span>
                                            <span class="journey-city">{{ $trip->location_from }}</span>
                                        </div>
                                        <div class="journey-arrow">
                                            <div class="journey-line">
                                                <div class="journey-line-fill"></div>
                                            </div>
                                            <div class="journey-dot start"></div>
                                            <div class="journey-dot end"></div>
                                            <div class="journey-bus-icon">
                                                <i class="fa-solid fa-shuttle-van"></i>
                                            </div>
                                        </div>
                                        <div class="journey-node">
                                            <span class="journey-time">{{ $displayEnd }}</span>
                                            <span class="journey-city">{{ $trip->location_to }}</span>
                                        </div>
                                    </div>
                                    <div class="journey-duration">≈ 8 hours travel time</div>

                                    <div class="seat-row">
                                        <div class="seat-dot"></div>
                                        <span class="seat-text">
                                            <strong>{{ $availSeats }}</strong> seats available
                                            <span style="color: rgba(255,255,255,0.2);">· {{ $seatPct }}% full</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-segment segment-right">
                                    <div class="price-wrap">
                                        <span class="price-label">Starting from</span>
                                        <div class="price-amount">
                                            <span class="currency">৳</span>{{ number_format($trip->fare) }}
                                        </div>
                                    </div>
                                    @auth
                                        <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="btn-book">Book</a>
                                    @else
                                        <button onclick="toggleDrawer()" class="btn-book">Book</button>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
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
