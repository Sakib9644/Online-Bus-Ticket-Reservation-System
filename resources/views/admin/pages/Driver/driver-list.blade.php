@extends('admin.master')
@section('content')

<div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Driver Registry</h1>
            <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage certified operators and vehicle assignments</p>
        </div>
        <a href="{{route('admin.driver.create')}}" class="btn-primary-admin">
            <i class="fas fa-plus" style="font-size:12px;"></i> Add New Driver
        </a>
    </div>

    @if(session()->has('success'))
        <div class="alert-success-admin">{{ session('success') }}</div>
    @endif

<div class="admin-card">
    <div class="admin-card-header">
        <h5>All Registered Operators</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="driver-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Operator Details</th>
                    <th>Assigned Vehicle</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#driver-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.driver') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'driver_info', name: 'driver_name' },
            { data: 'vehicle', name: 'coach_no' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search operators...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>
</div>

@endsection
