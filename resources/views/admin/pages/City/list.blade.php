@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Covered Cities</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage the major hubs and cities in your network</p>
    </div>
    <a href="{{ route('admin.city.create') }}" class="btn-primary-admin">
        <i class="fa fa-plus"></i> Add New City
    </a>
</div>

@if (session()->has('msg') || session()->has('success') || session()->has('message'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
        {{ session()->get('msg') ?? session()->get('success') ?? session()->get('message') }}
    </div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <h5>Registered Hubs</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="city-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>City/Hub Name</th>
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
    $('#city-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.city') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { 
               data: null, 
               render: function() { return '<span class="badge-success">Operational</span>'; },
               orderable: false, searchable: false 
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search hubs...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>

@endsection