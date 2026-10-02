<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name', 'SwiftBus') }} – Ticket Reservation</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="{{ url('frontend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    @livewireStyles

    <style>
        :root {
            color-scheme: dark;
            /* Core Brand Colors */
            --paper: #0b0d11; /* Deep Midnight Foundation */
            --bg-black: #0b0d11;
            --card-bg: #14171d; /* Premium Midnight Slate */
            --accent: #a2e043; /* SwiftBus Neon Lime */
            --accent-hover: #b5ec58;
            --neon: #a2e043;
            --neon-glow: 0 0 20px rgba(162, 224, 67, 0.45);
            --neon-glow-lg: 0 0 35px rgba(162, 224, 67, 0.7), 0 0 70px rgba(162, 224, 67, 0.25);

            /* UI Elements */
            --ink: #ffffff;
            --muted: #8e99aa;
            --border: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(162, 224, 67, 0.4);

            /* Seat Status */
            --seat-available: #3871ce;
            --seat-selected: #a2e043;
            --seat-booked: #d34539;
            --seat-empty: #14171d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        select, input, textarea {
            color-scheme: dark;
        }

        select option, option {
            background-color: #14171d !important;
            color: #ffffff !important;
        }

        body {
            background: var(--paper) !important;
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6,
        .syne, .sb-brand, .sb-logo-text { font-family: 'Poppins', sans-serif; font-weight: 700; }

        /* ── NAV ── */
        .sb-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px;
            height: 68px;
            background: rgba(11, 13, 17, 0.96) !important;
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .sb-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 22px;
            color: #fff;
            text-decoration: none;
            display: flex; align-items: center; gap: 10px;
        }
        .sb-brand .dot {
            color: var(--neon);
            text-shadow: 0 0 15px rgba(162, 224, 67, 0.7);
        }
        .sb-logo-icon {
            width: 36px; height: 36px;
            background: var(--neon);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #000; font-size: 16px;
            box-shadow: 0 0 16px rgba(162, 224, 67, 0.6);
        }

        .sb-links {
            display: flex; align-items: center; gap: 8px;
            list-style: none;
        }
        .sb-links a {
            color: #ddd;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background .18s, color .18s;
        }
        .sb-links a:hover { background: #111111; color: var(--neon); }
        .sb-links .btn-accent-nav {
            background: var(--neon) !important;
            color: #000000 !important;
            font-weight: 800 !important;
            border-radius: 100px;
            padding: 10px 22px;
            box-shadow: var(--neon-glow) !important;
            transition: all 0.25s ease;
        }
        .sb-links .btn-accent-nav:hover {
            background: var(--accent-hover) !important;
            box-shadow: var(--neon-glow-lg) !important;
            transform: translateY(-2px);
            color: #000000 !important;
        }
        .sb-links .btn-primary-nav {
            background: rgba(255, 255, 255, 0.08);
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 100px;
            padding: 8px 18px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .sb-links .btn-primary-nav:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
        }

        /* ── MAIN ── */
        main { padding-top: 68px; min-height: calc(100vh - 68px); background: var(--paper); }

        /* ── CARDS ── */
        .sb-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.8);
        }

        /* ── FOOTER ── */
        .sb-footer {
            background: #000;
            color: var(--muted);
            padding: 60px 40px 40px;
            border-top: 1px solid var(--border);
        }
        .sb-footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            max-width: 1100px;
            margin: 0 auto 48px;
        }
        .sb-footer-brand { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 20px; color: #fff; margin-bottom: 12px; }
        .sb-footer h5 { font-family: 'Syne', sans-serif; color: #fff; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; }
        .sb-footer ul { list-style: none; }
        .sb-footer ul li { margin-bottom: 10px; }
        .sb-footer ul li a { color: var(--muted); text-decoration: none; font-size: 14px; transition: color .15s; }
        .sb-footer ul li a:hover { color: #fff; }
        .sb-footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 28px;
            max-width: 1100px;
            margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 13px;
        }
        .sb-social a {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            color: var(--muted);
            margin-left: 8px;
            transition: border-color .15s, color .15s;
            text-decoration: none;
        }
        .sb-social a:hover { border-color: #fff; color: #fff; }

        /* ── CONTACT FORM ── */
        .contact-section { padding: 80px 40px; max-width: 1100px; margin: 0 auto; }
        .contact-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 60px; align-items: start; }
        .contact-info-item { display: flex; gap: 16px; margin-bottom: 28px; }
        .contact-icon {
            width: 44px; height: 44px; flex-shrink: 0;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .contact-icon i { color: #fff; }
        .contact-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-bottom: 2px; }
        .contact-value { font-weight: 500; font-size: 15px; color: #fff; }

        .sb-search-input {
            width: 100%;
            height: 56px;
            background: rgba(44, 51, 42, 0.4);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0 20px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #fff;
            color-scheme: dark;
            outline: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .sb-search-input:hover { border-color: rgba(162, 224, 67, 0.4); }
        .sb-search-input:focus {
            border-color: var(--accent);
            background: rgba(44, 51, 42, 0.8);
            box-shadow: 0 0 15px rgba(162, 224, 67, 0.2);
        }
        .sb-input {
            width: 100%;
            background: var(--seat-empty);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 18px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #fff;
            margin-bottom: 16px;
            transition: border-color .2s;
            outline: none;
        }
        .sb-input:focus { border-color: var(--cyan); }
        .sb-input::placeholder { color: var(--muted); }

        /* ── PAGE HERO ── */
        .page-hero {
            background: var(--paper);
            color: #fff;
            padding: 80px 40px;
            text-align: center;
        }
        .page-hero h1 { font-family: 'Syne', sans-serif; font-size: clamp(28px,4vw,48px); margin-bottom: 10px; }
        .page-hero p { color: var(--muted); font-size: 16px; }

        /* ── SECTION WRAPPER ── */
        .section-wrap { max-width: 1200px; margin: 0 auto; padding: 60px 20px; }

        /* ── BADGE ── */
        .sb-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ── BUS SEAT SELECTION ── */
        .bus-cabin {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 40px 20px;
            max-width: 380px;
            margin: 0 auto;
            position: relative;
        }

        .cabin-front {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .cabin-indicator {
            background: var(--seat-empty);
            border-radius: 100px;
            padding: 10px 24px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            min-width: 100px;
            text-align: center;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: 20px 1fr 1fr 30px 1fr 1fr;
            gap: 16px 14px;
            align-items: center;
        }

        .aisle { grid-column: 4; }

        .seat-item { position: relative; width: 48px; height: 50px; }
        .seat-item input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }

        .seat-visual {
            width: 100%; height: 100%;
            background: var(--seat-empty);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 15px; font-weight: 500;
            color: #fff;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .trip-time { font-size: 16px; color: #fff; font-weight: 700; }

        .seat-item:hover .seat-visual { filter: brightness(1.2); transform: translateY(-1px); }

        /* Empty / Available (3D Blue) */
        .seat-item.available .seat-visual {
            background: linear-gradient(180deg, #3871ce 0%, #2251a3 100%);
            border: 1px solid #1a3c82;
            box-shadow: inset 0 2px 2px rgba(255,255,255,0.3), 0 5px 8px rgba(0,0,0,0.5), 0 2px 4px rgba(0,0,0,0.3);
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
            border-radius: 8px;
        }

        /* Chosen / Selected (3D Green) */
        .seat-item input:checked + .seat-visual {
            background: linear-gradient(180deg, #51a540 0%, #307a22 100%);
            border: 1px solid #205c14;
            box-shadow: inset 0 2px 2px rgba(255,255,255,0.4), 0 3px 5px rgba(0,0,0,0.5);
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
            border-radius: 8px;
            color: #fff;
            font-weight: 700;
            transform: translateY(2px);
        }

        /* Filled / Booked (3D Red X) */
        .seat-item.booked .seat-visual {
            background: linear-gradient(180deg, #d34539 0%, #a82419 100%);
            border: 1px solid #851810;
            box-shadow: inset 0 2px 2px rgba(255,255,255,0.4), 0 2px 4px rgba(0,0,0,0.5);
            text-shadow: 0 2px 2px rgba(0,0,0,0.6);
            border-radius: 8px;
            color: #fff;
            font-weight: 700;
            cursor: not-allowed;
            opacity: 1;
        }

        /* ── DASHBOARD / LEGEND ── */
        .seat-legend {
            display: flex; justify-content: center; gap: 24px;
            margin-bottom: 32px;
            padding: 10px 0;
        }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; color: var(--muted); }
        .legend-box {
            width: 20px; height: 20px; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: #fff; text-shadow: 0 1px 1px rgba(0,0,0,0.6);
        }
        .legend-box.empty { background: linear-gradient(180deg, #3871ce 0%, #2251a3 100%); border: 1px solid #1a3c82; box-shadow: inset 0 1px 1px rgba(255,255,255,0.3); }
        .legend-box.chosen { background: linear-gradient(180deg, #51a540 0%, #307a22 100%); border: 1px solid #205c14; box-shadow: inset 0 1px 1px rgba(255,255,255,0.4); }
        .legend-box.filled { background: linear-gradient(180deg, #d34539 0%, #a82419 100%); border: 1px solid #851810; box-shadow: inset 0 1px 1px rgba(255,255,255,0.4); }

        .booking-summary-fancy {
            margin-top: 32px;
            padding: 24px;
            background: var(--paper); /* Even darker inset */
            border-radius: 20px;
        }

        .sb-btn-full {
            width: 100%;
            background: var(--neon);
            color: #000000 !important;
            border: none;
            padding: 18px;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: all .25s ease;
            text-align: center;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: var(--neon-glow);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sb-btn-full:hover { 
            background: var(--accent-hover); 
            box-shadow: var(--neon-glow-lg); 
            transform: translateY(-2px); 
            color: #000000 !important;
        }

        .sb-btn {
            background: #0d0d0d;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 14px 28px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
        }
        .sb-btn:hover { 
            border-color: var(--neon); 
            color: var(--neon); 
            box-shadow: 0 0 20px rgba(162, 224, 67, 0.3);
            transform: translateY(-1px);
        }
        .sb-btn-accent, .sb-btn-primary { 
            background: var(--neon) !important; 
            border-color: var(--neon) !important; 
            color: #000000 !important; 
            font-weight: 900 !important;
            box-shadow: var(--neon-glow) !important;
        }
        .sb-btn-accent:hover, .sb-btn-primary:hover { 
            background: var(--accent-hover) !important; 
            border-color: var(--accent-hover) !important; 
            color: #000000 !important; 
            box-shadow: var(--neon-glow-lg) !important;
            transform: translateY(-2px) !important;
        }

        /* BOOKING SITE SPECIFIC UTILITIES */
        .glass-card {
            background: rgba(28, 32, 27, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid #ffffff;
            border-radius: 20px;
        }

        .swiper-button-next, .swiper-button-prev {
            color: var(--accent);
            background: rgba(44, 51, 42, 0.8);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(162, 224, 67, 0.3);
            backdrop-filter: blur(8px);
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: var(--accent);
            color: #0d1a09;
        }
        .swiper-pagination-bullet-active {
            background: var(--accent) !important;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(15px);
            background: rgba(18, 22, 17, 0.8) !important;
            border-bottom: 1px solid var(--border);
        }

        /* Hero Booking Bar */
        .booking-bar {
            background: rgba(28, 32, 27, 0.9);
            backdrop-filter: blur(20px);
            padding: 10px;
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 900px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .booking-bar-item {
            flex: 1;
            padding: 12px 24px;
            display: flex;
            flex-direction: column;
        }
        .booking-bar-item:not(:last-child) {
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .booking-bar-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 4px;
            font-weight: 700;
        }
        .booking-bar-input {
            background: transparent;
            border: none;
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 16px;
            outline: none;
            width: 100%;
            cursor: pointer;
        }
        .booking-bar-input option {
            background-color: #1c201b !important;
            color: #fff !important;
            padding: 10px;
        }
        .booking-bar-input::placeholder { color: #555; }
        .booking-bar-btn {
            background: var(--accent);
            color: #0d1a09;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
            flex-shrink: 0;
        }
        .booking-bar-btn:hover { transform: scale(1.05); background: #8dc63f; }

        /* Custom Scrollbar for Premium Feel */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--paper); }
        ::-webkit-scrollbar-thumb { background: #2a2f3a; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3a3f4a; }

        /* Premium SweetAlert2 Custom Styling */
        .sb-swal-popup {
            background: #080808 !important;
            border: 1.5px solid rgba(162, 224, 67, 0.35) !important;
            border-radius: 26px !important;
            padding: 38px 30px !important;
            box-shadow: 0 25px 70px rgba(0,0,0,0.95), 0 0 45px rgba(162, 224, 67, 0.2) !important;
        }
        .sb-swal-popup .swal2-title {
            color: #ffffff !important;
            font-family: 'Syne', sans-serif !important;
            font-size: 26px !important;
            font-weight: 800 !important;
            letter-spacing: -0.5px !important;
            margin-bottom: 14px !important;
        }
        .sb-swal-popup .swal2-html-container {
            color: #f1f5f9 !important;
            font-size: 18px !important;
            line-height: 1.6 !important;
            font-weight: 500 !important;
            margin: 12px 0 24px !important;
        }
        .sb-swal-popup .swal2-confirm {
            background: var(--neon) !important;
            color: #000000 !important;
            font-weight: 900 !important;
            font-size: 15px !important;
            border-radius: 12px !important;
            padding: 14px 34px !important;
            box-shadow: var(--neon-glow) !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.25s ease !important;
        }
        .sb-swal-popup .swal2-confirm:hover {
            background: var(--accent-hover) !important;
            transform: translateY(-2px) !important;
            box-shadow: var(--neon-glow-lg) !important;
        }
    </style>
</head>
<body>
    @include('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.addEventListener('notify', event => {
        const type = event.detail.type || 'info';
        const isSuccess = type === 'success';
        const isWarning = type === 'warning';

        Swal.fire({
            icon: type,
            title: isSuccess ? 'Success!' : (isWarning ? 'Notice' : 'Attention'),
            text: event.detail.message,
            timer: isSuccess ? 3000 : 6000,
            timerProgressBar: true,
            showConfirmButton: !isSuccess,
            confirmButtonText: 'Understood',
            position: 'center',
            toast: false,
            background: '#080808',
            color: '#ffffff',
            iconColor: isSuccess ? '#a2e043' : (isWarning ? '#a2e043' : '#ff4d4d'),
            customClass: {
                popup: 'sb-swal-popup'
            }
        });
    });
    </script>

    <script src="{{ url('frontend/js/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ url('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('frontend/js/functions.js') }}"></script>

    @livewireScripts
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    if (status === 419) {
                        preventDefault();
                        window.location.reload();
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.trips-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoHeight: false, /* Ensure cards stretch */
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        });
    </script>
</body>
</html>
