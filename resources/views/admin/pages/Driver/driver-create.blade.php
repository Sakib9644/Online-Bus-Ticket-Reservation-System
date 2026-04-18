@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Register Operator</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Add a certified driver to the transit operations team</p>
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
        <form action="{{route('admin.driver.store')}}" method="POST">
            @csrf
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group" style="grid-column: span 2;">
                    <label class="admin-label">Full Legal Name</label>
                    <input required name="name" type="text" placeholder="e.g. Abdullah Al Mamun" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Driver License / ID</label>
                    <input required name="id" type="text" placeholder="License Number" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Contact Number (11 Digits)</label>
                    <input required name="phone" type="text" placeholder="01XXXXXXXXX" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Assigned Bus Name</label>
                    <input required name="bus_name" type="text" placeholder="e.g. Scania Elite" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Assigned Bus No</label>
                    <input required name="bus_no" type="text" placeholder="e.g. DH-MET-1234" class="admin-input">
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.driver') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Register Operator</button>
            </div>
        </form>
    </div>
</div>

@endsection