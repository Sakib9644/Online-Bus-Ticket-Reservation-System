@extends('frontend.index')
@section('content')
    <div style="background: linear-gradient(135deg, #141c12 0%, #1d2818 55%, #11180f 100%); padding: 80px 40px; border-bottom: 1px solid rgba(162, 224, 67, 0.22); box-shadow: inset 0 -1px 0 rgba(255,255,255,0.04);">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="sb-badge" style="margin-bottom: 12px; background: rgba(141,198,63,0.1); color: var(--accent);">Ready to go?</span>
                <h1 class="syne" style="font-size: 48px; font-weight: 800; color: #fff; line-height: 1;">Find Your <span style="color: var(--accent);">Ride</span></h1>
                <p style="color: var(--muted); margin-top: 12px; font-size: 16px;">Browse schedules and secure your seats in seconds.</p>
            </div>
            <div style="display: flex; gap: 40px;">
                <div style="text-align: center;">
                    <i class="fa fa-shuttle-van" style="font-size: 24px; color: var(--accent); margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Active Trips</span>
                </div>
                <div style="text-align: center;">
                    <i class="fa-solid fa-couch" style="font-size: 24px; color: var(--accent); margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Best Seats</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section-wrap" style="padding-top: 60px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <livewire:trip />
        </div>
    </div>
@endsection
