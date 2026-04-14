<nav class="sb-nav">
    <a class="sb-brand" href="{{ route('frontend.home') }}">
        <div class="sb-logo-icon"><i class="fas fa-bus-simple"></i></div>
        Swift<span class="dot">Bus</span>
    </a>
    <ul class="sb-links">
        <li><a href="{{ route('frontend.home') }}">Home</a></li>
        <li><a href="{{ route('frontend.reserve') }}">Find Trips</a></li>
        <li><a href="#contact">Contact</a></li>
        @if(auth()->user())
            <li><a href="#">👤 {{ auth()->user()->name }}</a></li>
            <li><a href="{{ route('user.logout') }}" class="btn-primary-nav">Logout</a></li>
        @else
            <li><a href="{{ route('user.login') }}">Login</a></li>
            <li><a href="{{ route('user.registration') }}" class="btn-accent-nav">Get Started</a></li>
        @endif
    </ul>
</nav>
