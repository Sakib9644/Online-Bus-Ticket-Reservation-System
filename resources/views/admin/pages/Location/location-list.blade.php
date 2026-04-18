@extends('admin.master')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Terminal Locations</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Manage specific boarding and dropping terminals</p>
    </div>
    <a href="{{route('admin.location.create')}}" class="btn-primary-admin">
        <i class="fa fa-plus"></i> Add New Terminal
    </a>
</div>

@if(session()->has('msg') || session()->has('success'))
    <div class="alert-success-admin">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i>
        {{ session()->get('msg') ?? session()->get('success') }}
    </div>
@endif 

<div class="admin-card">
    <div class="admin-card-header">
        <h5>Configured Terminals</h5>
        <span style="font-size:13px; font-weight:600; color:var(--muted);">{{ $locations->total() }} recorded paths</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Terminal From</th>
                    <th>Terminal To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $key => $location)
                <tr>
                    <td>{{ ($locations->currentPage()-1) * $locations->perPage() + $key + 1 }}</td>
                    <td>
                        <div style="font-weight:700; color:#1e293b;">{{ $location->location_from }}</div>
                    </td>
                    <td>
                        <div style="font-weight:700; color:#1e293b;">{{ $location->location_to }}</div>
                    </td>
                    <td>
                        <span class="badge-info">Operating</span>
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{route('admin.location.edit',$location->id)}}" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#8b5cf6;"><i class="fas fa-edit"></i></a>
                            <a onclick="return confirm('Remove this terminal configuration?')" href="{{route('admin.location.delete',$location->id)}}" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </td>                 
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:60px; color:var(--muted);">No terminals configured. Define routes to start scheduling trips.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:24px;">
    {{ $locations->links() }}
</div>

@endsection