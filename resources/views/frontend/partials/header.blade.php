<nav class="sb-nav">
    <a class="sb-brand" href="{{ route('frontend.home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none !important; outline: none !important; border: none !important; box-shadow: none !important;">
        @if(setting('site_logo_image'))
            <img src="{{ asset(setting('site_logo_image')) }}" alt="{{ setting('site_name', 'SwiftBus') }}" style="max-height: 38px; max-width: 140px; object-fit: contain;">
        @else
            <div class="sb-logo-icon"><i class="fas fa-bus-simple"></i></div>
            <span style="color: #ffffff !important; text-decoration: none !important;">{{ setting('site_logo_prefix', 'Swift') }}</span><span class="dot" style="color: var(--neon) !important; text-decoration: none !important;">{{ setting('site_logo_suffix', 'Bus') }}</span>
        @endif
    </a>
    <ul class="sb-links">
        <li><a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('frontend.reserve') }}" class="{{ request()->routeIs('frontend.reserve') || request()->routeIs('frontend.showTrip') || request()->routeIs('frontend.bookTrip') ? 'active' : '' }}">Find Trips</a></li>
        <li><a href="{{ route('frontend.home') }}#contact">Contact</a></li>
        @if(auth()->user())
            <li><a href="{{ route('booking.details') }}" class="{{ request()->routeIs('booking.details') || request()->routeIs('view.info') || request()->routeIs('user.payment*') ? 'active' : '' }}">My Bookings</a></li>
            <li><span style="color: #94a3b8; font-size: 13.5px; font-weight: 600; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px;"><i class="fa fa-user" style="color: var(--neon);"></i> {{ auth()->user()->name }}</span></li>
            <li><a href="{{ route('user.logout') }}" class="btn-primary-nav">Logout</a></li>
        @else
            <li><a href="{{ route('user.login') }}" class="{{ request()->routeIs('user.login') ? 'active' : '' }}">Login</a></li>
            <li><a href="{{ route('user.registration') }}" class="btn-accent-nav {{ request()->routeIs('user.registration') ? 'active' : '' }}">Get Started</a></li>
        @endif
    </ul>
</nav>
