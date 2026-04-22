<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SwiftBus Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar { background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
        .flatpickr-time { border-top: none; }
    </style>

    <style>
        :root {
            --ink: #0f172a;
            --paper: #f1f5f9;
            --accent: #3b82f6;
            --sidebar-w: 250px;
            --topbar-h: 64px;
            --border: #e2e8f0;
            --card: #ffffff;
            --muted: #64748b;
        }

        body { background: var(--paper); font-family: 'Poppins', sans-serif; color: var(--ink); line-height: 1.5; }

        /* SIDEBAR */
        #sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: #1e293b;
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }
        .sb-logo {
            display: flex; align-items: center; gap: 12px;
            padding: 24px 20px;
            text-decoration: none;
            background: rgba(0,0,0,0.1);
        }
        .sb-logo-icon { width: 34px; height: 34px; background: var(--accent); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 15px; flex-shrink: 0; }
        .sb-logo-text { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 18px; color: #fff; letter-spacing: -0.5px; }

        .nav-section { padding: 24px 16px 8px; }
        .nav-section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #475569; font-weight: 700; padding: 0 12px; margin-bottom: 12px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
            margin-bottom: 4px;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 14px; opacity: 0.7; }
        .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-item.active { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .nav-item.active i { color: #fff; opacity: 1; }

        .nav-group-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 4px;
            justify-content: space-between;
        }
        .nav-group-btn:hover { background: rgba(255,255,255,0.05); color: #fff; }

        /* TOPBAR */
        #topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
            z-index: 99;
        }
        .topbar-title { font-weight: 700; font-size: 18px; color: var(--ink); }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-avatar {
            width: 36px; height: 36px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 14px; font-weight: 700;
            border: 1px solid var(--border);
        }
        .logout-btn {
            background: #fff; border: 1px solid #fee2e2;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; color: #ef4444;
            text-decoration: none; font-weight: 600;
            transition: all .2s;
        }
        .logout-btn:hover { background: #fee2e2; }

        /* MAIN */
        #main {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }
        .main-content { padding: 40px; max-width: 1400px; margin: 0 auto; }

        /* CARDS */
        .admin-card {
            background: var(--card);
            border: 1.5px solid #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .admin-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: #fcfcfc;
        }
        .admin-card-header h5 { font-weight: 700; font-size: 16px; margin: 0; color: #1e293b; }
        .admin-card-body { padding: 24px; }

        /* TABLES */
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table th { padding: 14px 20px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid var(--border); font-weight: 700; background: #f8fafc; }
        .admin-table td { padding: 18px 20px; border-bottom: 1px solid var(--border); color: #334155; }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: #f8fafc; }

        /* STAT CARDS */
        .stat-card {
            background: var(--card);
            border: 1.5px solid #ffffff;
            border-radius: 16px;
            padding: 28px;
            display: flex; align-items: center; justify-content: space-between;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .stat-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,.04); transform: translateY(-3px); }
        .stat-number { font-weight: 800; font-size: 28px; color: #0f172a; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 13px; font-weight: 600; color: #64748b; }
        .stat-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }

        /* BUTTONS */
        .btn-primary-admin { background: var(--accent); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
        .btn-primary-admin:hover { background: #2563eb; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2); }
        .btn-outline-admin { background: #fff; border: 1px solid var(--border); color: #64748b; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
        .btn-outline-admin:hover { border-color: var(--accent); color: var(--accent); background: #f0f7ff; }
        .btn-danger-admin { background: #fff; color: #ef4444; border: 1px solid #fee2e2; padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .15s; }
        .btn-danger-admin:hover { background: #ef4444; color: #fff; }

        /* BADGES */
        .badge-success { background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }
        .badge-warning { background: #fef9c3; color: #854d0e; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }
        .badge-danger { background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }
        .badge-info { background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }

        /* FORMS */
        .admin-form-group { margin-bottom: 24px; }
        .admin-label { display: block; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .admin-input { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1.5px solid var(--border); background: #fff; font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; color: var(--ink); transition: all 0.2s; outline: none; }
        .admin-input:focus { border-color: var(--accent); box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        .admin-input::placeholder { color: #94a3b8; }

        .admin-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; padding-right: 40px; }

        .admin-form-card { background: #fff; border: 1.5px solid #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }

        /* ALERTS */
        .alert-success-admin { background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 8px; padding: 12px 16px; color: #2e7d32; font-size: 14px; margin-bottom: 20px; }

        /* DATA TABLES OVERRIDES */
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border) !important; background: #fff !important; margin-left: 4px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--accent) !important; color: #fff !important; border-color: var(--accent) !important; }
        .dataTables_wrapper .dataTables_filter input { padding: 8px 16px; border: 1.5px solid var(--border); border-radius: 10px; outline: none; }
        .dataTables_wrapper table.dataTable { border-collapse: collapse !important; border: 1px solid var(--border) !important; border-radius: 12px; overflow: hidden; margin: 16px 0 !important; }
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false
    });
</script>

</body>
</html>
