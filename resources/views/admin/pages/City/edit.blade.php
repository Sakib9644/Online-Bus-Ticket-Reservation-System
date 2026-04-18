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
        <form action="{{ route('admin.city.update', $city->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="admin-form-group">
                <label class="admin-label">Official City Name</label>
                <input type="text" class="admin-input" value="{{ $city->name }}" name="name" placeholder="City Name" required>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.city') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Update City</button>
            </div>
        </form>
    </div>
</div>

@endsection