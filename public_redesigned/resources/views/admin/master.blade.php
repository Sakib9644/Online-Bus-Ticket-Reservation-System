<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SwiftBus Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --ink: #0d0d0d;
            --paper: #f4f3f0;
            --accent: #ff4d1c;
            --sidebar-w: 240px;
            --topbar-h: 60px;
            --border: #e5e2dc;
            --card: #ffffff;
            --muted: #888;
        }

        body { background: var(--paper); font-family: 'DM Sans', sans-serif; color: var(--ink); }

        /* SIDEBAR */
        #sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--ink);
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }
        .sb-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 20px 20px;
            text-decoration: none;
            border-bottom: 1px solid #1a1a1a;
        }
        .sb-logo-icon { width: 32px; height: 32px; background: var(--accent); border-radius: 7px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; flex-shrink: 0; }
        .sb-logo-text { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 16px; color: #fff; }

        .nav-section { padding: 20px 12px 8px; }
        .nav-section-label { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #333; font-weight: 600; padding: 0 8px; margin-bottom: 8px; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: #666;
            font-size: 14px;
            font-weight: 400;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
        }
        .nav-item i { width: 18px; text-align: center; font-size: 13px; }
        .nav-item:hover { background: #1a1a1a; color: #fff; }
        .nav-item.active { background: #1a1a1a; color: #fff; }
        .nav-item.active i { color: var(--accent); }

        .nav-group-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
            justify-content: space-between;
        }
        .nav-group-btn:hover { background: #1a1a1a; color: #fff; }
        .nav-group-left { display: flex; align-items: center; gap: 10px; }
        .nav-sub { padding-left: 16px; }
        .nav-sub .nav-item { font-size: 13px; color: #555; }
        .nav-sub .nav-item:hover { color: #ccc; }

        /* TOPBAR */
        #topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            z-index: 99;
        }
        .topbar-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; color: var(--ink); }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-avatar {
            width: 34px; height: 34px;
            background: var(--ink);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px; font-family: 'Syne', sans-serif; font-weight: 700;
            cursor: pointer;
        }
        .logout-btn {
            background: #fff; border: 1px solid var(--border);
            padding: 7px 14px; border-radius: 7px;
            font-size: 13px; color: var(--ink);
            text-decoration: none; font-weight: 500;
            transition: background .15s;
        }
        .logout-btn:hover { background: var(--paper); color: var(--ink); }

        /* MAIN */
        #main {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }
        .main-content { padding: 32px 28px; }

        /* CARDS */
        .admin-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .admin-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-card-header h5 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px; margin: 0; }
        .admin-card-body { padding: 20px; }

        /* TABLES */
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table th { padding: 10px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); border-bottom: 1px solid var(--border); font-weight: 600; background: #faf9f6; }
        .admin-table td { padding: 14px 16px; border-bottom: 1px solid var(--border); color: var(--ink); }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: #faf9f6; }

        /* STAT CARDS */
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            display: flex; align-items: center; justify-content: space-between;
            text-decoration: none;
            transition: box-shadow .2s, transform .15s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
        .stat-number { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 32px; color: var(--ink); line-height: 1; }
        .stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-top: 6px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }

        /* BUTTONS */
        .btn-primary-admin { background: var(--ink); color: #fff; border: none; padding: 9px 18px; border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-primary-admin:hover { background: #333; color: #fff; }
        .btn-accent-admin { background: var(--accent); color: #fff; }
        .btn-accent-admin:hover { background: #e03a0e; }
        .btn-outline-admin { background: transparent; border: 1px solid var(--border); color: var(--ink); padding: 8px 16px; border-radius: 8px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-outline-admin:hover { background: var(--paper); color: var(--ink); }
        .btn-danger-admin { background: #fff1f0; color: #c53030; border: 1px solid #ffd4ce; padding: 7px 14px; border-radius: 8px; font-size: 13px; text-decoration: none; transition: background .15s; }
        .btn-danger-admin:hover { background: #ffe4e1; }

        /* FORM */
        .admin-input { width: 100%; background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--ink); outline: none; transition: border-color .2s; }
        .admin-input:focus { border-color: var(--ink); }
        .admin-label { display: block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-bottom: 8px; }

        /* BADGES */
        .badge-success { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 100px; font-size: 12px; font-weight: 600; }
        .badge-warning { background: #fff8e1; color: #f57f17; padding: 3px 10px; border-radius: 100px; font-size: 12px; font-weight: 600; }
        .badge-danger { background: #ffebee; color: #c62828; padding: 3px 10px; border-radius: 100px; font-size: 12px; font-weight: 600; }
        .badge-info { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 100px; font-size: 12px; font-weight: 600; }

        /* ALERTS */
        .alert-success-admin { background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 8px; padding: 12px 16px; color: #2e7d32; font-size: 14px; margin-bottom: 20px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<nav id="sidebar">
    <a class="sb-logo" href="{{ route('admin.dashboard') }}">
        <div class="sb-logo-icon"><i class="fas fa-bus-simple"></i></div>
        <span class="sb-logo-text">SwiftBus</span>
    </a>

    @include('admin.partials.sidebar')
</nav>

<!-- TOPBAR -->
<header id="topbar">
    <span class="topbar-title">Admin Panel</span>
    <div class="topbar-right">
        @if(auth()->user())
        <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <span style="font-size:14px; color:var(--muted);">{{ auth()->user()->name }}</span>
        <a href="{{ route('admin.logout') }}" class="logout-btn">Logout</a>
        @endif
    </div>
</header>

<!-- MAIN -->
<div id="main">
    <div class="main-content">
        @yield('content')
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ url('backend/js/sb-admin-2.min.js') }}"></script>
<script src="{{ url('backend/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ url('backend/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ url('backend/js/demo/chart-pie-demo.js') }}"></script>

</body>
</html>
