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
        <li><a href="{{ route('frontend.home') }}">Home</a></li>
        <li><a href="{{ route('frontend.reserve') }}">Find Trips</a></li>
        <li><a href="#contact">Contact</a></li>
        @if(auth()->user())
            <li><a href="{{ route('booking.details') }}">My Bookings</a></li>
            <li><a href="#">👤 {{ auth()->user()->name }}</a></li>
            <li><a href="{{ route('user.logout') }}" class="btn-primary-nav">Logout</a></li>
        @else
            <li><a href="{{ route('user.login') }}">Login</a></li>
            <li><a href="{{ route('user.registration') }}" class="btn-accent-nav">Get Started</a></li>
        @endif
    </ul>
</nav>
