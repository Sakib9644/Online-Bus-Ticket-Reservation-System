@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <h1 class="syne" style="font-size:22px; font-weight:800;">Booking List</h1>
        <p style="color:var(--muted); font-size:13px; margin-top:4px;">All passenger bookings</p>
    </div>
</div>

@if (session()->has('message'))
    <div class="alert-success-admin"><i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session()->get('message') }}</div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <h5>All Bookings</h5>
        <span style="font-size:13px; color:var(--muted);">{{ $bookings->count() ?? 0 }} total</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Passenger</th>
                    <th>Route</th>
                    <th>Seat</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $booking)
                <tr>
                    <td style="color:var(--muted); font-size:13px;">{{ $i+1 }}</td>
                    <td style="font-weight:500;">{{ $booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->trip->location_from ?? '' }} → {{ $booking->trip->location_to ?? '' }}</td>
                    <td>{{ $booking->seat->seat_no ?? 'N/A' }}</td>
                    <td style="color:var(--muted); font-size:13px;">{{ $booking->created_at->format('d M Y') }}</td>
                    <td><span class="badge-success">Confirmed</span></td>
                    <td>
                        <a href="#" class="btn-outline-admin" style="font-size:12px; padding:6px 12px;">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding:48px; color:var(--muted);">No bookings found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
