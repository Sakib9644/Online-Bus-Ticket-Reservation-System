<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SwiftBus – Ticket Reservation</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="{{ url('frontend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    @livewireStyles

    <style>
        :root {
            --ink: #0d0d0d;
            --paper: #faf9f6;
            --accent: #ff4d1c;
            --accent2: #0033ff;
            --muted: #888;
            --card-bg: #ffffff;
            --border: #e8e4de;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--paper);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6,
        .syne { font-family: 'Syne', sans-serif; }

        /* ── NAV ── */
        .sb-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px;
            height: 68px;
            background: rgba(250,249,246,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .sb-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 22px;
            color: var(--ink);
            text-decoration: none;
            display: flex; align-items: center; gap: 10px;
        }
        .sb-brand .dot { color: var(--accent); }
        .sb-logo-icon {
            width: 36px; height: 36px;
            background: var(--ink);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
        }
        .sb-links {
            display: flex; align-items: center; gap: 8px;
            list-style: none;
        }
        .sb-links a {
            color: var(--ink);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background .18s;
        }
        .sb-links a:hover { background: var(--border); }
        .sb-links .btn-primary-nav {
            background: var(--ink);
            color: #fff;
            border-radius: 6px;
        }
        .sb-links .btn-primary-nav:hover { background: #333; }
        .sb-links .btn-accent-nav {
            background: var(--accent);
            color: #fff;
            border-radius: 6px;
        }
        .sb-links .btn-accent-nav:hover { background: #e03a0e; }

        /* ── MAIN ── */
        main { padding-top: 68px; min-height: calc(100vh - 68px); }

        /* ── FOOTER ── */
        .sb-footer {
            background: var(--ink);
            color: #aaa;
            padding: 60px 40px 40px;
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
        .sb-footer ul li a { color: #aaa; text-decoration: none; font-size: 14px; transition: color .15s; }
        .sb-footer ul li a:hover { color: #fff; }
        .sb-footer-bottom {
            border-top: 1px solid #222;
            padding-top: 28px;
            max-width: 1100px;
            margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 13px;
        }
        .sb-social a {
            width: 36px; height: 36px;
            border: 1px solid #333;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            color: #aaa;
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
            background: var(--border);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .contact-icon i { color: var(--ink); }
        .contact-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-bottom: 2px; }
        .contact-value { font-weight: 500; font-size: 15px; }

        .sb-input {
            width: 100%;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--ink);
            margin-bottom: 14px;
            transition: border-color .2s;
            outline: none;
        }
        .sb-input:focus { border-color: var(--ink); }
        .sb-input::placeholder { color: #bbb; }
        .sb-btn {
            background: var(--ink);
            color: #fff;
            border: none;
            padding: 13px 28px;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .sb-btn:hover { background: #333; transform: translateY(-1px); }
        .sb-btn-accent { background: var(--accent); }
        .sb-btn-accent:hover { background: #e03a0e; }

        /* ── CARDS ── */
        .sb-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }
        .sb-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,.1); transform: translateY(-3px); }

        /* ── PAGE HERO ── */
        .page-hero {
            background: var(--ink);
            color: #fff;
            padding: 60px 40px;
            text-align: center;
        }
        .page-hero h1 { font-family: 'Syne', sans-serif; font-size: clamp(28px,4vw,48px); margin-bottom: 10px; }
        .page-hero p { color: #aaa; font-size: 16px; }

        /* ── SECTION WRAPPER ── */
        .section-wrap { max-width: 1100px; margin: 0 auto; padding: 60px 20px; }

        /* ── BADGE ── */
        .sb-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--border);
            border-radius: 100px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* SweetAlert overrides */
        .swal2-toast-custom { font-family: 'DM Sans', sans-serif; font-size: 14px; }

        @media (max-width: 768px) {
            .sb-nav { padding: 0 20px; }
            .sb-footer-grid { grid-template-columns: 1fr; gap: 32px; }
            .contact-grid { grid-template-columns: 1fr; }
            .section-wrap { padding: 40px 16px; }
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
        Swal.fire({
            icon: event.detail.type,
            title: event.detail.type === 'success' ? 'Success!' : 'Oops!',
            text: event.detail.message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
        });
    });
    </script>

    <script src="{{ url('frontend/js/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ url('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('frontend/js/functions.js') }}"></script>

    @livewireScripts
</body>
</html>
