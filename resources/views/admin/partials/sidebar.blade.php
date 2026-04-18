<div class="nav-section">
    <div class="nav-section-label">Main Console</div>

    <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-chart-pie"></i> Dashboard
    </a>

    <a class="nav-item {{ request()->routeIs('passenger') ? 'active' : '' }}" href="{{ route('passenger') }}">
        <i class="fas fa-users"></i> Passengers
    </a>

    <a class="nav-item {{ request()->routeIs('admin.booking.list') ? 'active' : '' }}" href="{{ route('admin.booking.list') }}">
        <i class="fas fa-ticket"></i> Bookings
    </a>

    <a class="nav-item {{ request()->routeIs('admin.payment') ? 'active' : '' }}" href="{{ route('admin.payment') }}">
        <i class="fas fa-file-invoice-dollar"></i> Payments
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-label">Transit Operations</div>

    <a class="nav-item {{ request()->routeIs('admin.bus') ? 'active' : '' }}" href="{{ route('admin.bus') }}">
        <i class="fas fa-bus-simple"></i> Fleet Management
    </a>

    <a class="nav-item {{ request()->routeIs('admin.trip') ? 'active' : '' }}" href="{{ route('admin.trip') }}">
        <i class="fas fa-route"></i> Trip Schedules
    </a>

    <a class="nav-item {{ request()->routeIs('admin.seat') ? 'active' : '' }}" href="{{ route('admin.seat') }}">
        <i class="fas fa-chair"></i> Seat Inventory
    </a>

    <a class="nav-item {{ request()->routeIs('admin.driver') ? 'active' : '' }}" href="{{ route('admin.driver') }}">
        <i class="fas fa-id-card"></i> Driver List
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-label">Infrastructure</div>

    <a class="nav-item {{ request()->routeIs('admin.city') ? 'active' : '' }}" href="{{ route('admin.city') }}">
        <i class="fas fa-city"></i> Covered Cities
    </a>

    <a class="nav-item {{ request()->routeIs('admin.counter') ? 'active' : '' }}" href="{{ route('admin.counter') }}">
        <i class="fas fa-store"></i> Ticket Counters
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-label">System</div>
    <a class="nav-item" href="#"><i class="fas fa-cog"></i> Settings</a>
</div>
