@extends('frontend.index')
@section('content')

{{-- HERO SECTION --}}
<section style="background:var(--paper); padding: 120px 40px 100px; position:relative; overflow:hidden; border-bottom: 1px solid var(--border);">
    <div style="position:absolute; inset:0; background: radial-gradient(circle at 80% 50%, rgba(141,198,63,0.1) 0%, transparent 60%); pointer-events:none;"></div>
    
    <div style="max-width:1200px; margin:0 auto; display:grid; grid-template-columns: 1.2fr 0.8fr; gap:60px; align-items:center; position:relative;">
        <div>
            <span class="sb-badge" style="background:rgba(141,198,63,0.1); color:var(--accent); margin-bottom:24px; display:inline-flex; border:1px solid rgba(141,198,63,0.2);">✨ Premium Bus Travel</span>
            <h1 class="syne" style="font-size:clamp(48px,5vw,72px); line-height:1; margin-bottom:24px; font-weight:800; color:#fff;">
                Modern Travel.<br><span style="color:var(--accent);">Simplified.</span>
            </h1>
            <p style="color:var(--muted); font-size:18px; max-width:500px; margin-bottom:48px; line-height:1.6;">Your premium gateway to bus reservations. Experience the most comfortable and secure way to travel across Bangladesh.</p>
            
            <form action="{{ route('frontend.reserve') }}" method="GET" class="booking-bar" style="margin-top: 32px;">
                <div class="booking-bar-item">
                    <span class="booking-bar-label">From</span>
                    <select name="from" class="booking-bar-input" style="color: #fff; background: transparent;" required>
                        <option value="" style="background: #1c201b; color: #fff;">Select City</option>
                        @foreach($locations->unique('location_from') as $loc)
                            <option value="{{ $loc->location_from }}" style="background: #1c201b; color: #fff;">{{ $loc->location_from }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="booking-bar-item">
                    <span class="booking-bar-label">To</span>
                    <select name="to" class="booking-bar-input" style="color: #fff; background: transparent;" required>
                        <option value="" style="background: #1c201b; color: #fff;">Select City</option>
                        @foreach($locations->unique('location_to') as $loc)
                            <option value="{{ $loc->location_to }}" style="background: #1c201b; color: #fff;">{{ $loc->location_to }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="booking-bar-item">
                    <span class="booking-bar-label">Date</span>
                    <input type="date" name="date" class="booking-bar-input" style="color-scheme: dark; color: #fff; background: transparent;" required>
                </div>
                <button type="submit" class="booking-bar-btn" style="width: auto; padding: 0 24px; border-radius: 100px; font-weight: 800; font-size: 13px; gap: 8px;">
                    FIND TRIPS <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                </button>
            </form>

            <div style="margin-top: 24px; display: flex; align-items: center; gap: 16px;">
                <span style="color: var(--muted); font-size: 13px;">Or explore:</span>
                <a href="{{ route('frontend.reserve') }}" style="color: var(--accent); text-decoration: none; font-size: 13px; font-weight: 700; border-bottom: 1px dashed var(--accent); padding-bottom: 2px;">View All Available Routes →</a>
            </div>
        </div>
        
        <div style="position:relative;">
            <img src="{{ asset('frontend/images/luxury_bus.png') }}" alt="Luxury Bus" style="width:130%; position:relative; z-index:2; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.6));">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:300px; height:300px; background:var(--accent); filter:blur(150px); opacity:0.1; z-index:1;"></div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section style="padding:100px 40px; border-bottom:1px solid var(--border);">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:60px;">
            <span class="sb-badge" style="margin-bottom:16px;">Services</span>
            <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Travel with Confidence</h2>
        </div>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:32px;">
            <div class="glass-card" style="padding:40px; text-align:center;">
                <div style="width:60px; height:60px; background:rgba(141,198,63,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-couch" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Luxury Seating</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Premium reclinable seats with maximum legroom for your journey.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center;">
                <div style="width:60px; height:60px; background:rgba(141,198,63,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-shield-halved" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Safe & Secure</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Verified operators and professional drivers ensuring your safety.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center;">
                <div style="width:60px; height:60px; background:rgba(141,198,63,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-bolt" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Instant Booking</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Get your e-ticket instantly via WhatsApp and Email after payment.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center;">
                <div style="width:60px; height:60px; background:rgba(141,198,63,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-headset" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">24/7 Support</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Round-the-clock assistance for all your travel and booking queries.</p>
            </div>
        </div>
    </div>
</section>

{{-- POPULAR ROUTES SECTION --}}
@if($trips->count() > 0)
<section style="padding:100px 40px; background: rgba(0,0,0,0.1);">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
            <div>
                <span class="sb-badge" style="margin-bottom:12px;">Top Routes</span>
                <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Popular Destinations</h2>
            </div>
            <a href="{{ route('frontend.reserve') }}" style="color:var(--accent); text-decoration:none; font-weight:600;">View All Trips →</a>
        </div>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(350px, 1fr)); gap:30px;">
            @foreach($trips as $trip)
            <div class="ticket-card">
                <div class="ticket-left">
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                        <span style="font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase;">Scheduled Trip</span>
                        <span style="font-size:12px; font-weight:800; color:var(--accent);">REG #{{ $trip->bus->bus_no }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:20px; margin-bottom:20px;">
                        <div>
                            <div class="syne" style="font-size:22px; font-weight:800; color:#fff;">{{ $trip->location_from }}</div>
                            <div style="font-size:12px; color:var(--muted);">Origin</div>
                        </div>
                        <i class="fa-solid fa-chevron-right" style="color:var(--border);"></i>
                        <div>
                            <div class="syne" style="font-size:22px; font-weight:800; color:#fff;">{{ $trip->location_to }}</div>
                            <div style="font-size:12px; color:var(--muted);">Destination</div>
                        </div>
                    </div>
                </div>
                <div class="ticket-right">
                    <div style="font-size:11px; color:var(--muted); margin-bottom:4px;">Fare from</div>
                    <div class="syne" style="font-size:24px; font-weight:900; color:#fff;">৳{{ $trip->fare }}</div>
                    <a href="{{ route('frontend.bookTrip', $trip->id) }}" style="margin-top:12px; color:var(--accent); text-decoration:none; font-size:12px; font-weight:700;">BOOK NOW</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BUS FLEET --}}
