@extends('frontend.index')
@section('content')

    <style>
        /* ─── SHOHOZ-STYLE FLOATING SEARCH WIDGET (PURE BLACK & NEON) ─── */
        .shohoz-search-card {
            background: #080808;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1.5px solid rgba(0, 255, 102, 0.35);
            border-radius: 24px;
            padding: 24px 28px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.95), 0 0 40px rgba(0, 255, 102, 0.15);
            position: relative;
            z-index: 20;
            width: 100%;
        }

        .shohoz-type-selector {
            display: flex;
            align-items: center;
            gap: 28px;
            margin-bottom: 18px;
            padding-left: 6px;
        }

        .shohoz-type-option {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        .shohoz-type-option input {
            display: none;
        }

        .shohoz-radio-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            position: relative;
        }

        .shohoz-type-option input:checked + .shohoz-radio-dot {
            border-color: #00ff66;
            box-shadow: 0 0 15px rgba(0, 255, 102, 0.6);
        }

        .shohoz-type-option input:checked + .shohoz-radio-dot::after {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #00ff66;
            box-shadow: 0 0 10px rgba(0, 255, 102, 0.8);
        }

        .shohoz-type-label {
            color: #e2e8f0;
            font-size: 15px;
            font-weight: 700;
            transition: color 0.2s;
        }

        .shohoz-type-option input:checked ~ .shohoz-type-label {
            color: #ffffff;
        }

        /* ─── SEARCH GRID ROW ─── */
        .shohoz-search-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) auto minmax(0, 1.25fr) minmax(0, 1.15fr) auto;
            align-items: center;
            gap: 12px;
            background: #000000;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 8px 10px;
        }

        .shohoz-segment {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 16px;
            background: #0a0a0a;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            height: 64px;
            transition: all 0.25s ease;
        }

        .shohoz-segment:focus-within {
            border-color: #00ff66;
            background: rgba(0, 255, 102, 0.04);
            box-shadow: 0 0 20px rgba(0, 255, 102, 0.25);
        }

        .shohoz-segment-icon {
            font-size: 18px;
            color: #00ff66;
            text-shadow: 0 0 12px rgba(0, 255, 102, 0.5);
            width: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .shohoz-segment-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
        }

        .shohoz-segment-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #00ff66;
            margin-bottom: 2px;
        }

        .shohoz-return-hint {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.8px;
            color: #00ff66;
            text-shadow: 0 0 8px rgba(0, 255, 102, 0.4);
            text-transform: uppercase;
            cursor: pointer;
        }

        .shohoz-select {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            outline: none;
            cursor: pointer;
            padding: 0;
            appearance: none;
            -webkit-appearance: none;
            text-overflow: ellipsis;
        }

        .shohoz-select option {
            background: #080808;
            color: #ffffff;
            padding: 12px;
        }

        .shohoz-date-input {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            outline: none;
            cursor: pointer;
            padding: 0;
            color-scheme: dark;
        }

        /* ─── SWAP BUTTON ─── */
        .shohoz-swap-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shohoz-swap-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #0a0a0a;
            border: 1.5px solid rgba(0, 255, 102, 0.4);
            color: #00ff66;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(0, 255, 102, 0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .shohoz-swap-btn:hover {
            background: #00ff66;
            color: #000000;
            border-color: #00ff66;
            transform: rotate(180deg) scale(1.12);
            box-shadow: 0 0 25px rgba(0, 255, 102, 0.65);
        }

        /* ─── SEARCH BUTTON ─── */
        .shohoz-btn-wrap {
            display: flex;
            align-items: center;
            height: 64px;
        }

        .shohoz-search-btn {
            background: #00ff66 !important;
            color: #000000 !important;
            font-weight: 900;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-radius: 14px;
            padding: 0 36px;
            height: 100%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 0 25px rgba(0, 255, 102, 0.45);
            white-space: nowrap;
        }

        .shohoz-search-btn:hover {
            background: #33ff85 !important;
            transform: translateY(-2px);
            box-shadow: 0 0 45px rgba(0, 255, 102, 0.75);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 992px) {
            .shohoz-search-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 12px;
            }
            .shohoz-swap-wrap {
                margin: -4px 0;
            }
            .shohoz-swap-btn {
                transform: rotate(90deg);
            }
            .shohoz-swap-btn:hover {
                transform: rotate(270deg) scale(1.1);
            }
            .shohoz-btn-wrap, .shohoz-search-btn {
                width: 100%;
            }
        }
    </style>

    {{-- HERO SECTION WITH SHOHOZ-STYLE SEARCH BAR --}}
    <section
        style="min-height: 85vh; padding: 120px 40px 90px; position:relative; overflow:hidden; display: flex; align-items: center; background: url('{{ asset('frontend/images/hero_bg.png') }}') center/cover no-repeat;">
        <div
            style="position:absolute; inset:0; background: linear-gradient(to right, rgba(14, 18, 14, 0.95) 0%, rgba(14, 18, 14, 0.65) 55%, rgba(14, 18, 14, 0.25) 100%); pointer-events:none;">
        </div>

        <div style="max-width:1200px; margin:0 auto; position:relative; z-index: 10; width: 100%;">
            <div style="max-width: 820px; margin-bottom: 48px;">
                <span class="sb-badge"
                    style="background:rgba(162,224,67,0.1); color:var(--accent); margin-bottom:20px; display:inline-flex; border:1px solid rgba(162,224,67,0.2);">✨
                    Reimagining Travel</span>
                <h1 class="syne"
                    style="font-size:clamp(44px,6vw,84px); line-height:1.05; margin-bottom:20px; font-weight:800; color:#fff; letter-spacing: -2px;">
                    Journey to your <br><span style="color:var(--accent);">Happy Place.</span>
                </h1>
                <p
                    style="color:rgba(255,255,255,0.75); font-size:19px; line-height:1.6; max-width: 580px; margin: 0;">
                    Premium intercity bus reservations across Bangladesh. Experience comfort, safety, and priority at every
                    mile.</p>
            </div>

            {{-- SHOHOZ-STYLE FLOATING SEARCH WIDGET --}}
            <div class="shohoz-search-card">
                <form action="{{ route('frontend.reserve') }}" method="GET" id="heroSearchForm">
                    {{-- Trip Type Selector (One Way / Round Way) --}}
                    <div class="shohoz-type-selector">
                        <label class="shohoz-type-option">
                            <input type="radio" name="trip_type" value="oneway" checked>
                            <span class="shohoz-radio-dot"></span>
                            <span class="shohoz-type-label">One Way</span>
                        </label>
                        <label class="shohoz-type-option">
                            <input type="radio" name="trip_type" value="round">
                            <span class="shohoz-radio-dot"></span>
                            <span class="shohoz-type-label">Round Way</span>
                        </label>
                    </div>

                    {{-- Main Search Bar Grid --}}
                    <div class="shohoz-search-grid">
                        {{-- FROM SEGMENT --}}
                        <div class="shohoz-segment from-segment">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-location-arrow"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <span class="shohoz-segment-label">FROM</span>
                                <select name="from" id="hero-origin-select" class="shohoz-select">
                                    <option value="">Select Origin (City)</option>
                                    @foreach($origins as $orig)
                                        <option value="{{ $orig }}" {{ request('from') == $orig ? 'selected' : '' }}>{{ $orig }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- SWAP BUTTON --}}
                        <div class="shohoz-swap-wrap">
                            <button type="button" id="swapLocationsBtn" class="shohoz-swap-btn" title="Swap Origin and Destination">
                                <i class="fa-solid fa-right-left"></i>
                            </button>
                        </div>

                        {{-- TO SEGMENT --}}
                        <div class="shohoz-segment to-segment">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <span class="shohoz-segment-label">TO</span>
                                <select name="to" id="hero-dest-select" class="shohoz-select">
                                    <option value="">Select Destination</option>
                                    @foreach($destinationsList as $dst)
                                        <option value="{{ $dst }}" {{ request('to') == $dst ? 'selected' : '' }}>{{ $dst }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- JOURNEY DATE SEGMENT --}}
                        <div class="shohoz-segment date-segment">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span class="shohoz-segment-label">JOURNEY DATE</span>
                                    <span class="shohoz-return-hint">+ ADD RETURN</span>
                                </div>
                                <input type="date" name="date" class="shohoz-date-input" value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        {{-- SEARCH BUTTON --}}
                        <div class="shohoz-btn-wrap">
                            <button type="submit" class="shohoz-search-btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>SEARCH</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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

        .destination-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(162, 224, 67, 0.3) !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Swap From and To locations
            const swapBtn = document.getElementById('swapLocationsBtn');
            const fromSelect = document.getElementById('hero-origin-select');
            const toSelect = document.getElementById('hero-dest-select');

            if (swapBtn && fromSelect && toSelect) {
                swapBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const temp = fromSelect.value;
                    fromSelect.value = toSelect.value;
                    toSelect.value = temp;

                    // Quick spin animation feedback
                    swapBtn.style.transform = 'rotate(180deg) scale(1.15)';
                    setTimeout(() => {
                        swapBtn.style.transform = '';
                    }, 300);
                });
            }
        });
    </script>

@endsection