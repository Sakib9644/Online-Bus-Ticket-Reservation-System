@extends('frontend.index')
@section('content')
    <div class="page-hero" style="padding: 40px 20px; background: transparent;">
        <h1 class="syne" style="font-size: 32px; font-weight: 800; color: #fff;">Search Trip</h1>
        <p style="color: var(--muted);">Find the perfect bus for your journey</p>
    </div>
    
    <div class="section-wrap" style="padding-top: 0;">
        <livewire:trip />
    </div>
@endsection
