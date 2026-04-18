@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Schedule New Trip</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Define the details and pricing for a new bus route departure</p>
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
        <form action="{{ route('admin.trip.store') }}" method="POST">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group">
                    <label class="admin-label">Departure Terminal</label>
                    <select class="admin-input admin-select" required name="location_from">
                        <option value="">Select Origin</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Destination Terminal</label>
                    <select class="admin-input admin-select" required name="location_to">
                        <option value="">Select Destination</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group" style="grid-column: span 2;">
                    <label class="admin-label">Assigned Vehicle</label>
                    <select class="admin-input admin-select" required name="bus_id">
                        <option value="">Select Bus</option>
                        @foreach ($buses as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->bus_name }} ({{ $bus->bus_no }}) — {{ ucfirst($bus->bus_type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Departure Date</label>
                    <input required name="date" type="date" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Departure Time</label>
                    <input type="text" class="admin-input timepicker" required name="time" placeholder="Choose time (e.g. 10:30 AM)">
                </div>

                <div class="admin-form-group" style="grid-column: span 2;">
                    <label class="admin-label">Ticket Fare (BDT)</label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--muted); font-weight:700;">৳</span>
                        <input required name="bus_fare" type="number" class="admin-input" placeholder="0.00" style="padding-left:32px;">
                    </div>
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.trip') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:140px; justify-content:center;">Create Trip</button>
            </div>
        </form>
    </div>
</div>

@endsection
