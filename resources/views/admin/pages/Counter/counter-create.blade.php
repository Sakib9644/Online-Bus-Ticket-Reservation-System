@extends('admin.master')
@section('content')

<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; letter-spacing:-0.5px;">Register Ticket Counter</h1>
        <p style="color:var(--muted); font-size:14px; margin-top:4px;">Add a new physical ticket assistance center to the operational network</p>
    </div>

    @if ($errors->any())
        <div class="alert-danger-admin" style="background:#fee2e2; border:1px solid #fecaca; border-radius:10px; padding:16px; color:#b91c1c; margin-bottom:24px; font-size:14px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-form-card">
        <form action="{{route('admin.counter.store')}}" method="POST">
            @csrf
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                
                <div class="admin-form-group" style="grid-column: span 2;">
                    <label class="admin-label">Counter Location/Branch</label>
                    <select class="admin-input admin-select" required name="counter_name">
                        <option value="">Select Branch Location</option>
                        <optgroup label="Dhaka Hubs">
                            <option value="Fakirapool, Dhaka">Fakirapool, Dhaka</option>
                            <option value="Kamlapur, BRTC, Dhaka">Kamlapur, BRTC, Dhaka</option>
                            <option value="Arambagh, Eden Complex, Dhaka">Arambagh, Eden Complex, Dhaka</option>
                            <option value="Malibagh DIT Road, Dhaka">Malibagh DIT Road, Dhaka</option>
                            <option value="Jhonson Road, SAARC Law Chambar Dhaka">Jhonson Road, SAARC Law Chambar Dhaka</option>
                            <option value="Sydabad, Dhaka">Sydabad, Dhaka</option>
                            <option value="Middle Badda, Dhaka">Middle Badda, Dhaka</option>
                            <option value="Abdullahpur (Uttara) Sec# 9 Dhaka">Abdullahpur (Uttara) Sec# 9 Dhaka</option>
                            <option value="Mohakhali Rail Gate, Dhaka">Mohakhali Rail Gate, Dhaka</option>
                            <option value="Gabtoli, Dhaka">Gabtoli, Dhaka</option>
                        </optgroup>
                        <optgroup label="Chittagong Hubs">
                            <option value="Dampara CMP, Chittagong">Dampara CMP, Chittagong</option>
                            <option value="AK Khan Gate, Chittagong">AK Khan Gate, Chittagong</option>
                            <option value="Shetakunda, Chittagong">Shetakunda, Chittagong</option>
                        </optgroup>
                        <optgroup label="Khulna & West Hubs">
                            <option value="Monihar, Jessore">Monihar, Jessore</option>
                            <option value="Benapole Bazar">Benapole Bazar</option>
                            <option value="Shibbari, Khulna">Shibbari, Khulna</option>
                            <option value="Shatkhira Kaliganj Road">Shatkhira Kaliganj Road</option>
                        </optgroup>
                        <optgroup label="Other Regions">
                            <option value="Narayngonj">Narayngonj</option>
                            <option value="Manikgonj">Manikgonj</option>
                            <option value="Kolatoli, Cox’s Bazar">Kolatoli, Cox’s Bazar</option>
                            <option value="Jhautola, Cox’s Bazar">Jhautola, Cox’s Bazar</option>
                        </optgroup>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Internal Counter No.</label>
                    <input required name="counter_no" type="number" placeholder="e.g. 101" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Counter Contact Line</label>
                    <input required name="counter_phone" type="text" placeholder="e.g. 01XXXXXXXXX" class="admin-input">
                </div>

            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px; border-top:1px solid var(--border); padding-top:32px;">
                <a href="{{ route('admin.counter') }}" class="btn-outline-admin">Discard</a>
                <button type="submit" class="btn-primary-admin" style="min-width:145px; justify-content:center;">Register Counter</button>
            </div>
        </form>
    </div>
</div>

@endsection