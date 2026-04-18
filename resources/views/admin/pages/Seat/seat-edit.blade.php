@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Edit Seat Configuration</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Modify individual seat allocation for fleet vehicles</p>
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
        <form action="{{route('admin.seat.update',$seat->id)}}" method="POST">
            @csrf
            @method('put')
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group">
                    <label class="admin-label">Seat Label/Number</label>
                    <input name="name" type="text" value="{{ $seat->name }}" placeholder="e.g. A1, B2" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Assign to Vehicle</label>
                    <select class="admin-input admin-select" name="bus_id">
                        <option value="">Select Bus</option>
                        @foreach ($buses as $bus)
                            <option value="{{ $bus->id }}" {{ $seat->bus_id == $bus->id ? 'selected' : '' }}>{{ $bus->bus_name }} ({{ $bus->bus_no }})</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.seat') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Update Seat</button>
            </div>
        </form>
    </div>
</div>

@endsection