@extends('frontend.index')
@section('content')

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
                    style="color:rgba(255,255,255,0.7); font-size:20px; margin-bottom:40px; line-height:1.6; max-width: 550px;">
                    Premium intercity bus reservations across Bangladesh. Experience comfort, safety, and priority at every
                    mile.</p>
                <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                    <a href="#find-trips" class="sb-btn sb-btn-primary" style="display: inline-flex; align-items: center; gap: 10px; padding: 16px 36px; font-size: 15px; font-weight: 700; border-radius: 12px; text-decoration: none; box-shadow: 0 8px 24px rgba(162, 224, 67, 0.3);">
                        <i class="fa-solid fa-magnifying-glass"></i> Find Trips Now
                    </a>
                    <a href="#destinations" style="background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.12); padding: 16px 28px; font-size: 15px; font-weight: 600; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.12)';" onmouseout="this.style.background='rgba(255,255,255,0.06)';">
                        <i class="fa-solid fa-map-location-dot"></i> Explore Destinations
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FIND TRIPS SECTION --}}
    <section id="find-trips" style="padding: 80px 40px 90px; background: #0b0d12; position: relative; border-bottom: 1px solid rgba(255,255,255,0.05); scroll-margin-top: 70px;">
        <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 800px; height: 350px; background: radial-gradient(circle, rgba(162, 224, 67, 0.05) 0%, transparent 70%); pointer-events: none;"></div>

        <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 10;">
            <div style="margin-bottom: 40px;">
                <span class="sb-badge" style="margin-bottom: 12px; background: rgba(162, 224, 67, 0.1); color: var(--accent); border: 1px solid rgba(162, 224, 67, 0.2);">
                    ✨ Live Bus Terminals & Schedules
                </span>
                <h2 class="syne" style="font-size: clamp(32px, 4vw, 44px); font-weight: 800; color: #fff; margin: 0 0 10px; letter-spacing: -1px;">
                    Find & Book <span style="color: var(--accent);">Trips</span>
                </h2>
                <p style="color: rgba(255,255,255,0.6); margin: 0; font-size: 16px; max-width: 650px;">
                    Search your preferred route, filter by date, departure time, or coach type, and secure your seats instantly.
                </p>
            </div>

            <livewire:trip />
        </div>
    </section>

    {{-- TOP DESTINATIONS SECTION --}}
    <section id="destinations" style="padding:100px 40px; background: var(--paper); position: relative; scroll-margin-top: 70px;">
        <div
            style="position: absolute; top:0; right:0; width: 400px; height: 400px; background: var(--accent); filter: blur(200px); opacity: 0.03; pointer-events:none;">
        </div>

        <div style="max-width:1200px; margin:0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
                <div>
                    <span class="sb-badge" style="margin-bottom:16px;">Explore Bangladesh</span>
                    <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Destinations</h2>
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
                                <a href="{{ route('frontend.home', ['to' => $dest['name']]) }}#find-trips" class="destination-card"
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