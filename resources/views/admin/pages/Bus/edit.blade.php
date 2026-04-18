@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Update Vehicle Details</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Modify information for vehicle #{{ $bus->id }} — {{ $bus->bus_name }}</p>
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
        <form action="{{ route('admin.bus.update', $bus->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group">
                    <label class="admin-label">Commercial Name</label>
                    <input name="bus_name" type="text" value="{{ $bus->bus_name }}" placeholder="Bus Name" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Course Number</label>
                    <input name="coach_no" type="text" value="{{ $bus->coach_no }}" placeholder="Bus Number" class="admin-input" style="text-transform:uppercase;">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Vehicle Category</label>
                    <select class="admin-input admin-select" name="bus_type">
                        <option value="">Select Category</option>
                        <option value="Ac Bus" {{ $bus->bus_type == 'Ac Bus' ? 'selected' : '' }}>Luxury AC Bus</option>
                        <option value="Non Ac Bus" {{ $bus->bus_type == 'Non Ac Bus' ? 'selected' : '' }}>Standard Non-AC Bus</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Bus Exterior Image</label>
                    <div style="display:flex; align-items:center; gap:16px;">
                        @if($bus->image)
                            <img src="{{ url('/uploads/' . $bus->image) }}" style="width:50px; height:50px; object-fit:cover; border-radius:10px; border:2px solid var(--border);">
                        @endif
                        <input name="bus_image" type="file" class="admin-input" style="padding:10px; flex:1;">
                    </div>
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.bus') }}" class="btn-outline-admin">Discard Changes</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Update Bus</button>
            </div>
        </form>
    </div>
</div>

@endsection