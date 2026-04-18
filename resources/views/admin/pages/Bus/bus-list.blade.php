@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Fleet Management</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage your bus fleet and vehicle details</p>
    </div>
    <a href="{{ route('admin.bus.create') }}" class="btn-primary-admin">
        <i class="fa fa-plus"></i> Add New Bus
    </a>
</div>

@if(session()->has('msg') || session()->has('success') || session()->has('message'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
        {{ session()->get('msg') ?? session()->get('success') ?? session()->get('message') }}
    </div>
@endif 

<div class="admin-card">
    <div class="admin-card-header">
        <h5>Active Fleet</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="bus-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Bus Info</th>
                    <th>Bus Type</th>
                    <th>Course Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#bus-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.bus') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'bus_info', name: 'bus_info' },
            { data: 'type', name: 'type' },
            { data: 'coach_no', name: 'coach_no', className: 'course-code' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search fleet...",
            lengthMenu: "Show _MENU_",
        },
        drawCallback: function() {
            $('.course-code').css({
                'font-weight': '600',
                'font-family': 'monospace',
                'letter-spacing': '1px',
                'color': '#475569'
            });
        }
    });
});
</script>

@endsection