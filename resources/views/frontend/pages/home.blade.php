@extends('frontend.index')
@section('content')

    <style>
        /* ─── HERO MAIN SECTION ─── */
        .hero-main-section {
            min-height: 92vh;
            position: relative;
            overflow: visible;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background: #070907;
            padding: 120px 0 60px 0;
        }

        /* Top Left Text Container */
        .hero-top-left-wrap {
            position: absolute;
            top: 30px;
            left: 0;
            right: 0;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            z-index: 999;
            pointer-events: none;
            display: flex;
            justify-content: flex-start;
        }

        .hero-top-left-wrap .hero-brand-header {
            pointer-events: auto;
        }

        /* Middle Centered Search Bar */
        .hero-center-search-wrap {
            position: relative;
            z-index: 9999;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ─── HERO BRAND TEXT (Explore More with Every Journey) ─── */
        .hero-brand-header {
            margin-bottom: 0;
            text-align: left;
            width: 100%;
            max-width: 680px;
        }

        .hero-brand-eyebrow {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .eyebrow-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(18, 24, 28, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.2px;
            color: #ffffff;
            text-transform: uppercase;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.5);
        }

        .eyebrow-badge i {
            color: #f59e0b;
            font-size: 11px;
        }

        .hero-brand-title {
            margin: 0 0 14px 0;
            font-size: 56px;
            font-weight: 900;
            color: #ffffff;
            line-height: 1.08;
            letter-spacing: -1px;
            font-family: inherit;
            text-shadow: 0 3px 18px rgba(0, 0, 0, 0.8), 0 1px 4px rgba(0, 0, 0, 0.9);
        }

        .hero-brand-title .highlight {
            color: #8ce429;
        }

        .hero-brand-subtitle {
            margin: 0;
            font-size: 15.5px;
            color: rgba(255, 255, 255, 0.88);
            font-weight: 400;
            line-height: 1.55;
            max-width: 600px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);
        }

        /* ─── SLEEK SEARCH CARD WITH GREEN BORDER ─── */
        .shohoz-search-card {
            background: rgba(8, 14, 11, 0.94);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1.5px solid rgba(140, 228, 41, 0.38);
            border-radius: 22px;
            padding: 16px 20px 20px 20px;
            box-shadow: 0 25px 65px rgba(0, 0, 0, 0.85), 0 0 25px rgba(140, 228, 41, 0.12);
            position: relative;
            z-index: 9999;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            align-self: center;
            overflow: visible;
        }

        /* ─── TRIP TYPE TOGGLE (One Way / Round Way) ─── */
        .search-trip-type-row {
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 0 4px 14px 4px;
        }

        .trip-type-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .trip-type-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.35);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .trip-type-label.active .trip-type-dot {
            border-color: #8ce429;
            box-shadow: 0 0 10px rgba(140, 228, 41, 0.4);
        }

        .trip-type-label.active .trip-type-dot::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #8ce429;
        }

        .trip-type-text {
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.2px;
        }

        .trip-type-label:not(.active) .trip-type-text {
            color: #94a3b8;
            font-weight: 500;
        }

        /* ─── SEARCH MENU HEADER (Where do you want to go? & QUICK SEARCH) ─── */
        .search-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2px 4px 14px 4px;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            width: 100%;
        }

        .search-menu-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .search-menu-icon-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, rgba(163, 230, 53, 0.25) 0%, rgba(10, 20, 24, 0.95) 75%);
            border: 1px solid rgba(163, 230, 53, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.45), inset 0 0 10px rgba(163, 230, 53, 0.12);
        }

        .search-menu-icon-circle i {
            color: #a3e635;
            font-size: 20px;
            filter: drop-shadow(0 0 6px rgba(163, 230, 53, 0.5));
        }

        .search-menu-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .search-menu-title {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.4px;
            line-height: 1.25;
            font-family: inherit;
        }

        .search-menu-subtitle {
            margin: 3px 0 0 0;
            font-size: 13px;
            font-weight: 450;
            color: #8fa0ad;
            line-height: 1.35;
        }

        .search-menu-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border: 1.5px solid rgba(163, 230, 53, 0.75);
            border-radius: 9999px;
            background: rgba(163, 230, 53, 0.07);
            color: #a3e635;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 0 12px rgba(163, 230, 53, 0.15);
            white-space: nowrap;
            user-select: none;
            transition: all 0.2s ease;
        }

        .search-menu-badge:hover {
            background: rgba(163, 230, 53, 0.15);
            box-shadow: 0 0 18px rgba(163, 230, 53, 0.3);
        }

        .search-menu-badge i {
            font-size: 11px;
            color: #a3e635;
        }

        .shohoz-search-grid {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        /* ─── EACH INPUT FIELD HAS ITS OWN DISTINCT BORDER ─── */
        .shohoz-segment {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.22);
            border-radius: 20px;
            box-sizing: border-box;
            position: relative;
            cursor: pointer;
            transition: all 0.25s ease;
            flex: 1;
            min-width: 0;
            height: 60px;
        }

        .shohoz-segment:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(163, 230, 53, 0.55);
        }

        .shohoz-segment:focus-within,
        .custom-dropdown-wrap.is-open {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: #a3e635 !important;
            box-shadow: 0 0 0 3px rgba(163, 230, 53, 0.2);
            z-index: 100 !important;
        }

        .shohoz-segment.field-error {
            background: rgba(239, 68, 68, 0.12) !important;
            border: 1px solid #ef4444 !important;
            border-radius: 16px;
            animation: segmentShake 0.35s ease;
        }

        .shohoz-segment.field-error .shohoz-segment-icon {
            color: #ef4444 !important;
        }

        .shohoz-segment.field-error .shohoz-segment-label {
            color: #f87171 !important;
        }

        .shohoz-segment.field-error .custom-select-trigger,
        .shohoz-segment.field-error .custom-select-text {
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
            font-size: 22px;
            color: #a3e635;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 24px;
        }

        .shohoz-segment-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            min-width: 0;
        }

        .shohoz-segment-label {
            font-size: 11px;
            font-weight: 600;
            color: #8fa0a8;
            line-height: 1;
            margin-bottom: 3px;
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
            font-size: 14.5px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        /* ─── SWAP BUTTON ─── */
        .shohoz-swap-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .shohoz-swap-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0c171d;
            border: 1.5px solid rgba(163, 230, 53, 0.5);
            color: #a3e635;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(163, 230, 53, 0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            flex-shrink: 0;
        }

        .shohoz-swap-btn:hover {
            background: #a3e635;
            color: #051808;
            border-color: #a3e635;
            transform: rotate(180deg) scale(1.1);
            box-shadow: 0 0 18px rgba(163, 230, 53, 0.6);
        }

        /* ─── VERTICAL DIVIDER ─── */
        .shohoz-v-divider {
            display: none;
        }

        /* ─── DATE CAPSULE (Inner Box) ─── */
        .shohoz-segment.date-segment {
            flex: 0 0 210px;
        }

        .shohoz-date-input-hidden {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        /* ─── SEARCH BUTTON (Squircle with Magnifying Glass) ─── */
        .shohoz-btn-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .shohoz-search-btn {
            height: 60px;
            padding: 0 26px;
            border-radius: 14px;
            background: #8ce429 !important;
            color: #0c1a05 !important;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 4px 18px rgba(140, 228, 41, 0.4);
            flex-shrink: 0;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .shohoz-search-btn:hover {
            background: #9ff23d !important;
            transform: scale(1.03);
            box-shadow: 0 6px 22px rgba(140, 228, 41, 0.6);
        }

        /* ─── CUSTOM DROPDOWN MENU ─── */
        .custom-dropdown-wrap {
            position: relative;
            cursor: pointer;
            user-select: none;
        }

        .custom-select-menu {
            position: absolute;
            top: calc(100% + 12px);
            left: 0;
            right: 0;
            min-width: 280px;
            background: #081720;
            border: 1.5px solid rgba(163, 230, 53, 0.4);
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.98), 0 0 25px rgba(163, 230, 53, 0.18);
            z-index: 99999;
            display: none;
        }

        .custom-dropdown-wrap.is-open .custom-select-menu {
            display: block;
            animation: customDropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* ─── SELECT2-STYLE SEARCH INPUT ─── */
        .custom-select-search-wrap {
            padding: 4px 4px 8px 4px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 6px;
        }

        .custom-select-search-inner {
            position: relative;
            display: flex;
            align-items: center;
        }

        .select2-search-icon {
            position: absolute;
            left: 12px;
            color: #8fa0a8;
            font-size: 13px;
            pointer-events: none;
        }

        .custom-select-search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 10px;
            padding: 8px 12px 8px 34px;
            font-size: 13px;
            color: #ffffff;
            outline: none;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .custom-select-search-input:focus {
            border-color: #a3e635;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(163, 230, 53, 0.2);
        }

        .custom-select-search-input::placeholder {
            color: #6c7c88;
        }

        .custom-select-options-list {
            max-height: 220px;
            overflow-y: auto;
        }

        .custom-select-options-list::-webkit-scrollbar {
            width: 6px;
        }
        .custom-select-options-list::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
        }
        .custom-select-options-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .custom-select-options-list::-webkit-scrollbar-thumb:hover {
            background: #a3e635;
        }

        .custom-select-no-results {
            padding: 16px 12px;
            text-align: center;
            color: #8fa0a8;
            font-size: 13px;
            display: none;
        }

        .custom-select-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 10px;
            color: #d1d5db;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .custom-select-option:hover {
            background: rgba(163, 230, 53, 0.14);
            color: #a3e635;
        }

        .custom-select-option.selected {
            background: rgba(163, 230, 53, 0.2);
            color: #a3e635;
            font-weight: 800;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 992px) {
            .hero-main-section {
                min-height: auto;
                height: auto;
                padding: 100px 20px 60px;
                flex-direction: column;
                justify-content: flex-start;
            }
            .hero-top-left-wrap {
                position: relative;
                top: auto;
                left: auto;
                right: auto;
                padding: 0 0 24px 0;
                max-width: 100%;
            }
            .hero-center-search-wrap {
                padding: 0;
            }
            .hero-brand-title {
                font-size: 34px;
            }
            .hero-brand-subtitle {
                font-size: 14px;
            }
            .hero-brand-header {
                margin-bottom: 24px;
            }
            .shohoz-search-card {
                border-radius: 24px;
                padding: 16px;
            }
            .search-menu-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding-bottom: 12px;
                margin-bottom: 12px;
            }
            .search-menu-badge {
                align-self: flex-start;
            }
            .search-menu-title {
                font-size: 17px;
            }
            .search-menu-subtitle {
                font-size: 12px;
            }
            .shohoz-search-grid {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .shohoz-v-divider {
                display: none;
            }
            .shohoz-segment {
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                padding: 10px 16px;
                height: 56px;
            }
            .shohoz-segment.date-segment {
                flex: auto;
                width: 100%;
            }
            .shohoz-swap-btn {
                transform: rotate(90deg);
                margin: 0 auto;
            }
            .shohoz-search-btn {
                width: 100%;
                border-radius: 16px;
                height: 52px;
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
    <section class="hero-main-section">

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

        {{-- Background shadow overlay: cinematic lighting matching reference image --}}
        <div style="position:absolute; inset:0; pointer-events:none; z-index:1;
            background:
                linear-gradient(to top, #070907 0%, rgba(7, 9, 7, 0.9) 16%, rgba(7, 9, 7, 0.48) 35%, transparent 65%),
                linear-gradient(to bottom, rgba(5, 10, 7, 0.55) 0%, rgba(5, 10, 7, 0.18) 32%, transparent 60%),
                linear-gradient(to right, rgba(5, 10, 7, 0.5) 0%, rgba(5, 10, 7, 0.15) 38%, transparent 65%);"></div>

        {{-- TOP LEFT TEXT CONTAINER --}}
        <div class="hero-top-left-wrap">
            <div class="hero-brand-header">
                <div class="hero-brand-eyebrow">
                    <span class="eyebrow-badge"><i class="fa-solid fa-plane-departure"></i> REIMAGINING TRAVEL</span>
                </div>
                <h1 class="hero-brand-title">Journey to your<br><span class="highlight">Happy Place.</span></h1>
                <p class="hero-brand-subtitle">Premium Intercity bus reservations across Bangladesh.<br>Experience comfort, safety, and priority at every mile.</p>
            </div>
        </div>

        {{-- CENTER MIDDLE SEARCH BAR CONTAINER --}}
        <div class="hero-center-search-wrap">
            <div class="shohoz-search-card">

                {{-- TRIP TYPE TOGGLE: ONE WAY / ROUND WAY --}}
              

                <form action="{{ route('frontend.reserve') }}" method="GET" id="heroSearchForm" style="margin: 0; width: 100%;">
                    
                    <div class="shohoz-search-grid">

                        {{-- FROM SEGMENT --}}
                        <div class="shohoz-segment from-segment custom-dropdown-wrap" id="fromDropdown">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div class="shohoz-segment-header">
                                    <span class="shohoz-segment-label">FROM <span style="color:#ef4444">*</span></span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="hidden" name="from" id="hero-origin-val" value="{{ request('from') }}">
                                <div class="custom-select-trigger" id="fromTrigger">
                                    <span class="custom-select-text" id="fromTriggerText">
                                        {{ request('from') ?: 'Select Origin' }}
                                    </span>
                                </div>
                            </div>
                            <div class="custom-select-menu" id="fromMenu">
                                <div class="custom-select-search-wrap">
                                    <div class="custom-select-search-inner">
                                        <i class="fa-solid fa-magnifying-glass select2-search-icon"></i>
                                        <input type="text" class="custom-select-search-input" placeholder="Search district..." autocomplete="off">
                                    </div>
                                </div>
                                <div class="custom-select-options-list">
                                    <div class="custom-select-option {{ !request('from') ? 'selected' : '' }}" data-value="" data-label="Select Origin">
                                        <i class="fa-solid fa-location-dot option-icon"></i>
                                        <span>Select Origin</span>
                                    </div>
                                    @foreach($origins as $orig)
                                        <div class="custom-select-option {{ request('from') == $orig ? 'selected' : '' }}" data-value="{{ $orig }}" data-label="{{ $orig }}">
                                            <i class="fa-solid fa-location-dot option-icon"></i>
                                            <span>{{ $orig }}</span>
                                        </div>
                                    @endforeach
                                    <div class="custom-select-no-results">
                                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> No district found
                                    </div>
                                </div>
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
                                    <span class="shohoz-segment-label">TO <span style="color:#ef4444">*</span></span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="hidden" name="to" id="hero-dest-val" value="{{ request('to') }}">
                                <div class="custom-select-trigger" id="toTrigger">
                                    <span class="custom-select-text" id="toTriggerText">
                                        {{ request('to') ?: 'Select Destination' }}
                                    </span>
                                </div>
                            </div>
                            <div class="custom-select-menu" id="toMenu">
                                <div class="custom-select-search-wrap">
                                    <div class="custom-select-search-inner">
                                        <i class="fa-solid fa-magnifying-glass select2-search-icon"></i>
                                        <input type="text" class="custom-select-search-input" placeholder="Search district..." autocomplete="off">
                                    </div>
                                </div>
                                <div class="custom-select-options-list">
                                    <div class="custom-select-option {{ !request('to') ? 'selected' : '' }}" data-value="" data-label="Select Destination">
                                        <i class="fa-solid fa-location-dot option-icon"></i>
                                        <span>Select Destination</span>
                                    </div>
                                    @foreach($destinationsList as $dst)
                                        <div class="custom-select-option {{ request('to') == $dst ? 'selected' : '' }}" data-value="{{ $dst }}" data-label="{{ $dst }}">
                                            <i class="fa-solid fa-location-dot option-icon"></i>
                                            <span>{{ $dst }}</span>
                                        </div>
                                    @endforeach
                                    <div class="custom-select-no-results">
                                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> No district found
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- JOURNEY DATE SEGMENT (Capsule Box) --}}
                        <div class="shohoz-segment date-segment">
                            <div class="shohoz-segment-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div class="shohoz-segment-content">
                                <div class="shohoz-segment-header">
                                    <span class="shohoz-segment-label">JOURNEY DATE <span style="color:#ef4444">*</span></span>
                                    <span style="font-size: 10px; font-weight: 800; color: #8ce429; cursor: pointer; letter-spacing: 0.3px;">+ ADD RETURN</span>
                                    <span class="field-error-msg"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                                </div>
                                <input type="date" name="date" id="heroDateInput" class="shohoz-date-input-hidden" value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                                <div class="custom-select-trigger" id="dateTrigger">
                                    <span class="custom-select-text" id="dateTriggerText">
                                        {{ request('date') ? date('d/m/Y', strtotime(request('date'))) : date('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- SEARCH BUTTON (Rectangular with Text and Icon) --}}
                        <div class="shohoz-btn-wrap">
                            <button type="submit" class="shohoz-search-btn" title="Search Buses">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>SEARCH</span>
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
            // Setup custom dropdowns with Select2-style live search filter
            function setupCustomDropdown(wrapId, triggerId, textId, inputId, menuId) {
                const wrap = document.getElementById(wrapId);
                const trigger = document.getElementById(triggerId);
                const text = document.getElementById(textId);
                const input = document.getElementById(inputId);
                const menu = document.getElementById(menuId);

                if (!wrap || !trigger || !text || !input || !menu) return;

                const searchInput = menu.querySelector('.custom-select-search-input');
                const noResults = menu.querySelector('.custom-select-no-results');
                const options = menu.querySelectorAll('.custom-select-option');

                function resetSearch() {
                    if (searchInput) searchInput.value = '';
                    options.forEach(opt => opt.style.display = '');
                    if (noResults) noResults.style.display = 'none';
                }

                // Toggle menu on entire segment click
                wrap.addEventListener('click', function(e) {
                    if (e.target.closest('.custom-select-menu')) return;
                    e.stopPropagation();
                    const wasOpen = wrap.classList.contains('is-open');
                    
                    // Close any other open dropdowns first and reset their search
                    document.querySelectorAll('.custom-dropdown-wrap').forEach(w => {
                        w.classList.remove('is-open');
                        const s = w.querySelector('.custom-select-search-input');
                        if (s) s.value = '';
                        w.querySelectorAll('.custom-select-option').forEach(opt => opt.style.display = '');
                        const nr = w.querySelector('.custom-select-no-results');
                        if (nr) nr.style.display = 'none';
                    });

                    if (!wasOpen) {
                        wrap.classList.add('is-open');
                        resetSearch();
                        if (searchInput) {
                            setTimeout(() => searchInput.focus(), 60);
                        }
                    }
                });

                // Live district filtering
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        e.stopPropagation();
                        const query = this.value.trim().toLowerCase();
                        let matches = 0;

                        options.forEach(opt => {
                            const val = opt.getAttribute('data-value') || '';
                            const label = (opt.getAttribute('data-label') || '').toLowerCase();

                            // Hide the placeholder "Select Origin" while typing a query
                            if (!val && query) {
                                opt.style.display = 'none';
                                return;
                            }

                            if (!query || label.includes(query)) {
                                opt.style.display = 'flex';
                                matches++;
                            } else {
                                opt.style.display = 'none';
                            }
                        });

                        if (noResults) {
                            noResults.style.display = matches === 0 ? 'block' : 'none';
                        }
                    });

                    searchInput.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });

                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            wrap.classList.remove('is-open');
                        }
                    });
                }

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

                    resetSearch();
                    wrap.classList.remove('is-open');
                });
            }

            setupCustomDropdown('fromDropdown', 'fromTrigger', 'fromTriggerText', 'hero-origin-val', 'fromMenu');
            setupCustomDropdown('toDropdown', 'toTrigger', 'toTriggerText', 'hero-dest-val', 'toMenu');

            // Click anywhere on date segment to open date picker
            const dateSegment = document.querySelector('.date-segment');
            const dateInput = document.getElementById('heroDateInput');
            const dateTriggerText = document.getElementById('dateTriggerText');
            if (dateSegment && dateInput && dateTriggerText) {
                dateSegment.addEventListener('click', function(e) {
                    if (typeof dateInput.showPicker === 'function') {
                        try { dateInput.showPicker(); } catch(err) { dateInput.focus(); }
                    } else {
                        dateInput.focus();
                    }
                });

                ['input', 'change'].forEach(evt => {
                    dateInput.addEventListener(evt, function() {
                        if (this.value) {
                            const parts = this.value.split('-');
                            if (parts.length === 3) {
                                dateTriggerText.textContent = `${parts[2]}/${parts[1]}/${parts[0]}`;
                            } else {
                                dateTriggerText.textContent = this.value;
                            }
                            dateSegment.classList.remove('field-error');
                        } else {
                            dateTriggerText.textContent = 'Select date';
                        }
                    });
                });
            }

            // Click outside closes any open dropdown
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-dropdown-wrap')) {
                    document.querySelectorAll('.custom-dropdown-wrap').forEach(w => {
                        w.classList.remove('is-open');
                        const s = w.querySelector('.custom-select-search-input');
                        if (s) s.value = '';
                        w.querySelectorAll('.custom-select-option').forEach(opt => opt.style.display = '');
                        const nr = w.querySelector('.custom-select-no-results');
                        if (nr) nr.style.display = 'none';
                    });
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
                    const tempText = fromText.textContent.trim();

                    fromVal.value = toVal.value;
                    fromText.textContent = toVal.value ? toText.textContent.trim() : 'Select Origin';

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

            // Trip Type Toggle (One Way / Round Way)
            document.querySelectorAll('.trip-type-label').forEach(label => {
                label.addEventListener('click', function() {
                    document.querySelectorAll('.trip-type-label').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

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