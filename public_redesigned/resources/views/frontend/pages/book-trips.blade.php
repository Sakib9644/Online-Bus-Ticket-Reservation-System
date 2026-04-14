@extends('frontend.index')
@section('content')

<div style="background:var(--ink); padding:48px 40px 40px;">
    <div style="max-width:1100px; margin:0 auto;">
        <a href="{{ route('frontend.reserve') }}" style="color:#555; text-decoration:none; font-size:14px; display:inline-flex; align-items:center; gap:6px; margin-bottom:24px;">
            ← Back to search
        </a>
        <h1 class="syne" style="color:#fff; font-size:clamp(24px,3vw,40px); font-weight:800;">Book Your Trip</h1>
        <p style="color:#555; margin-top:6px;">{{ $trip->location_from }} → {{ $trip->location_to }}</p>
    </div>
</div>

<div class="section-wrap" style="padding-top:40px;">
    <div style="display:grid; grid-template-columns:1fr 2fr; gap:28px; align-items:start;">

        {{-- TRIP DETAILS CARD --}}
        <div class="sb-card" style="position:sticky; top:88px;">
            <div style="background:var(--ink); padding:24px; color:#fff;">
                <div style="font-size:12px; text-transform:uppercase; letter-spacing:2px; color:#555; margin-bottom:12px;">Trip Summary</div>
                <div style="font-size:24px; font-weight:700; font-family:'Syne',sans-serif; display:flex; align-items:center; gap:10px;">
                    {{ $trip->location_from }}
                    <span style="color:#ff4d1c; font-size:18px;">→</span>
                    {{ $trip->location_to }}
                </div>
            </div>
            <div style="padding:24px;">
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:16px; border-bottom:1px solid var(--border);">
                        <span style="color:var(--muted); font-size:13px;">Fare</span>
                        <span style="font-family:'Syne',sans-serif; font-weight:700; font-size:20px; color:var(--accent);">৳{{ $trip->fare }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:14px;">
                        <span style="color:var(--muted);">Bus Name</span>
                        <span style="font-weight:500;">{{ $trip->bus->bus_name }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:14px;">
                        <span style="color:var(--muted);">Bus Number</span>
                        <span style="font-weight:500;">{{ $trip->bus->bus_no }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:14px;">
                        <span style="color:var(--muted);">Type</span>
                        <span style="background:{{ $trip->bus->bus_type == 'ac' ? '#e8f5e9' : '#fff3e0' }}; color:{{ $trip->bus->bus_type == 'ac' ? '#2e7d32' : '#e65100' }}; font-size:11px; font-weight:600; padding:4px 10px; border-radius:100px; text-transform:uppercase;">
                            {{ ucfirst($trip->bus->bus_type) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEAT SELECTION --}}
        <div class="sb-card">
            <div style="padding:24px 24px 16px; border-bottom:1px solid var(--border);">
                <h3 class="syne" style="font-size:18px; font-weight:700;">Choose Your Seat</h3>
                <p style="color:var(--muted); font-size:13px; margin-top:4px;">Tap an available seat to select it</p>
            </div>
            <div style="padding:24px;">
                <div style="display:flex; gap:20px; margin-bottom:24px; flex-wrap:wrap;">
                    <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                        <div style="width:24px; height:24px; border-radius:6px; background:#e8f5e9; border:1px solid #c8e6c9;"></div>
                        <span style="color:var(--muted);">Available</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                        <div style="width:24px; height:24px; border-radius:6px; background:#ffebee; border:1px solid #ffcdd2;"></div>
                        <span style="color:var(--muted);">Booked</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                        <div style="width:24px; height:24px; border-radius:6px; background:var(--ink);"></div>
                        <span style="color:var(--muted);">Selected</span>
                    </div>
                </div>
                <livewire:trip-book :trip="$trip" />
            </div>
        </div>
    </div>
</div>

@endsection
