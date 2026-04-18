@extends('admin.master')
@section('content')

<div style="max-width:800px; margin:0 auto;">
    <div style="margin-bottom:32px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Vehicle Profile</h1>
            <p style="color:var(--muted); font-size:14px; margin-top:4px;">In-depth technical and operational details for fleet #{{ $bus->id }}</p>
        </div>
        <a href="{{ route('admin.bus') }}" class="btn-outline-admin">
            <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to Fleet
        </a>
    </div>

    <div class="admin-form-card" style="padding:0; overflow:hidden;">
        <div style="padding:40px; display:flex; gap:32px; align-items:center; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid var(--border);">
            <div style="flex-shrink:0;">
                <img src="{{ url('/uploads/'.$bus->image) }}" style="width:160px; height:110px; object-fit:cover; border-radius:16px; border:4px solid #fff; box-shadow:0 10px 25px rgba(0,0,0,0.1);">
            </div>
            <div>
                <div style="font-size:12px; font-weight:800; color:var(--accent); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">{{ $bus->bus_type }}</div>
                <h2 style="font-size:32px; font-weight:800; color:#0f172a; margin:0;">{{ $bus->bus_name }}</h2>
                <div style="display:inline-flex; align-items:center; gap:8px; margin-top:12px; background:#fff; padding:6px 12px; border-radius:8px; border:1px solid var(--border);">
                    <i class="fas fa-barcode" style="color:var(--muted);"></i>
                    <span style="font-family:monospace; font-weight:700; color:#475569;">{{ $bus->bus_no }}</span>
                </div>
            </div>
        </div>
        
        <div style="padding:40px; display:grid; grid-template-columns: 1fr 1fr; gap:40px;">
            <div>
                <h6 style="font-weight:800; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:20px;">Operational Status</h6>
                <div style="background:#f8fafc; border-radius:12px; padding:20px; border:1px solid var(--border);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                        <span style="color:#64748b; font-size:14px;">Fleet Category</span>
                        <span style="font-weight:700; color:#1e293b;">{{ ucfirst($bus->bus_type) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:#64748b; font-size:14px;">Registration</span>
                        <span style="font-weight:700; color:#1e293b;">Active</span>
                    </div>
                </div>
            </div>
            <div>
                <h6 style="font-weight:800; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:20px;">Management Actions</h6>
                <div style="display:grid; grid-template-columns:1fr; gap:10px;">
                    <a href="{{ route('admin.bus.edit', $bus->id) }}" class="btn-primary-admin" style="justify-content:center;">
                        <i class="fas fa-edit"></i> Edit Specifications
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection