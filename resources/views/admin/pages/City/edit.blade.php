@extends('admin.master')
@section('content')

<div style="max-width:600px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Update City Hub</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Modify the official hub details for {{ $city->name }}</p>
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
        <form action="{{ route('admin.city.update', $city->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            
            <div class="admin-form-group">
                <label class="admin-label">Official City Name</label>
                <input type="text" class="admin-input" value="{{ $city->name }}" name="name" placeholder="City Name" required>
            </div>

            <div class="admin-form-group" style="margin-top: 20px;">
                <label class="admin-label">Destination Image (Natural/Landscape)</label>
                
                @if($city->image)
                    <div style="margin-bottom: 12px; border-radius: 12px; overflow: hidden; width: 120px; height: 160px; border: 1px solid var(--border);">
                        <img src="{{ url('/uploads/cities/'.$city->image) }}" alt="{{ $city->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif

                <input type="file" class="admin-input" name="image" accept="image/*" style="padding-top: 8px;">
                <p style="color:#64748b; font-size:11px; margin-top:8px;">Recommended: 800x1200 high-quality nature photography.</p>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.city') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Update City</button>
            </div>
        </form>
    </div>
</div>

@endsection