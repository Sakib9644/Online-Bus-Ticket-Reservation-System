@extends('admin.master')
@section('content')

<div style="max-width:800px; margin:0 auto;">
    <div style="margin-bottom:32px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Operator Profile</h1>
            <p style="color:var(--muted); font-size:14px; margin-top:4px;">Official employment and assignment record for {{ $driver->driver_name }}</p>
        </div>
        <a href="{{ route('admin.driver') }}" class="btn-outline-admin">
            <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to List
        </a>
    </div>

    <div class="admin-form-card" style="padding:0; overflow:hidden;">
        <div style="padding:40px; display:flex; gap:32px; align-items:center; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom:1px solid var(--border);">
            <div style="width:100px; height:100px; background:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:40px; color:var(--accent); font-weight:800; border:4px solid #fff; box-shadow:0 10px 25px rgba(59,130,246,0.1);">
                {{ substr($driver->driver_name, 0, 1) }}
            </div>
            <div>
                <div style="font-size:12px; font-weight:800; color:var(--accent); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Registered Driver</div>
                <h2 style="font-size:32px; font-weight:800; color:#0f172a; margin:0;">{{ $driver->driver_name }}</h2>
                <div style="display:inline-flex; align-items:center; gap:8px; margin-top:12px; color:#475569; font-weight:600; font-size:14px;">
                    <i class="fas fa-id-badge" style="color:var(--muted);"></i>
                    <span>LICENSE: {{ $driver->driver_id }}</span>
                </div>
            </div>
        </div>
        
        <div style="padding:40px; display:grid; grid-template-columns: 1fr 1fr; gap:40px;">
            <div>
                <h6 style="font-weight:800; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:20px;">Contact Information</h6>
                <div style="background:#f8fafc; border-radius:12px; padding:20px; border:1px solid var(--border);">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                        <i class="fas fa-phone-alt" style="color:var(--muted); font-size:14px;"></i>
                        <span style="font-weight:700; color:#1e293b;">{{ $driver->driver_phone_number }}</span>
                    </div>
                </div>
            </div>
            <div>
                <h6 style="font-weight:800; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:20px;">Current Assignment</h6>
                <div style="background:#f8fafc; border-radius:12px; padding:20px; border:1px solid var(--border);">
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:#64748b;">Vehicle Name</span>
                            <span style="font-weight:700; color:var(--accent);">{{ $driver->bus_name }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:14px;">
                            <span style="color:#64748b;">Registration No</span>
                            <span style="font-weight:700; color:#1e293b;">{{ $driver->bus_no }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection