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
                <div style="display: flex; gap: 12px; align-items: center;">
                    <button class="dest-prev thick-arrow">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="dest-next thick-arrow">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div style="position: relative;">
                <div class="swiper destinations-swiper">
                    <div class="swiper-wrapper">
                        @foreach($destinations as $dest)
                            <div class="swiper-slide" style="height: auto;">
                                <a href="{{ route('frontend.reserve', ['to' => $dest['name']]) }}" class="destination-card"
                                    style="height:420px; border-radius:32px; overflow:hidden; position:relative; cursor:pointer; border: 1px solid rgba(255,255,255,0.03); text-decoration: none; display: block; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                                    
                                    {{-- Background Image --}}
                                    <img src="{{ $dest['img'] }}" alt="{{ $dest['name'] }}"
                                        style="width:100%; height:100%; object-fit:cover; transition: transform 1.2s ease;"
                                        onerror="this.src='https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800'">

                                    {{-- Deep Vignette Overlay --}}
                                    <div style="position:absolute; inset:0; background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.2) 40%, transparent 100%);">
                                    </div>

                                    {{-- Content Overlay --}}
                                    <div style="position:absolute; bottom:35px; left:30px; right:30px;">
                                        <h4 class="syne" style="color:#fff; font-size:28px; font-weight:800; margin-bottom:8px; letter-spacing: -0.5px;">
                                            {{ $dest['name'] }}</h4>
                                        <p style="color:rgba(255,255,255,0.7); font-size:14px; font-weight: 500; margin-bottom: 24px; line-height: 1.4;">{{ $dest['desc'] }}</p>
                                        
                                        <div style="color: #a2e043; font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; display: flex; align-items: center; gap: 10px; transition: gap 0.3s;">
                                            FIND TRIPS <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Initialize Swiper --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.destinations-swiper', {
                slidesPerView: 1,
                spaceBetween: 25,
                navigation: {
                    nextEl: '.dest-next',
                    prevEl: '.dest-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    992: { slidesPerView: 3 },
                    1200: { slidesPerView: 4 }
                }
            });
        });
    </script>

    <style>
        .thick-arrow {
            background: rgba(255,255,255,0.05);
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 18px;
        }
        .thick-arrow:hover {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
            transform: scale(1.05);
        }
        .swiper-button-disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

    <style>
        .destination-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(162, 224, 67, 0.3) !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
    </style>

@endsection