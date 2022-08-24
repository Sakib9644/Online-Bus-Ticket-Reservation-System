<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bus"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bus Ticket Reservation </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('passenger') }}">
            <i class="fas fa-users"></i>
            <span>User</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.booking.list') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Booking List</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->

    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-bus-alt"></i>
            <span>Buses</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Bus Components:</h6>
                <a class="collapse-item" href="{{ route('admin.location') }}">Location</a>
                <a class="collapse-item" href="{{ route('admin.bus') }}">Bus</a>

                {{-- <a class="collapse-item" href="{{ route('admin.counter') }}">Counter</a>
                <a class="collapse-item" href="{{ route('admin.driver') }}">Driver</a>
                <a class="collapse-item" href="{{ route('admin.busroute') }}">Bus route</a> --}}
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.seat') }}">
            <i class="fab fa-accessible-icon"></i>
            <span>Seat</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.trip') }}">
            <i class="fas fa-suitcase-rolling"></i>
            <span>Available Trip</span></a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
     <li class="nav-item active">
         <a class="nav-link" href="{{route('admin.payment')}}">
            <i class="fas fa-fw fa-list"></i>
            <span>Payment</span></a>
     </li>


    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settingColl" aria-expanded="true"
            aria-controls="settingColl">
            <i class="fas fa-cogs"></i>
            <span>Settings</span>
        </a>
        <div id="settingColl" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Settings Components:</h6>
                <a class="collapse-item" href="{{ route('admin.city') }}">City</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
