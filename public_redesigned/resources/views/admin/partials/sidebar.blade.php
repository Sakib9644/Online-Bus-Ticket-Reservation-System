<div class="nav-section">
    <div class="nav-section-label">Main</div>

    <a class="nav-item active" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-gauge-high"></i> Dashboard
    </a>

    <a class="nav-item" href="{{ route('passenger') }}">
        <i class="fas fa-users"></i> Passengers
    </a>

    <a class="nav-item" href="{{ route('admin.booking.list') }}">
        <i class="fas fa-ticket"></i> Bookings
    </a>

    <a class="nav-item" href="{{ route('admin.payment') }}">
        <i class="fas fa-credit-card"></i> Payments
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-label">Operations</div>

    <div class="nav-group-btn" data-toggle="collapse" data-target="#busMenu">
        <div class="nav-group-left">
            <i class="fas fa-bus"></i>
            <span style="font-size:14px;">Buses</span>
        </div>
        <i class="fas fa-chevron-down" style="font-size:10px;"></i>
    </div>
    <div id="busMenu" class="collapse nav-sub">
        <a class="nav-item" href="{{ route('admin.location') }}"><i class="fas fa-map-pin"></i> Locations</a>
        <a class="nav-item" href="{{ route('admin.bus') }}"><i class="fas fa-bus-simple"></i> Bus List</a>
    </div>

    <a class="nav-item" href="{{ route('admin.seat') }}">
        <i class="fas fa-chair"></i> Seats
    </a>

    <a class="nav-item" href="{{ route('admin.trip') }}">
        <i class="fas fa-route"></i> Trips
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-label">Settings</div>

    <div class="nav-group-btn" data-toggle="collapse" data-target="#settingsMenu">
        <div class="nav-group-left">
            <i class="fas fa-cog"></i>
            <span style="font-size:14px;">Settings</span>
        </div>
        <i class="fas fa-chevron-down" style="font-size:10px;"></i>
    </div>
    <div id="settingsMenu" class="collapse nav-sub">
        <a class="nav-item" href="{{ route('admin.city') }}"><i class="fas fa-city"></i> Cities</a>
    </div>
</div>
