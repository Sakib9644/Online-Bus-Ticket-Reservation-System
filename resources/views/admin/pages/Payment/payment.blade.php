@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Financial Transactions</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Monitor payments and passenger transaction history</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h5>Payment History</h5>
    </div>
    <div style="padding: 24px;">
        <table class="admin-table" id="payment-table" style="width:100% !important;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Passenger</th>
                    <th>Method</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
<script>
$(function() {
    $('#payment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.payment') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'passenger', name: 'userRelation.name' },
            { data: 'method', name: 'payment_method' },
            { data: 'transaction_id', name: 'transaction_id' },
            { data: 'date', name: 'created_at' },
            { data: 'amount_display', name: 'amount' }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search ID, Passenger...",
            lengthMenu: "Show _MENU_",
        }
    });
});
</script>
@endsection