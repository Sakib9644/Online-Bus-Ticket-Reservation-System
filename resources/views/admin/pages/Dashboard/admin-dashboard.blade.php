@extends("admin.master")
@section('content')

@if (session()->has('message'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session()->get('message') }}
    </div>
@endif

<div style="margin-bottom:32px;">
    <h1 style="font-size:28px; font-weight:800; color:#0f172a; letter-spacing:-0.5px; margin-bottom:4px;">Dashboard Overview</h1>
    <p style="color:var(--muted); font-size:15px;">Operational summary for {{ date('l, d F Y') }}</p>
</div>

{{-- STATS GRID --}}
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; margin-bottom:40px;">
    
    <div class="stat-card">
        <div>
            <div class="stat-number">৳{{ number_format($count['revenue'] ?? 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
        <div class="stat-icon" style="background:#f0fdf4;">
            <i class="fas fa-sack-dollar" style="color:#22c55e;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-number">{{ $count['today'] ?? 0 }}</div>
            <div class="stat-label">Today's Bookings</div>
        </div>
        <div class="stat-icon" style="background:#fff7ed;">
            <i class="fas fa-ticket-alt" style="color:#f97316;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-number">{{ $count['bus'] ?? 0 }}</div>
            <div class="stat-label">Active Buses</div>
        </div>
        <div class="stat-icon" style="background:#eff6ff;">
            <i class="fas fa-bus-simple" style="color:#3b82f6;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <div class="stat-number">{{ $count['user'] ?? 0 }}</div>
            <div class="stat-label">Total Passengers</div>
        </div>
        <div class="stat-icon" style="background:#fdf4ff;">
            <i class="fas fa-users-gear" style="color:#a855f7;"></i>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px; margin-bottom:40px;">
    
    {{-- RECENT BOOKINGS --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h5>Recent Transactions</h5>
            <a href="{{ route('admin.booking.list') }}" class="btn-outline-admin" style="padding:6px 12px; font-size:12px;">View All</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Course Number</th>
                        <th>Passenger</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $pnr => $group)
                    @php $f = $group->first(); @endphp
                    <tr>
                        <td>
                            <div style="font-weight:700; color:var(--accent);">{{ $pnr }}</div>
                            <div style="font-size:11px; color:var(--muted);">{{ $f->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ $f->user->name ?? 'User' }}</div>
                        </td>
                        <td style="font-weight:700;">৳{{ number_format($group->sum('amount')) }}</td>
                        <td>
                            <span class="badge-{{ $f->status == 'complete' ? 'success' : 'warning' }}">
                                {{ ucfirst($f->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:40px; color:var(--muted);">No recent logs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- QUICK TOOLS --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h5>Quick Tools</h5>
        </div>
        <div class="admin-card-body" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <a href="{{ route('admin.trip.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; text-decoration:none; transition:all 0.2s;">
                <i class="fas fa-plus-circle" style="color:var(--accent); font-size:18px;"></i>
                <span style="font-size:12px; font-weight:700; color:#1e293b;">New Trip</span>
            </a>
            <a href="{{ route('admin.bus.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; text-decoration:none; transition:all 0.2s;">
                <i class="fas fa-bus-simple" style="color:#22c55e; font-size:18px;"></i>
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Add Bus</span>
            </a>
            <a href="{{ route('admin.location.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; text-decoration:none; transition:all 0.2s;">
                <i class="fas fa-map-pin" style="color:#3b82f6; font-size:18px;"></i>
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Location</span>
            </a>
            <a href="{{ route('admin.seat.create') }}" style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; text-decoration:none; transition:all 0.2s;">
                <i class="fas fa-chair" style="color:#f59e0b; font-size:18px;"></i>
                <span style="font-size:12px; font-weight:700; color:#1e293b;">Add Seat</span>
            </a>
        </div>
    </div>

</div>

@endsection
