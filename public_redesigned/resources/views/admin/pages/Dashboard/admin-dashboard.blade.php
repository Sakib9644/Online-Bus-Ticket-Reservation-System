@extends("admin.master")
@section('content')

@if (session()->has('message'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session()->get('message') }}
    </div>
@endif

<div style="margin-bottom:28px;">
    <h1 class="syne" style="font-size:26px; font-weight:800; margin-bottom:6px;">Dashboard</h1>
    <p style="color:var(--muted); font-size:14px;">Welcome back, {{ auth()->user()->name ?? 'Admin' }} 👋</p>
</div>

{{-- STAT CARDS --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px; margin-bottom:32px;">

    <a href="{{ route('passenger') }}" class="stat-card" style="text-decoration:none;">
        <div>
            <div class="stat-number">{{ $count['user'] }}</div>
            <div class="stat-label">Passengers</div>
        </div>
        <div class="stat-icon" style="background:#e8f5e9;">
            <i class="fas fa-users" style="color:#2e7d32;"></i>
        </div>
    </a>

    <a href="{{ route('admin.booking.list') }}" class="stat-card" style="text-decoration:none;">
        <div>
            <div class="stat-number">{{ $count['booking'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-icon" style="background:#fff8e1;">
            <i class="fas fa-ticket" style="color:#f57f17;"></i>
        </div>
    </a>

    <a href="{{ route('admin.bus') }}" class="stat-card" style="text-decoration:none;">
        <div>
            <div class="stat-number">{{ $count['bus'] }}</div>
            <div class="stat-label">Active Buses</div>
        </div>
        <div class="stat-icon" style="background:#fff1f0;">
            <i class="fas fa-bus" style="color:#ff4d1c;"></i>
        </div>
    </a>

</div>

{{-- QUICK ACTIONS --}}
<div class="admin-card" style="margin-bottom:24px;">
    <div class="admin-card-header">
        <h5>Quick Actions</h5>
    </div>
    <div class="admin-card-body">
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <a href="{{ route('admin.trip.create') }}" class="btn-primary-admin"><i class="fas fa-plus"></i> New Trip</a>
            <a href="{{ route('admin.bus.create') }}" class="btn-outline-admin"><i class="fas fa-bus"></i> Add Bus</a>
            <a href="{{ route('admin.location.create') }}" class="btn-outline-admin"><i class="fas fa-map-pin"></i> Add Location</a>
            <a href="{{ route('admin.seat.create') }}" class="btn-outline-admin"><i class="fas fa-chair"></i> Add Seat</a>
        </div>
    </div>
</div>

@endsection
