@extends('admin.master')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

<!-- Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed;"><i class="fas fa-ticket-alt" style="color:#f97316;"></i></div>
            <div class="stat-num">{{ $totalBookings ?? 284 }}</div>
            <div class="stat-label">Total Bookings</div>
            <div class="stat-change stat-up"><i class="fas fa-arrow-up"></i> +12% this month</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;"><i class="fas fa-bus" style="color:#22c55e;"></i></div>
            <div class="stat-num">{{ $totalBuses ?? 18 }}</div>
            <div class="stat-label">Active Buses</div>
            <div class="stat-change stat-up"><i class="fas fa-arrow-up"></i> +2 new buses</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;"><i class="fas fa-route" style="color:#3b82f6;"></i></div>
            <div class="stat-num">{{ $totalTrips ?? 42 }}</div>
            <div class="stat-label">Active Trips</div>
            <div class="stat-change stat-up"><i class="fas fa-arrow-up"></i> +5 this week</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf4ff;"><i class="fas fa-users" style="color:#a855f7;"></i></div>
            <div class="stat-num">{{ $totalUsers ?? 1284 }}</div>
            <div class="stat-label">Registered Users</div>
            <div class="stat-change stat-up"><i class="fas fa-arrow-up"></i> +84 this week</div>
        </div>
    </div>
</div>

<!-- Revenue + Recent Bookings -->
<div class="row g-4 mb-4">
    <div class="col-xl-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <div class="content-card-title">📊 Quick Stats</div>
            </div>
            <div class="content-card-body">
                @php
                $stats = [
                    ['Total Revenue', '৳ 1,24,500', '#22c55e'],
                    ['Today\'s Bookings', '24', '#f97316'],
                    ['Pending Bookings', '7', '#f59e0b'],
                    ['Cancelled Today', '2', '#ef4444'],
                    ['Total Drivers', $totalDrivers ?? 22, '#3b82f6'],
                    ['Total Counters', $totalCounters ?? 8, '#8b5cf6'],
                    ['Total Cities', $totalCities ?? 12, '#06b6d4'],
                    ['Total Routes', $totalRoutes ?? 15, '#84cc16'],
                ];
                @endphp
                @foreach($stats as $s)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:11px 0;border-bottom:1px solid #f8fafc;">
                    <span style="font-size:13.5px;color:#475569;">{{ $s[0] }}</span>
                    <span style="font-size:14px;font-weight:700;color:{{ $s[2] }};">{{ $s[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="content-card">
            <div class="content-card-header">
                <div class="content-card-title">🎟️ Recent Bookings</div>
                <a href="{{ url('/admin/booking-list') }}" class="btn-primary-admin" style="font-size:12px;padding:7px 14px;">View All</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Passenger</th>
                            <th>Route</th>
                            <th>Seat(s)</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($recentBookings)
                            @foreach($recentBookings as $b)
                            <tr>
                                <td><span style="font-weight:700;color:#0f172a;">#{{ $b->id }}</span></td>
                                <td>{{ $b->user->name ?? 'N/A' }}</td>
                                <td>{{ $b->trip->from ?? '—' }} → {{ $b->trip->to ?? '—' }}</td>
                                <td>{{ $b->seats ?? '—' }}</td>
                                <td style="font-weight:700;color:#0f172a;">৳ {{ number_format($b->amount ?? 0) }}</td>
                                <td><span class="badge-status badge-success">Confirmed</span></td>
                            </tr>
                            @endforeach
                        @else
                            @php
                            $demo = [
                                ['#2841','Rahim Uddin','Dhaka → Ctg','A1, A2','৳ 900','success','Confirmed'],
                                ['#2840','Karim Hossain','Dhaka → Sylhet','B3','৳ 550','info','Pending'],
                                ['#2839','Nusrat Jahan','Ctg → Cox\'s Bazar','C1','৳ 350','warning','Processing'],
                                ['#2838','Sakib Ahmed','Dhaka → Rajshahi','D2, D3','৳ 1,200','success','Confirmed'],
                                ['#2837','Fatema Begum','Dhaka → Khulna','E4','৳ 650','danger','Cancelled'],
                            ];
                            @endphp
                            @foreach($demo as $d)
                            <tr>
                                <td><span style="font-weight:700;color:#0f172a;">{{ $d[0] }}</span></td>
                                <td><div style="font-weight:600;color:#0f172a;">{{ $d[1] }}</div></td>
                                <td>{{ $d[2] }}</td>
                                <td><span style="background:#f8fafc;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600;">{{ $d[3] }}</span></td>
                                <td style="font-weight:700;color:#0f172a;">{{ $d[4] }}</td>
                                <td><span class="badge-status badge-{{ $d[5] }}">{{ $d[6] }}</span></td>
                            </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">⚡ Quick Actions</div>
    </div>
    <div class="content-card-body">
        <div class="row g-3">
            @php
            $actions = [
                ['/admin/trip-create','fas fa-plus','Add New Trip','#fff7ed','#f97316'],
                ['/admin/bus-create','fas fa-bus','Add New Bus','#f0fdf4','#22c55e'],
                ['/admin/driver-create','fas fa-id-card','Add Driver','#eff6ff','#3b82f6'],
                ['/admin/city-create','fas fa-city','Add City','#fdf4ff','#a855f7'],
                ['/admin/counter-create','fas fa-store','Add Counter','#fffbeb','#f59e0b'],
                ['/admin/busroute-create','fas fa-map-signs','Add Route','#f0fdfa','#14b8a6'],
            ];
            @endphp
            @foreach($actions as $a)
            <div class="col-xl-2 col-md-4 col-6">
                <a href="{{ url($a[0]) }}" style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:20px 12px;background:{{ $a[3] }};border-radius:14px;border:1px solid {{ $a[4] }}22;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div style="width:44px;height:44px;background:{{ $a[4] }}22;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:{{ $a[4] }};"><i class="{{ $a[1] }}"></i></div>
                    <div style="font-size:12.5px;font-weight:700;color:#0f172a;text-align:center;">{{ $a[2] }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
