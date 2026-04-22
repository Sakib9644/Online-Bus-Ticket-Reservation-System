@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Covered Cities</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage the major hubs and cities in your network</p>
    </div>
    <div style="display:flex; gap:12px;">
        <button onclick="generateAll()" class="btn" id="gen-all-btn" style="background:#ecfdf5; color:#059669; border:1px solid #d1fae5; padding:10px 20px; border-radius:12px; font-weight:600; cursor:pointer;">
            <i class="fas fa-magic"></i> <span id="gen-all-text">Generate All Missing</span>
        </button>
        <a href="{{ route('admin.city.create') }}" class="btn-primary-admin">
            <i class="fa fa-plus"></i> Add New City
        </a>
    </div>
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
                    <th>Image</th>
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
    window.cityTable = $('#city-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.city') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'image', name: 'image', orderable: false, searchable: false },
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

function generateImage(id) {
    const btn = $(`#gen-btn-${id}`);
    const originalHtml = btn.html();
    
    btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
    
    $.ajax({
        url: `/admin/city/generate-image/${id}`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                $(`#city-img-${id}`).attr('src', response.image_url + '?t=' + new Date().getTime());
                btn.html('<i class="fas fa-check"></i>').css('color', '#059669');
                setTimeout(() => {
                    btn.html(originalHtml).prop('disabled', false).css('color', '');
                }, 2000);
            }
        },
        error: function() {
            btn.html('<i class="fas fa-times"></i>').css('color', '#dc2626');
            setTimeout(() => {
                btn.html(originalHtml).prop('disabled', false).css('color', '');
            }, 2000);
        }
    });
}

async function generateAll() {
    const btn = $('#gen-all-btn');
    const text = $('#gen-all-text');
    const originalText = text.text();
    
    btn.prop('disabled', true);
    text.text('Fetching list...');
    
    try {
        const response = await $.get('{{ route('admin.city.generate-all') }}');
        const cities = response;
        
        if (cities.length === 0) {
            text.text('No missing images!');
            setTimeout(() => {
                btn.prop('disabled', false);
                text.text(originalText);
            }, 2000);
            return;
        }
        
        let processed = 0;
        for (const city of cities) {
            text.text(`Generating ${++processed}/${cities.length}: ${city.name}...`);
            await $.get(`/admin/city/generate-image/${city.id}`);
            window.cityTable.ajax.reload(null, false);
        }
        
        text.text('All Completed!');
        setTimeout(() => {
            btn.prop('disabled', false);
            text.text(originalText);
        }, 3000);
        
    } catch (e) {
        text.text('Error occurred!');
        setTimeout(() => {
            btn.prop('disabled', false);
            text.text(originalText);
        }, 2000);
    }
}
</script>

@endsection