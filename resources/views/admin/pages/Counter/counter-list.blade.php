@extends('admin.master')
@section('content')

<div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Ticket Counters</h1>
            <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage physical terminal assistance centers and contact points</p>
        </div>
        <a href="{{ route('admin.counter.create') }}" class="btn-primary-admin">
            <i class="fas fa-plus" style="font-size:12px;"></i> Register Counter
        </a>
    </div>

    @if(session()->has('success'))
        <div class="alert-success-admin">{{ session('success') }}</div>
    @endif

<div class="admin-card">
    <div class="admin-card-header">
        <h5>All Registered Hubs</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="counter-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Counter Identity</th>
                    <th>Designation/No</th>
                    <th>Contact Support</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#counter-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.counter') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'counter_name', name: 'counter_name' },
            { 
               data: 'counter_no', 
               name: 'counter_no',
               render: function(data) { return '<span style="font-family:monospace; background:#fff7ed; color:#9a3412; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">HUB-'+data+'</span>'; }
            },
            { data: 'counter_phone', name: 'counter_phone' },
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
</div>

@endsection