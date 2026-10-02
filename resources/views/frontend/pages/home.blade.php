@extends('frontend.index')
@section('content')

    <style>
        /* ─── LUXURY BLACK & NEON TICKET SEARCH WIDGET ─── */
        .shohoz-search-card {
            background: rgba(8, 12, 8, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1.5px solid rgba(162, 224, 67, 0.35);
            border-radius: 20px;
            padding: 22px 24px 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35), 0 0 25px rgba(162, 224, 67, 0.12);
            position: relative;
            z-index: 9999;
            width: 100%;
            max-width: 1060px;
            margin: 0;
            overflow: visible;
        }

        .shohoz-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .shohoz-service-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(162, 224, 67, 0.1);
            border: 1.5px solid #a2e043;
            color: #a2e043;
            padding: 6px 16px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 0 14px rgba(162, 224, 67, 0.25);
        }

        .shohoz-type-selector {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 0;
            padding: 4px;
            background: #020302;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 30px;
        }

        .shohoz-type-option {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 20px;
            cursor: pointer;
            margin: 0;
            user-select: none;
            transition: all 0.2s ease;
        }

        .shohoz-type-option input {
            display: none;
        }

        .shohoz-radio-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
        }

        .shohoz-type-option input:checked + .shohoz-radio-dot {
            border-color: #a2e043;
            box-shadow: 0 0 10px rgba(162, 224, 67, 0.6);
        }

        .shohoz-type-option input:checked + .shohoz-radio-dot::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #a2e043;
            box-shadow: 0 0 8px rgba(162, 224, 67, 0.8);
        }

        .shohoz-type-label {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 700;
            transition: color 0.2s;
        }

        .shohoz-type-option input:checked ~ .shohoz-type-label {
            color: #ffffff;
            font-weight: 800;
        }

        .shohoz-search-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) auto minmax(0, 1.25fr) minmax(0, 1.15fr) auto;
            align-items: center;
            gap: 8px;
            background: rgba(0, 0, 0, 0.45);
            border: none;
            border-radius: 14px;
            padding: 6px;
        }

        .shohoz-segment {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 14px;
            background: rgba(255, 255, 255, 0.04);
            border: none !important;
            border-radius: 11px;
            min-height: 58px;
            height: 58px;
            box-sizing: border-box;
            position: relative;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .shohoz-segment:focus-within,
        .shohoz-segment:hover {
            border: none !important;
            background: rgba(162, 224, 67, 0.08) !important;
            box-shadow: 0 0 14px rgba(162, 224, 67, 0.18) !important;
        }

        .shohoz-segment.field-error {
            border-color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.08) !important;
            box-shadow: 0 0 0 1px #ef4444, 0 0 16px rgba(239, 68, 68, 0.35) !important;
            animation: segmentShake 0.35s ease;
        }

        .shohoz-segment.field-error .shohoz-segment-icon {
            color: #ef4444 !important;
            text-shadow: 0 0 10px rgba(239, 68, 68, 0.7) !important;
        }

        .shohoz-segment.field-error .shohoz-segment-label {
            color: #f87171 !important;
        }

        .shohoz-segment.field-error .custom-select-trigger,
        .shohoz-segment.field-error .custom-select-text,
        .shohoz-segment.field-error .shohoz-date-input {
            color: #fca5a5 !important;
        }

        .shohoz-segment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
            line-height: 1;
        }

        .field-error-msg {
            display: none;
            color: #ef4444;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
            align-items: center;
            gap: 3px;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .shohoz-segment.field-error .field-error-msg {
            display: inline-flex;
            animation: errorFadeIn 0.2s ease forwards;
        }

        .shohoz-segment.field-error .shohoz-return-hint {
            display: none !important;
        }

        @keyframes errorFadeIn {
            from { opacity: 0; transform: translateY(-2px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes segmentShake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }

        .shohoz-segment-icon {
            font-size: 15px;
            color: #a2e043;
            text-shadow: 0 0 10px rgba(162, 224, 67, 0.5);
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .shohoz-segment-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            min-width: 0;
            height: 100%;
        }

        .shohoz-segment-label {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #a2e043;
            line-height: 1;
        }

        .shohoz-return-hint {
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 0.6px;
            color: #a2e043;
            text-shadow: 0 0 8px rgba(162, 224, 67, 0.4);
            text-transform: uppercase;
            cursor: pointer;
            line-height: 1;
        }

        /* ─── CUSTOM DARK NEON DROPDOWN ─── */
        .custom-dropdown-wrap {
            position: relative;
            cursor: pointer;
            user-select: none;
        }

        .custom-select-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 6px;
            line-height: 1.2;
        }

        .custom-select-text {
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .custom-select-arrow {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.4);
            transition: transform 0.25s ease, color 0.2s ease;
            flex-shrink: 0;
        }

        .custom-dropdown-wrap.is-open .custom-select-arrow {
            transform: rotate(180deg);
            color: #a2e043;
        }

        .custom-dropdown-wrap.is-open {
            border: none !important;
            background: rgba(162, 224, 67, 0.08) !important;
            box-shadow: 0 0 16px rgba(162, 224, 67, 0.25) !important;
            z-index: 100 !important;
        }

        .custom-select-menu {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            min-width: 240px;
            background: #090b0e;
            border: 1.5px solid rgba(162, 224, 67, 0.45);
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.98), 0 0 25px rgba(162, 224, 67, 0.18);
            max-height: 260px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
        }

        .custom-dropdown-wrap.is-open .custom-select-menu {
            display: block;
            animation: customDropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes customDropFade {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-select-menu::-webkit-scrollbar {
            width: 4px;
        }

        .custom-select-menu::-webkit-scrollbar-track {
            background: #0d0d0d;
            border-radius: 6px;
        }

        .custom-select-menu::-webkit-scrollbar-thumb {
            background: rgba(162, 224, 67, 0.3);
            border-radius: 6px;
        }

        .custom-select-menu::-webkit-scrollbar-thumb:hover {
            background: #a2e043;
        }

        .custom-select-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            color: #d1d5db;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .custom-select-option .option-icon {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
            transition: color 0.15s;
        }

        .custom-select-option:hover {
            background: rgba(162, 224, 67, 0.12);
            color: #a2e043;
        }

        .custom-select-option:hover .option-icon {
            color: #a2e043;
        }

        .custom-select-option.selected {
            background: rgba(162, 224, 67, 0.18);
            color: #a2e043;
            font-weight: 800;
        }

        .custom-select-option.selected .option-icon {
            color: #a2e043;
        }

        .shohoz-date-input {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            width: 100%;
            outline: none;
            cursor: pointer;
            padding: 0;
            line-height: 1.2;
            color-scheme: dark;
        }

        /* ─── SWAP BUTTON ─── */
        .shohoz-swap-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shohoz-swap-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #030503;
            border: 1.5px solid #a2e043;
            color: #a2e043;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 14px rgba(162, 224, 67, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .shohoz-swap-btn:hover {
            background: #a2e043;
            color: #000000;
            border-color: #a2e043;
            transform: rotate(180deg) scale(1.12);
            box-shadow: 0 0 25px rgba(162, 224, 67, 0.7);
        }

        /* ─── SEARCH BUTTON ─── */
        .shohoz-btn-wrap {
            display: flex;
            align-items: center;
            height: 58px;
        }

        .shohoz-search-btn {
            background: linear-gradient(135deg, #a2e043 0%, #89ce2c 100%) !important;
            color: #050d03 !important;
            font-weight: 900;
            font-size: 14.5px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border-radius: 12px;
            padding: 0 30px;
            height: 58px;
            min-height: 58px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 0 24px rgba(162, 224, 67, 0.45);
            white-space: nowrap;
        }

        .shohoz-search-btn:hover {
            background: #b2f24a !important;
            transform: translateY(-2px);
            box-shadow: 0 0 40px rgba(162, 224, 67, 0.75);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 992px) {
            .shohoz-card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .shohoz-type-selector {
                justify-content: center;
                width: 100%;
            }
            .shohoz-search-grid {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 8px;
            }
            .shohoz-swap-wrap {
                margin: -2px 0;
            }
            .shohoz-swap-btn {
                transform: rotate(90deg);
            }
            .shohoz-swap-btn:hover {
                transform: rotate(270deg) scale(1.1);
            }
            .shohoz-btn-wrap, .shohoz-search-btn {
                width: 100%;
                height: 52px;
                min-height: 52px;
            }
        }

        /* ─── HERO SLIDER ─── */
        .hero-slider-track {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1.4s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        .hero-slide.active {
            opacity: 1;
        }
        .hero-slider-dots {
            position: absolute;
            bottom: 28px;
            right: 48px;
            display: flex;
            gap: 8px;
            z-index: 15;
        }
        .hero-slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            border: 1.5px solid rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .hero-slider-dot.active {
            background: #a2e043;
            border-color: #a2e043;
            box-shadow: 0 0 10px rgba(162, 224, 67, 0.7);
            width: 24px;
            border-radius: 4px;
        }
    </style>

    {{-- HERO SECTION --}}
    @php
        $heroBackground = setting('hero_image') ? asset(setting('hero_image')) : asset('frontend/images/hero_bg.png');
        $hasSliders = isset($heroSliders) && $heroSliders->count() > 0;
    @endphp
    <section
        style="min-height: 80vh; padding: 0; position:relative; overflow:visible; z-index: 50; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #070907;">

        {{-- SLIDER IMAGES --}}
        @if($hasSliders)
            <div class="hero-slider-track" id="heroSliderTrack">
                @foreach($heroSliders as $idx => $slide)
                    <div class="hero-slide {{ $idx === 0 ? 'active' : '' }}" style="background-image: url('{{ asset($slide->image_path) }}');"></div>
                @endforeach
            </div>
            @if($heroSliders->count() > 1)
                <div class="hero-slider-dots" id="heroSliderDots">
                    @foreach($heroSliders as $idx => $slide)
                        <div class="hero-slider-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Clip wrapper --}}
        <div style="position:absolute; inset:0; overflow:hidden; z-index:0; {{ !$hasSliders ? 'background: #070907 url(\'' . $heroBackground . '\') center/cover no-repeat;' : '' }}"></div>

        {{-- Center content container (Clean, centered search widget) --}}
        <div style="position:relative; z-index: 9999; width:100%; max-width:1120px; margin:0 auto; padding: 100px 24px 60px; display:flex; flex-direction:column; align-items:center;">

            {{-- LUXURY BLACK & NEON SEARCH WIDGET --}}
            <div class="shohoz-search-card">
                <form action="{{ route('frontend.reserve') }}" method="GET" id="heroSearchForm">
                    
                    {{-- Card Header: Service Pill + Trip Type Selector --}}
                    <div class="shohoz-card-header">
                        <div class="shohoz-service-pill">
                            <i class="fa-solid fa-bus-simple"></i>
                            <span>Online Bus Ticket Reservation</span>
                        </div>

                        <div class="shohoz-type-selector">
                            <label class="shohoz-type-option">
                                <input type="radio" name="trip_type" value="oneway" checked>
                                <span class="shohoz-radio-dot"></span>
                                <span class="shohoz-type-label">One Way</span>
                            </label>
                            <label class="shohoz-type-option">
                                <input type="radio" name="trip_type" value="round">
                                <span class="shohoz-radio-dot"></span>
                                <span class="shohoz-type-label">Round Trip</span>
                            </label>
                        </div>
                    </div>

                    {{-- Search Fields Grid --}}
                    <div class="shohoz-search-grid">

                        {{-- FROM SEGMENT --}}
                        <div class="shohoz-segment from-segment custom-dropdown-wrap" id="fromDropdown">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-location-arrow"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div class="shohoz-segment-header">
                                    <span class="shohoz-segment-label">FROM <span style="color:#ef4444; font-size:11px; font-weight:800;">*</span></span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="hidden" name="from" id="hero-origin-val" value="{{ request('from') }}">
                                <div class="custom-select-trigger" id="fromTrigger">
                                    <span class="custom-select-text" id="fromTriggerText">
                                        {{ request('from') ?: 'Select Origin (City)' }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down custom-select-arrow"></i>
                                </div>
                            </div>
                            {{-- Custom Options Dropdown --}}
                            <div class="custom-select-menu" id="fromMenu">
                                <div class="custom-select-option {{ !request('from') ? 'selected' : '' }}" data-value="" data-label="Select Origin (City)">
                                    <i class="fa-solid fa-compass option-icon"></i>
                                    <span>Select Origin (City)</span>
                                </div>
                                @foreach($origins as $orig)
                                    <div class="custom-select-option {{ request('from') == $orig ? 'selected' : '' }}" data-value="{{ $orig }}" data-label="{{ $orig }}">
                                        <i class="fa-solid fa-location-dot option-icon"></i>
                                        <span>{{ $orig }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- SWAP BUTTON --}}
                        <div class="shohoz-swap-wrap">
                            <button type="button" id="swapLocationsBtn" class="shohoz-swap-btn" title="Swap Origin and Destination">
                                <i class="fa-solid fa-right-left"></i>
                            </button>
                        </div>

                        {{-- TO SEGMENT --}}
                        <div class="shohoz-segment to-segment custom-dropdown-wrap" id="toDropdown">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div class="shohoz-segment-header">
                                    <span class="shohoz-segment-label">TO <span style="color:#ef4444; font-size:11px; font-weight:800;">*</span></span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="hidden" name="to" id="hero-dest-val" value="{{ request('to') }}">
                                <div class="custom-select-trigger" id="toTrigger">
                                    <span class="custom-select-text" id="toTriggerText">
                                        {{ request('to') ?: 'Select Destination' }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down custom-select-arrow"></i>
                                </div>
                            </div>
                            {{-- Custom Options Dropdown --}}
                            <div class="custom-select-menu" id="toMenu">
                                <div class="custom-select-option {{ !request('to') ? 'selected' : '' }}" data-value="" data-label="Select Destination">
                                    <i class="fa-solid fa-map-pin option-icon"></i>
                                    <span>Select Destination</span>
                                </div>
                                @foreach($destinationsList as $dst)
                                    <div class="custom-select-option {{ request('to') == $dst ? 'selected' : '' }}" data-value="{{ $dst }}" data-label="{{ $dst }}">
                                        <i class="fa-solid fa-location-dot option-icon"></i>
                                        <span>{{ $dst }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- JOURNEY DATE SEGMENT --}}
                        <div class="shohoz-segment date-segment">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div class="shohoz-segment-header">
                                    <span class="shohoz-segment-label">JOURNEY DATE <span style="color:#ef4444; font-size:11px; font-weight:800;">*</span></span>
                                    <span class="shohoz-return-hint">+ ADD RETURN</span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="date" name="date" class="shohoz-date-input" value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        {{-- SEARCH BUTTON --}}
                        <div class="shohoz-btn-wrap">
                            <button type="submit" class="shohoz-search-btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>SEARCH BUSES</span>
                            </button>
                        </div>
                    </div>{{-- /.shohoz-search-grid --}}

                </form>
            </div>{{-- /.shohoz-search-card --}}
        </div>{{-- /.container --}}
    </section>

    {{-- TOP DESTINATIONS SECTION --}}
    <section id="destinations" style="padding:100px 40px; background: var(--paper); position: relative; z-index: 1; scroll-margin-top: 70px;">
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
                                        
                                        <div style="color: var(--neon); text-shadow: 0 0 10px rgba(162, 224, 67, 0.6); font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; display: flex; align-items: center; gap: 10px; transition: gap 0.3s;">
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
            // Setup custom dropdowns
            function setupCustomDropdown(wrapId, triggerId, textId, inputId, menuId) {
                const wrap = document.getElementById(wrapId);
                const trigger = document.getElementById(triggerId);
                const text = document.getElementById(textId);
                const input = document.getElementById(inputId);
                const menu = document.getElementById(menuId);

                if (!wrap || !trigger || !text || !input || !menu) return;

                // Toggle menu on trigger or segment click
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const wasOpen = wrap.classList.contains('is-open');
                    // Close any other open dropdowns first
                    document.querySelectorAll('.custom-dropdown-wrap').forEach(w => w.classList.remove('is-open'));
                    if (!wasOpen) {
                        wrap.classList.add('is-open');
                    }
                });

                // Select option
                menu.addEventListener('click', function(e) {
                    const option = e.target.closest('.custom-select-option');
                    if (!option) return;
                    e.stopPropagation();

                    const val = option.getAttribute('data-value') || '';
                    const label = option.getAttribute('data-label') || '';

                    input.value = val;
                    text.textContent = label;

                    wrap.classList.remove('field-error');

                    menu.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');

                    wrap.classList.remove('is-open');
                });
            }

            setupCustomDropdown('fromDropdown', 'fromTrigger', 'fromTriggerText', 'hero-origin-val', 'fromMenu');
            setupCustomDropdown('toDropdown', 'toTrigger', 'toTriggerText', 'hero-dest-val', 'toMenu');

            // Click outside closes any open dropdown
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-dropdown-wrap')) {
                    document.querySelectorAll('.custom-dropdown-wrap').forEach(w => w.classList.remove('is-open'));
                }
            });

            // Swap From and To locations
            const swapBtn = document.getElementById('swapLocationsBtn');
            const fromVal = document.getElementById('hero-origin-val');
            const toVal = document.getElementById('hero-dest-val');
            const fromText = document.getElementById('fromTriggerText');
            const toText = document.getElementById('toTriggerText');
            const fromMenu = document.getElementById('fromMenu');
            const toMenu = document.getElementById('toMenu');

            if (swapBtn && fromVal && toVal && fromText && toText) {
                swapBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const tempVal = fromVal.value;
                    const tempText = fromText.textContent;

                    fromVal.value = toVal.value;
                    fromText.textContent = toVal.value ? toText.textContent : 'Select Origin (City)';

                    toVal.value = tempVal;
                    toText.textContent = tempVal ? tempText : 'Select Destination';

                    // Update selected highlight in both menus
                    if (fromMenu) {
                        fromMenu.querySelectorAll('.custom-select-option').forEach(opt => {
                            opt.classList.toggle('selected', opt.getAttribute('data-value') === fromVal.value);
                        });
                    }
                    if (toMenu) {
                        toMenu.querySelectorAll('.custom-select-option').forEach(opt => {
                            opt.classList.toggle('selected', opt.getAttribute('data-value') === toVal.value);
                        });
                    }

                    // Quick spin animation feedback
                    swapBtn.style.transform = 'rotate(180deg) scale(1.15)';
                    setTimeout(() => {
                        swapBtn.style.transform = '';
                    }, 300);
                });
            }

            // ─── VALIDATE 3 REQUIRED FIELDS (FROM, TO, DATE) ───
            const heroSearchForm = document.getElementById('heroSearchForm');
            if (heroSearchForm) {
                const dateInput = heroSearchForm.querySelector('input[name="date"]');
                const fromDropdown = document.getElementById('fromDropdown');
                const toDropdown = document.getElementById('toDropdown');
                const dateSegment = heroSearchForm.querySelector('.date-segment');

                if (dateInput) {
                    ['input', 'change', 'focus', 'click'].forEach(evt => {
                        dateInput.addEventListener(evt, function() {
                            if (this.value) {
                                dateSegment?.classList.remove('field-error');
                            }
                        });
                    });
                }

                document.getElementById('fromTrigger')?.addEventListener('click', function() {
                    fromDropdown?.classList.remove('field-error');
                });

                document.getElementById('toTrigger')?.addEventListener('click', function() {
                    toDropdown?.classList.remove('field-error');
                });

                heroSearchForm.addEventListener('submit', function(e) {
                    const fromInput = document.getElementById('hero-origin-val');
                    const toInput = document.getElementById('hero-dest-val');
                    const fromVal = fromInput ? fromInput.value.trim() : '';
                    const toVal = toInput ? toInput.value.trim() : '';
                    const dateVal = dateInput ? dateInput.value.trim() : '';

                    let hasError = false;
                    let firstErrorElem = null;

                    if (!fromVal) {
                        hasError = true;
                        fromDropdown?.classList.add('field-error');
                        if (!firstErrorElem) firstErrorElem = fromDropdown;
                    } else {
                        fromDropdown?.classList.remove('field-error');
                    }

                    if (!toVal) {
                        hasError = true;
                        toDropdown?.classList.add('field-error');
                        if (!firstErrorElem) firstErrorElem = toDropdown;
                    } else {
                        toDropdown?.classList.remove('field-error');
                    }

                    if (!dateVal) {
                        hasError = true;
                        dateSegment?.classList.add('field-error');
                        if (!firstErrorElem) firstErrorElem = dateSegment;
                    } else {
                        dateSegment?.classList.remove('field-error');
                    }

                    if (hasError) {
                        e.preventDefault();
                        if (firstErrorElem) {
                            firstErrorElem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                        return false;
                    }
                });
            }
        });
    </script>

    {{-- HERO SLIDER AUTO-ROTATION --}}
    @if(isset($heroSliders) && $heroSliders->count() > 1)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var slides = document.querySelectorAll('.hero-slide');
        var dots = document.querySelectorAll('.hero-slider-dot');
        var currentIndex = 0;
        var totalSlides = slides.length;
        var intervalMs = 5000;
        var sliderInterval;

        function goToSlide(index) {
            slides.forEach(function(s) { s.classList.remove('active'); });
            dots.forEach(function(d) { d.classList.remove('active'); });
            currentIndex = index;
            slides[currentIndex].classList.add('active');
            if (dots[currentIndex]) dots[currentIndex].classList.add('active');
        }

        function nextSlide() {
            goToSlide((currentIndex + 1) % totalSlides);
        }

        function startAutoPlay() {
            sliderInterval = setInterval(nextSlide, intervalMs);
        }

        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                clearInterval(sliderInterval);
                goToSlide(parseInt(this.getAttribute('data-index')));
                startAutoPlay();
            });
        });

        startAutoPlay();
    });
    </script>
    @endif

@endsection