@extends('frontend.index')
@section('content')

{{-- HERO SECTION --}}
<section style="background:var(--paper); padding: 120px 40px 100px; position:relative; overflow:hidden; border-bottom: 1px solid var(--border);">
    <div style="position:absolute; inset:0; background: radial-gradient(circle at 80% 50%, rgba(162, 224, 67, 0.05) 0%, transparent 60%); pointer-events:none;"></div>
    
    <div style="max-width:1200px; margin:0 auto; display:grid; grid-template-columns: 1.2fr 0.8fr; gap:60px; align-items:center; position:relative;">
        <div>
            <span class="sb-badge" style="background:rgba(162,224,67,0.1); color:var(--accent); margin-bottom:24px; display:inline-flex; border:1px solid rgba(162,224,67,0.2);">✨ Premium Bus Travel</span>
            <h1 class="syne" style="font-size:clamp(48px,5vw,72px); line-height:1; margin-bottom:24px; font-weight:800; color:#fff;">
                Modern Travel.<br><span style="color:var(--accent);">Simplified.</span>
            </h1>
            <p style="color:var(--muted); font-size:18px; max-width:500px; margin-bottom:48px; line-height:1.6;">Your premium gateway to bus reservations. Experience the most comfortable and secure way to travel across Bangladesh.</p>
            
            <div style="display:flex; gap:20px; align-items:center; margin-top:40px;">
                <a href="{{ route('frontend.reserve') }}" class="sb-btn sb-btn-accent" style="padding:18px 42px; font-size:16px; text-decoration:none; display:inline-flex; align-items:center; gap:12px; background:var(--accent); border-color:var(--accent); color:#0d1a09;">
                    Find Trips Now <i class="fa fa-arrow-right"></i>
                </a>
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
            <div class="glass-card" style="padding:40px; text-align:center; background: rgba(28, 35, 27, 0.4); border-color: var(--border);">
                <div style="width:60px; height:60px; background:rgba(162, 224, 67,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-couch" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Luxury Seating</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Premium reclinable seats with maximum legroom for your journey.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center; background: rgba(28, 35, 27, 0.4); border-color: var(--border);">
                <div style="width:60px; height:60px; background:rgba(162, 224, 67,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-shield-halved" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Safe & Secure</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Verified operators and professional drivers ensuring your safety.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center; background: rgba(28, 35, 27, 0.4); border-color: var(--border);">
                <div style="width:60px; height:60px; background:rgba(162, 224, 67,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                    <i class="fa-solid fa-bolt" style="color:var(--accent); font-size:24px;"></i>
                </div>
                <h4 class="syne" style="color:#fff; margin-bottom:12px; font-weight:700;">Instant Booking</h4>
                <p style="color:var(--muted); font-size:14px; line-height:1.6;">Get your e-ticket instantly via WhatsApp and Email after payment.</p>
            </div>
            
            <div class="glass-card" style="padding:40px; text-align:center; background: rgba(28, 35, 27, 0.4); border-color: var(--border);">
                <div style="width:60px; height:60px; background:rgba(162, 224, 67,0.1); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
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
<section style="padding:100px 40px; background: rgba(0,0,0,0.15);">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
            <div>
                <span class="sb-badge" style="margin-bottom:12px;">Top Routes</span>
                <h2 class="syne" style="font-size:36px; font-weight:800; color:#fff;">Trending Trips</h2>
            </div>
            <a href="{{ route('frontend.reserve') }}" style="color:var(--accent); text-decoration:none; font-weight:600;">View All Trips →</a>
        </div>
        
        <div style="position: relative; padding: 0 50px;">
            <div class="swiper trips-swiper">
                <div class="swiper-wrapper" style="padding: 20px 0 60px;">
                    @foreach($trips as $trip)
                    <div class="swiper-slide" style="height: auto; display: flex;">
                        <div class="ticket-card">
                            <div class="ticket-header">
                                <div class="ticket-tag-green">AC COACH</div>
                                <div style="text-align: right;">
                                    <div class="trip-time">{{ $trip->time }}</div>
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">{{ \Carbon\Carbon::parse($trip->date)->format('M d, Y') }}</div>
                                </div>
                            </div>

                            <div class="ticket-content">
                                <div class="route-visual">
                                    <div class="route-point">
                                        <div class="city-name">{{ $trip->location_from }}</div>
                                        <div class="city-label">Origin</div>
                                    </div>
                                    <div class="route-point destination" style="margin-top: 20px;">
                                        <div class="city-name">{{ $trip->location_to }}</div>
                                        <div class="city-label">Destination</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ticket-footer">
                                <div class="fare-badge">
                                    <div class="fare-amount">৳{{ $trip->fare }}</div>
                                    <div class="fare-label">Fare / Seat</div>
                                </div>
                                <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="premium-btn">
                                    BOOK <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-prev" style="left: -40px;"></div>
            <div class="swiper-button-next" style="right: -40px;"></div>
        </div>
    </div>
</section>
@endif

@endsection
