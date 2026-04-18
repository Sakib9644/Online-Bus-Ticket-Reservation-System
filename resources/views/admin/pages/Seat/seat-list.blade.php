@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Seat Inventory</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage seat configurations for your fleet</p>
    </div>
    <a href="{{ route('admin.seat.create') }}" class="btn-primary-admin">
        <i class="fa fa-plus"></i> Add New Seat
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
        <h5>Configured Seats</h5>
        <span style="font-size:13px; font-weight:600; color:var(--muted);">{{ $seats->total() }} total seats found</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Seat Identifier</th>
                    <th>Bus Allocation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($seats as $key => $seat)
                <tr>
                    <td>{{ ($seats->currentPage()-1) * $seats->perPage() + $key + 1 }}</td>
                    <td>
                        <div style="font-weight:700; color:var(--accent); font-size:15px; font-family:monospace;">{{ $seat->seat_no ?: $seat->name }}</div>
                        <div style="font-size:11px; color:var(--muted); margin-top:2px;">ID: #{{ $seat->id }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600; color:#1e293b;">{{ $seat->bus->bus_name ?? 'N/A' }}</div>
                        <div style="font-size:12px; color:var(--muted); margin-top:2px;">{{ $seat->bus->bus_no ?? '' }}</div>
                    </td>
                    <td>
                        <span class="badge-success">Active</span>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{route('admin.seat.edit',$seat->id)}}" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#8b5cf6;"><i class="fas fa-edit"></i></a>
                            <a onclick="return confirm('Remove this seat from inventory?')" href="{{route('admin.seat.delete',$seat->id)}}" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:60px; color:var(--muted);">No seats configured. Map seats to your buses to enable bookings.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:24px;">
    {{ $seats->links() }}
</div>

@endsection