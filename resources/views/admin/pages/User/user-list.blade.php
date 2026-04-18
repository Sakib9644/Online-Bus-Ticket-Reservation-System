@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Registered Passengers</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage and monitor your customer base</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h5>All Registered Passengers</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="user-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Member Since</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    var table = $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('passenger') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
               data: 'name', 
               name: 'name',
               render: function(data) { return '<div style="font-weight:700; color:#1e293b;">'+data+'</div>'; }
            },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data) { return new Date(data).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search passengers...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>

@endsection
