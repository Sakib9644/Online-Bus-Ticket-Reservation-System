@extends('admin.master')
@section('content')

<div style="max-width:800px; margin:0 auto;">
    <div style="margin-bottom:32px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Counter Profile</h1>
            <p style="color:var(--muted); font-size:14px; margin-top:4px;">Official branch details and contact information for {{ $counter->counter_name }}</p>
        </div>
        <a href="{{ route('admin.counter') }}" class="btn-outline-admin">
            <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to List
        </a>
    </div>

    <div class="admin-form-card" style="padding:0; overflow:hidden;">
        <div style="padding:40px; display:flex; gap:32px; align-items:center; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border-bottom:1px solid var(--border);">
            <div style="width:100px; height:100px; background:white; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:40px; color:#f97316; font-weight:800; border:4px solid #fff; box-shadow:0 10px 25px rgba(249,115,22,0.1);">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <div style="font-size:12px; font-weight:800; color:#c2410c; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Operational Office</div>
                <h2 style="font-size:32px; font-weight:800; color:#0f172a; margin:0;">{{ $counter->counter_name }}</h2>
                <div style="display:inline-flex; align-items:center; gap:8px; margin-top:12px; background:#fff; padding:6px 12px; border-radius:8px; border:1px solid var(--border);">
                    <i class="fas fa-hashtag" style="color:var(--muted);"></i>
                    <span style="font-weight:700; color:#9a3412;">HUB-{{ $counter->counter_no }}</span>
                </div>
            </div>
        </div>
        
        <div style="padding:40px;">
            <div style="max-width:400px;">
                <h6 style="font-weight:800; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:20px;">Contact Specifications</h6>
                <div style="background:#f8fafc; border-radius:12px; padding:24px; border:1px solid var(--border);">
                    <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px; border-bottom:1px solid #e2e8f0; padding-bottom:16px;">
                        <div style="width:36px; height:36px; border-radius:50%; background:white; display:flex; align-items:center; justify-content:center; color:#f97316; border:1px solid #e2e8f0;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase;">Phone Numbers</div>
                            <div style="font-weight:700; color:#1e293b; font-size:16px;">{{ $counter->counter_phone }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection