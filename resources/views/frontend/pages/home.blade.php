@extends('frontend.index')
@section('content')

    <style>
        .booking-bar {
            position: relative;
            z-index: 20;
        }

        @media (max-width: 768px) {
            .booking-bar {
                flex-direction: column;
                border-radius: 24px;
                padding: 20px;
            }

            .booking-bar-item {
                border-right: none !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                width: 100%;
            }

            .booking-bar-btn {
                width: 100%;
                border-radius: 12px;
                margin-top: 10px;
            }
        }

        /* Slider Compact Card Restyling (Midnight Indigo Aesthetic) */
        .premium-card-wrapper {
            width: 100%;
        }

        .ticket-card {
            background: #000 !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 260px;
        }

        .ticket-card:hover {
            border-color: rgba(162, 224, 67, 0.6);
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(162, 224, 67, 0.25);
            background: #050505 !important;
        }

        .operator-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 15px;
        }

        .bus-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            margin-right: 10px;
        }

        .tag-pill-premium {
            background: #a2e043;
            color: #000;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 10px;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .journey-details {
            background: rgba(255, 255, 255, 0.02);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .journey-timeline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .time-val {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            display: block;
            line-height: 1;
        }

        .time-suffix {
            font-size: 11px;
            color: #a2e043;
            font-weight: 700;
        }

        .duration-center {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 15px;
        }

        .duration-line {
            width: 100%;
            height: 2px;
            background: rgba(162, 224, 67, 0.4);
            margin-bottom: 4px;
            box-shadow: 0 0 10px rgba(162, 224, 67, 0.2);
        }

        .duration-text {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .location-block {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: #ccc;
        }

        .action-zone {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .fare-price {
            font-size: 26px;
            font-weight: 800;
            color: #a2e043;
            line-height: 1;
        }

        .fare-label {
            font-size: 11px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-top: 2px;
        }

        .seats-badge {
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
            text-align: right;
        }

        .book-btn-premium {
            background: #a2e043;
            color: #000 !important;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 12px;
            text-decoration: none !important;
            transition: all 0.2s;
            display: inline-block;
        }

        .book-btn-premium:hover {
            background: #fff;
            transform: translateY(-2px);
        }
    </style>

    {{-- HERO SECTION --}}
    <section
        style="min-height: 80vh; padding: 120px 40px 100px; position:relative; overflow:hidden; display: flex; align-items: center; background: url('{{ asset('frontend/images/hero_bg.png') }}') center/cover no-repeat;">
        <div
            style="position:absolute; inset:0; background: linear-gradient(to right, rgba(18, 22, 17, 0.9) 0%, rgba(18, 22, 17, 0.4) 50%, rgba(18, 22, 17, 0.1) 100%); pointer-events:none;">
        </div>

        <div style="max-width:1200px; margin:0 auto; position:relative; z-index: 10; width: 100%;">
            <div style="max-width: 800px;">
                <span class="sb-badge"
                    style="background:rgba(162,224,67,0.1); color:var(--accent); margin-bottom:24px; display:inline-flex; border:1px solid rgba(162,224,67,0.2);">✨
                    Reimagining Travel</span>
                <h1 class="syne"
                    style="font-size:clamp(48px,6.5vw,92px); line-height:1; margin-bottom:24px; font-weight:800; color:#fff; letter-spacing: -2px;">
                    Journey to your <br><span style="color:var(--accent);">Happy Place.</span>
                </h1>
                <p
                    style="color:rgba(255,255,255,0.7); font-size:20px; margin-bottom:48px; line-height:1.6; max-width: 550px;">
                    Premium intercity bus reservations across Bangladesh. Experience comfort, safety, and priority at every
                    mile.</p>
            </div>
        </div>
    </section>

    {{-- TOP DESTINATIONS SECTION --}}
    <section style="padding:100px 40px; background: var(--paper); position: relative;">
        <div
            style="position: absolute; top:0; right:0; width: 400px; height: 400px; background: var(--accent); filter: blur(200px); opacity: 0.03; pointer-events:none;">
        </div>

        <div style="max-width:1200px; margin:0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
                <div>
                    <span class="sb-badge" style="margin-bottom:16px;">Explore Bangladesh</span>
                    <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Trending Destinations</h2>
                </div>
                <p style="color: var(--muted); max-width: 400px; text-align: right; font-size: 14px;">Curated routes to the
                    most beautiful corners of the country.</p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">
                @php
                    $destinations = [
                        ['name' => 'Dhaka', 'img' => 'dhaka.png', 'desc' => 'The vibrant capital city'],
                        ['name' => 'Cox\'s Bazar', 'img' => 'cox.png', 'desc' => 'World\'s longest sea beach'],
                        ['name' => 'Sylhet', 'img' => 'sylhet.png', 'desc' => 'Serene tea gardens & hills'],
                        ['name' => 'Chittagong', 'img' => 'chittagong.png', 'desc' => 'Majestic hills & harbor']
                    ];
                @endphp

                @foreach($destinations as $dest)
                    <div class="destination-card"
                        style="height:400px; border-radius:30px; overflow:hidden; position:relative; cursor:pointer; border: 1px solid rgba(255,255,255,0.05);">
                        <img src="{{ asset('frontend/images/' . $dest['img']) }}" alt="{{ $dest['name'] }}"
                            style="width:100%; height:100%; object-fit:cover; transition: transform 0.8s ease;">
                        <div
                            style="position:absolute; inset:0; background: linear-gradient(to top, rgba(11, 15, 10, 0.9) 0%, rgba(11, 15, 10, 0.2) 50%, transparent 100%);">
                        </div>
                        <div style="position:absolute; bottom:30px; left:30px; right:30px;">
                            <h4 class="syne" style="color:#fff; font-size:24px; font-weight:700; margin-bottom:6px;">
                                {{ $dest['name'] }}</h4>
                            <p style="color:rgba(255,255,255,0.6); font-size:14px; margin-bottom: 16px;">{{ $dest['desc'] }}</p>
                            <a href="{{ route('frontend.reserve', ['to' => $dest['name']]) }}"
                                style="color: var(--accent); text-decoration:none; font-weight:700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 6px;">
                                Find Trips <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- POPULAR ROUTES SECTION --}}
    @if($trips->count() > 0)
        <section style="padding:100px 40px; background: rgba(0,0,0,0.1); border-top: 1px solid var(--border);">
            <div style="max-width:1200px; margin:0 auto;">
                <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:50px;">
                    <div>
                        <span class="sb-badge" style="margin-bottom:12px;">Immediate Departures</span>
                        <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Trending Trips</h2>
                    </div>
                    <a href="{{ route('frontend.reserve') }}"
                        style="color:var(--accent); text-decoration:none; font-weight:800; text-transform: uppercase; letter-spacing: 1px; font-size: 13px; background: rgba(162,224,67,0.1); padding: 10px 20px; border-radius: 100px; border: 1px solid rgba(162,224,67,0.2);">View
                        All Trips →</a>
                </div>

                <div style="position: relative; padding: 0 10px;">
                    <div class="swiper trips-swiper">
                        <div class="swiper-wrapper" style="padding: 10px 0 50px;">
                            @foreach($trips as $trip)
                                <div class="swiper-slide" style="height: auto; display: flex;">
                                    <div class="premium-card-wrapper" style="height: 100%; width: 100%;">
                                        <div class="ticket-card">
                                            <div class="operator-info">
                                                <div class="bus-name">{{ $trip->bus->bus_name }}</div>
                                                <div class="tag-pill-premium">{{ strtoupper($trip->bus->bus_type) }}</div>
                                            </div>

                                            @php
                                                // Robust parsing from previous fix
                                                $timeRaw = $trip->time;
                                                preg_match('/(\d{1,2}:\d{2}\s?(AM|PM))/i', $timeRaw, $matches);
                                                $timeToParse = $matches[0] ?? $timeRaw;
                                                try {
                                                    $startTime = \Carbon\Carbon::parse($timeToParse);
                                                    $endTime = (clone $startTime)->addHours(8);
                                                    $displayStart = $startTime->format('H:i');
                                                    $displayStartSuffix = $startTime->format('A');
                                                    $displayEnd = $endTime->format('H:i');
                                                    $displayEndSuffix = $endTime->format('A');
                                                } catch (\Exception $e) {
                                                    $displayStart = $timeRaw;
                                                    $displayStartSuffix = '';
                                                    $displayEnd = '--:--';
                                                    $displayEndSuffix = '';
                                                }
                                            @endphp

                                            <div class="journey-details">
                                                <div class="journey-timeline">
                                                    <div class="time-block">
                                                        <span class="time-val">{{ $displayStart }} <span
                                                                class="time-suffix">{{ $displayStartSuffix }}</span></span>
                                                    </div>
                                                    <div class="duration-center">
                                                        <div class="duration-line"></div>
                                                        <span class="duration-text">Direct</span>
                                                    </div>
                                                    <div class="time-block" style="text-align: right;">
                                                        <span class="time-val">{{ $displayEnd }} <span
                                                                class="time-suffix">{{ $displayEndSuffix }}</span></span>
                                                    </div>
                                                </div>
                                                <div class="location-block">
                                                    <span class="city-name">{{ $trip->location_from }}</span>
                                                    <span class="city-name">{{ $trip->location_to }}</span>
                                                </div>
                                            </div>

                                            <div class="action-zone">
                                                <div>
                                                    <div class="fare-price">৳{{ $trip->fare }}</div>
                                                    <div class="fare-label">Ticket Fare</div>
                                                </div>
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                                                    <div class="seats-badge">
                                                        {{ $trip->bus->seats->count() - $trip->bookings->count() }} SEATS</div>
                                                    <a href="{{ route('frontend.bookTrip', $trip->id) }}"
                                                        class="book-btn-premium">SELECT</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="swiper-button-prev" style="left: -20px;"></div>
                    <div class="swiper-button-next" style="right: -20px;"></div>
                </div>
            </div>
        </section>
    @endif

@endsection