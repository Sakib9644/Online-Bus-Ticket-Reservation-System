@extends('frontend.index')
@section('content')

{{-- HERO --}}
<section style="background:var(--paper); color:#fff; padding: 100px 40px 80px; position:relative; overflow:hidden; border-bottom: 1px solid rgba(255,255,255,0.1);">
    <div style="position:absolute; inset:0; background: radial-gradient(ellipse 60% 80% at 70% 50%, rgba(141,198,63,0.15) 0%, transparent 70%); pointer-events:none;"></div>
    <div style="position:absolute; top:20px; right:80px; width:300px; height:300px; border-radius:50%; border:1px solid rgba(255,255,255,0.15); opacity:.5;"></div>
    <div style="position:absolute; top:60px; right:120px; width:180px; height:180px; border-radius:50%; border:1px solid rgba(255,255,255,0.3); opacity:.6;"></div>

    <div style="max-width:1100px; margin:0 auto; position:relative;">
        <span class="sb-badge" style="background:#1a1a1a; color:#888; margin-bottom:24px; display:inline-flex;">🚌 Bangladesh's easiest bus booking</span>
        <h1 class="syne" style="font-size:clamp(40px,6vw,80px); line-height:1.05; margin-bottom:24px; font-weight:800;">
            Travel smart.<br><span style="color:var(--accent);">Book fast.</span>
        </h1>
        <p style="color:#999; font-size:18px; max-width:480px; margin-bottom:40px;">Find available buses, choose your seat, and get on the road — all in minutes.</p>
        <a href="{{ route('frontend.reserve') }}" class="sb-btn sb-btn-accent" style="font-size:16px; padding:16px 36px; display:inline-block; text-decoration:none;">
            Search Trips →
        </a>
    </div>
</section>

{{-- STATS STRIP --}}
<section style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
    <div style="max-width:1100px; margin:0 auto; display:grid; grid-template-columns:repeat(3,1fr); text-align:center; padding:32px 20px;">
        <div style="border-right:1px solid rgba(255,255,255,0.05); padding:16px;">
            <div class="syne" style="font-size:36px; font-weight:800;">{{ count($buses) }}</div>
            <div style="color:var(--muted); font-size:13px; margin-top:4px;">Active Buses</div>
        </div>
        <div style="border-right:1px solid rgba(255,255,255,0.05); padding:16px;">
            <div class="syne" style="font-size:36px; font-weight:800;">24/7</div>
            <div style="color:var(--muted); font-size:13px; margin-top:4px;">Support</div>
        </div>
        <div style="padding:16px;">
            <div class="syne" style="font-size:36px; font-weight:800;">100%</div>
            <div style="color:var(--muted); font-size:13px; margin-top:4px;">Secure Payments</div>
        </div>
    </div>
</section>

{{-- BUS FLEET --}}
<section class="section-wrap" style="padding-bottom: 100px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px; flex-wrap:wrap; gap:16px;">
        <div>
            <span class="sb-badge" style="margin-bottom:12px;">Fleet</span>
            <h2 class="syne" style="font-size:clamp(22px,3vw,36px); font-weight:800;">Our Buses</h2>
        </div>
        <a href="{{ route('frontend.reserve') }}" style="color:var(--accent); text-decoration:none; font-weight:500; font-size:14px;">View all trips →</a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:24px;">
        @forelse ($buses as $bus)
        <div class="sb-card">
            <div style="aspect-ratio:16/9; overflow:hidden; background:#f0ede8;">
                <img src="{{ url('/uploads/' . $bus->image) }}" alt="{{ $bus->bus_name }}"
                     style="width:100%; height:100%; object-fit:cover; transition:transform .4s;"
                     onmouseover="this.style.transform='scale(1.05)'"
                     onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="padding:20px;">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:12px;">
                    <h3 class="syne" style="font-size:18px; font-weight:700;">{{ $bus->bus_name }}</h3>
                    <span style="background:{{ $bus->bus_type == 'ac' ? '#e8f5e9' : '#fff3e0' }}; color:{{ $bus->bus_type == 'ac' ? '#2e7d32' : '#e65100' }}; font-size:11px; font-weight:600; padding:4px 10px; border-radius:100px; text-transform:uppercase;">
                        {{ $bus->bus_type }}
                    </span>
                </div>
                <div style="display:flex; gap:8px; align-items:center; color:var(--muted); font-size:13px;">
                    <i class="fas fa-hashtag" style="font-size:11px;"></i>
                    {{ $bus->bus_no }}
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:var(--muted);">
            <i class="fas fa-bus" style="font-size:48px; margin-bottom:16px; display:block; opacity:.3;"></i>
            <p>No buses available right now.</p>
        </div>
        @endforelse
    </div>
</section>

@endsection
