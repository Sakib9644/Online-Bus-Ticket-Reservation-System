@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Trip Schedules</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Define and monitor active bus routes and timings</p>
    </div>
    <a href="{{route('admin.trip.create')}}" class="btn-primary-admin">
        <i class="fa fa-plus"></i> Create New Trip
    </a>
</div>

@if(session()->has('message') || session()->has('msg') || session()->has('success'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
        {{ session()->get('message') ?? session()->get('msg') ?? session()->get('success') }}
    </div>
@endif 

<div class="admin-card">
    <div class="admin-card-header">
        <h5>Scheduled Trips</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="trip-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Route Map</th>
                    <th>Vehicle (Course #)</th>
                    <th>Schedule</th>
                    <th>Fare (BDT)</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#trip-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.trip') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'route_map', name: 'route_map' },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'schedule', name: 'schedule' },
            { data: 'fare_display', name: 'fare_display' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search trips...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>
        </table>
    </div>
</div>

@endsection