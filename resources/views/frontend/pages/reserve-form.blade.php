@extends('frontend.index')
@section('content')
    <div style="background: #000000; padding: 70px 40px; border-bottom: 1.5px solid rgba(162, 224, 67, 0.25); box-shadow: 0 15px 40px rgba(0,0,0,0.9);">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <span class="sb-badge" style="margin-bottom: 12px;">Ready to go?</span>
                <h1 class="syne" style="font-size: 48px; font-weight: 800; color: #fff; line-height: 1;">Find Your <span style="color: var(--neon); text-shadow: 0 0 20px rgba(162, 224, 67, 0.6);">Ride</span></h1>
                <p style="color: var(--muted); margin-top: 12px; font-size: 16px;">Browse schedules and secure your seats in seconds.</p>
            </div>
            <div style="display: flex; gap: 40px;">
                <div style="text-align: center;">
                    <i class="fa fa-shuttle-van" style="font-size: 24px; color: var(--neon); text-shadow: 0 0 15px rgba(162, 224, 67, 0.5); margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Active Trips</span>
                </div>
                <div style="text-align: center;">
                    <i class="fa-solid fa-couch" style="font-size: 24px; color: var(--neon); text-shadow: 0 0 15px rgba(162, 224, 67, 0.5); margin-bottom: 8px; display: block;"></i>
                    <span style="font-size: 12px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Best Seats</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section-wrap" style="padding-top: 50px; background: #000000;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <livewire:trip />
        </div>
    </div>
@endsection
