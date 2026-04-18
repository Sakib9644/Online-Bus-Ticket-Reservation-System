@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Fleet Seat Configuration</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Configure seat layouts. Choose between adding a single seat or bulk generating a full vehicle capacity.</p>
    </div>

    @if ($errors->any())
        <div class="alert-danger-admin" style="background:#fee2e2; border:1px solid #fecaca; border-radius:10px; padding:16px; color:#b91c1c; margin-bottom:24px; font-size:14px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-form-card">
        <form action="{{route('admin.seat.store')}}" method="POST">
            @csrf
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group" style="grid-column: span 2;">
                    <label class="admin-label">Target Vehicle</label>
                    <select class="admin-input admin-select" required name="bus_id">
                        <option value="">Select a Bus</option>
                        @foreach ($buses as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->bus_name }} ({{ $bus->bus_no }}) — {{ ucfirst($bus->bus_type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group" style="background:#f8fafc; border:1px solid var(--border); border-radius:12px; padding:20px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                        <i class="fas fa-magic" style="color:var(--accent);"></i>
                        <label class="admin-label" style="margin:0;">Option A: Bulk Generation</label>
                    </div>
                    <p style="font-size:12px; color:var(--muted); margin-bottom:16px;">System will automatically create labels (A1, A2, A3, A4... B1...) up to the total count.</p>
                    <label class="admin-label">Total Seat Count</label>
                    <input name="total_seats" type="number" placeholder="e.g. 40" class="admin-input">
                </div>

                <div class="admin-form-group" style="background:#f8fafc; border:1px solid var(--border); border-radius:12px; padding:20px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                        <i class="fas fa-pen" style="color:#64748b;"></i>
                        <label class="admin-label" style="margin:0;">Option B: Single Entry</label>
                    </div>
                    <p style="font-size:12px; color:var(--muted); margin-bottom:16px;">Manually define a specific seat label if you only need one addition.</p>
                    <label class="admin-label">Manual Seat Label</label>
                    <input name="name" type="text" placeholder="e.g. VIP-1" class="admin-input">
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.seat') }}" class="btn-outline-admin">Discard Changes</a>
                <button type="submit" class="btn-primary-admin" style="min-width:160px; justify-content:center;">Process Configuration</button>
            </div>
        </form>
    </div>
</div>

@endsection