<section class="section-wrap" style="padding-bottom: 120px;">
    <div style="text-align:center; margin-bottom:60px;">
        <span class="sb-badge" style="margin-bottom:12px;">Our Fleet</span>
        <h2 class="syne" style="font-size:36px; font-weight:800;">Available Coaches</h2>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px,1fr)); gap:32px;">
        @forelse ($buses as $bus)
        <div class="sb-card" style="padding:0; overflow:hidden;">
            <div style="aspect-ratio:16/10; overflow:hidden; position:relative;">
                <img src="{{ url('/uploads/' . $bus->image) }}" alt="{{ $bus->bus_name }}"
                     style="width:100%; height:100%; object-fit:cover; transition:transform .6s;"
                     onmouseover="this.style.transform='scale(1.1)'"
                     onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute; top:20px; right:20px;">
                    <span style="background:{{ $bus->bus_type == 'ac' ? 'rgba(46,125,50,0.9)' : 'rgba(230,81,0,0.9)' }}; color:#fff; font-size:10px; font-weight:800; padding:6px 12px; border-radius:100px; text-transform:uppercase; backdrop-filter:blur(10px);">
                        {{ $bus->bus_type }}
                    </span>
                </div>
            </div>
            <div style="padding:24px;">
                <div style="margin-bottom:20px;">
                    <h3 class="syne" style="font-size:20px; font-weight:700; margin-bottom:4px;">{{ $bus->bus_name }}</h3>
                    <div style="color:var(--muted); font-size:13px; display:flex; gap:12px;">
                        <span><i class="fa fa-shuttle-van me-1"></i> {{ $bus->bus_no }}</span>
                        <span><i class="fa fa-couch me-1"></i> 40 Seats</span>
                    </div>
                </div>
                <a href="{{ route('frontend.reserve') }}" class="sb-btn" style="width:100%; display:block; text-align:center; text-decoration:none;">View Schedule</a>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding:100px 20px; color:var(--muted);">
            <i class="fas fa-bus" style="font-size:64px; margin-bottom:24px; display:block; opacity:.1;"></i>
            <p>Our coaches are currently on the road. Check back soon!</p>
        </div>
        @endforelse
    </div>
</section>

@endsection
