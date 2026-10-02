@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px; margin:0;">Seat Inventory</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px; margin-bottom:0;">Bus-wise seat capacity, layouts, and fleet allocation</p>
    </div>
    <div style="display:flex; gap:12px;">
        <a href="{{ route('admin.seat.create') }}" class="btn-primary-admin">
            <i class="fa fa-plus"></i> Configure Seats
        </a>
    </div>
</div>

@if (session()->has('msg') || session()->has('success') || session()->has('message'))
    <div class="alert-success-admin" style="margin-bottom:24px;">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
        {{ session()->get('msg') ?? session()->get('success') ?? session()->get('message') }}
    </div>
@endif

<div class="admin-card">
    <div class="admin-card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h5 style="margin:0; font-weight:700; color:#0f172a;">Fleet Seat Status</h5>
            <span style="font-size:12px; color:var(--muted);">All buses with their configured seating allocations</span>
        </div>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="seat-inventory-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Bus Info</th>
                    <th>Bus Type</th>
                    <th>Configured Seats</th>
                    <th>Seat Preview</th>
                    <th style="width: 170px;">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal: View Bus Seats Detail -->
<div class="modal fade" id="busSeatsModal" tabindex="-1" aria-labelledby="busSeatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
            <div class="modal-header" style="background:#0f172a; color:#fff; padding:18px 24px; border-bottom:1px solid #1e293b;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:40px; height:40px; border-radius:10px; background:rgba(59,130,246,0.15); color:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:18px;">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title" id="modalBusName" style="font-weight:700; font-size:17px; margin:0; color:#fff;">Bus Seats</h5>
                        <p id="modalBusSub" style="margin:0; font-size:12px; color:#94a3b8;">Coach No & Type</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter:invert(1); opacity:0.8;"></button>
            </div>
            
            <div class="modal-body" style="padding:24px; background:#f8fafc; max-height:65vh; overflow-y:auto;">
                <!-- Loading State -->
                <div id="modalLoading" style="text-align:center; padding:40px 0;">
                    <div class="spinner-border text-primary" role="status" style="width:2.5rem; height:2.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div style="margin-top:12px; font-weight:600; color:#64748b; font-size:14px;">Loading seat inventory...</div>
                </div>

                <!-- Seat Content -->
                <div id="modalContent" style="display:none;">
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; margin-bottom:20px;">
                        <div>
                            <span style="font-size:12px; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Total Allocated</span>
                            <div id="modalTotalSeats" style="font-size:20px; font-weight:800; color:#0f172a;">0 Seats</div>
                        </div>
                        <div id="modalActionLink">
                            <!-- Injected button -->
                        </div>
                    </div>

                    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                            <span style="font-size:13px; font-weight:700; color:#334155;"><i class="fas fa-th-large" style="color:#3b82f6; margin-right:6px;"></i> Seat Grid</span>
                            <span style="font-size:11px; color:#94a3b8;">Click <i class="fas fa-times" style="color:#ef4444;"></i> to delete an individual seat</span>
                        </div>
                        
                        <div id="modalSeatsGrid" style="display:flex; flex-wrap:wrap; gap:10px;">
                            <!-- Injected Seat Chips -->
                        </div>
                        
                        <div id="modalNoSeats" style="display:none; text-align:center; padding:30px 10px; color:#64748b;">
                            <i class="fas fa-couch" style="font-size:32px; color:#cbd5e1; margin-bottom:10px; display:block;"></i>
                            <div style="font-weight:600;">No seats currently configured for this bus.</div>
                            <p style="font-size:12px; margin-top:4px;">Use the configure button to bulk generate seats.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding:16px 24px; background:#fff; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between;">
                <button type="button" class="btn-outline-admin" data-bs-dismiss="modal">Close</button>
                <div id="modalFooterRight">
                    <!-- Dynamic Configure button -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    var table = $('#seat-inventory-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.seat') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'bus_info', name: 'bus_name' },
            { data: 'bus_type', name: 'bus_type' },
            { data: 'seat_count', name: 'seats_count', searchable: false },
            { data: 'seat_preview', name: 'seat_preview', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search buses...",
            lengthMenu: "Show _MENU_ buses",
            processing: '<div style="padding:10px; font-weight:600; color:#3b82f6;"><i class="fas fa-spinner fa-spin"></i> Loading inventory...</div>'
        }
    });

    // Handle View Seats modal click
    $(document).on('click', '.view-bus-seats-btn', function() {
        var busId = $(this).data('bus-id');
        var busName = $(this).data('bus-name');
        var coach = $(this).data('coach');

        $('#modalBusName').text(busName);
        $('#modalBusSub').text('Coach: ' + (coach || 'N/A'));
        $('#modalLoading').show();
        $('#modalContent').hide();
        $('#busSeatsModal').modal('show');

        loadBusSeats(busId);
    });

    function loadBusSeats(busId) {
        $.ajax({
            url: '{{ url('/admin/seat/bus-seats') }}/' + busId,
            type: 'GET',
            success: function(res) {
                $('#modalLoading').hide();
                $('#modalContent').show();

                $('#modalBusName').text(res.bus_name);
                $('#modalBusSub').html('Coach: <span style="font-family:monospace; font-weight:700;">' + (res.coach_no || 'N/A') + '</span> &bull; ' + res.bus_type);
                $('#modalTotalSeats').text(res.total_seats + ' Seats');

                var addUrl = '{{ route('admin.seat.create') }}?bus_id=' + res.bus_id;
                $('#modalActionLink').html('<a href="' + addUrl + '" class="btn-primary-admin" style="font-size:12px; padding:6px 14px;"><i class="fas fa-plus"></i> Add / Generate Seats</a>');
                $('#modalFooterRight').html('<a href="' + addUrl + '" class="btn-primary-admin"><i class="fas fa-plus"></i> Configure Seats</a>');

                var grid = $('#modalSeatsGrid');
                grid.empty();

                if (res.seats && res.seats.length > 0) {
                    $('#modalNoSeats').hide();
                    grid.show();
                    $.each(res.seats, function(idx, seat) {
                        var chip = $('<div style="display:inline-flex; align-items:center; gap:8px; background:#f1f5f9; border:1px solid #cbd5e1; border-radius:8px; padding:6px 12px; font-weight:700; color:#1e293b; font-size:13px; font-family:monospace; box-shadow:0 1px 2px rgba(0,0,0,0.05);">' +
                            '<span><i class="fas fa-chair" style="color:#64748b; font-size:11px; margin-right:4px;"></i>' + seat.name + '</span>' +
                            '<button type="button" class="delete-single-seat-btn" data-seat-id="' + seat.id + '" data-bus-id="' + res.bus_id + '" title="Remove Seat" style="background:none; border:none; color:#ef4444; cursor:pointer; padding:0; display:flex; align-items:center; font-size:12px; opacity:0.75; transition:opacity 0.2s;">' +
                            '<i class="fas fa-times-circle"></i>' +
                            '</button>' +
                        '</div>');
                        grid.append(chip);
                    });
                } else {
                    grid.hide();
                    $('#modalNoSeats').show();
                }
            },
            error: function() {
                $('#modalLoading').html('<div style="color:#ef4444; font-weight:600;"><i class="fas fa-exclamation-triangle"></i> Failed to load seats. Please try again.</div>');
            }
        });
    }

    // Single seat deletion via AJAX
    $(document).on('click', '.delete-single-seat-btn', function() {
        if (!confirm('Are you sure you want to remove this seat?')) {
            return;
        }

        var btn = $(this);
        var seatId = btn.data('seat-id');
        var busId = btn.data('bus-id');

        $.ajax({
            url: '{{ url('/admin/seat/delete') }}/' + seatId,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function() {
                btn.parent().fadeOut(200, function() {
                    $(this).remove();
                    // Reload bus seats modal count and reload datatable
                    loadBusSeats(busId);
                    table.ajax.reload(null, false);
                });
            },
            error: function() {
                alert('Could not delete seat. Please try again.');
            }
        });
    });
});
</script>

@endsection