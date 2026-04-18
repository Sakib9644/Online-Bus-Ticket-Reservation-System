@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Register New Vehicle</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Add a new bus to your digital fleet inventory</p>
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
        <form action="{{ route('admin.bus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group">
                    <label class="admin-label">Commercial Name</label>
                    <input required name="bus_name" type="text" placeholder="e.g. Scania Elite, Volvo B11" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Course Number</label>
                    <input required name="coach_no" type="text" placeholder="e.g. CRS-1001, GT-5" class="admin-input" style="text-transform:uppercase;">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Vehicle Category</label>
                    <select class="admin-input admin-select" required name="bus_type">
                        <option value="">Select Category</option>
                        <option value="Ac Bus">Luxury AC Bus</option>
                        <option value="Non Ac Bus">Standard Non-AC Bus</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Bus Exterior Image</label>
                    <input required name="bus_image" type="file" class="admin-input" style="padding:10px;">
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.bus') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Register Bus</button>
            </div>
        </form>
    </div>
</div>

@endsection