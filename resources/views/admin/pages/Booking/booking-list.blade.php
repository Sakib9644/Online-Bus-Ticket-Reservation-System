@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">User-Wise Bookings</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage transactions and seat reservations</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h5>All Reservations</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="booking-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Course Number</th>
                    <th>Passenger</th>
                    <th>Bus & Route</th>
                    <th>Seats</th>
                    <th>Total Amnt</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#booking-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.booking.list') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'pnr', name: 'ticket_no' },
            { data: 'passenger', name: 'user.name' },
            { data: 'bus_route', name: 'seat.bus.bus_name' },
            { data: 'seats_display', name: 'seats_display', orderable: false, searchable: false },
            { data: 'amount_display', name: 'total_amount', searchable: false },
            { data: 'status_display', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search PNR, Passenger...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>

@endsection
