@extends('frontend.index')
@section('content')

<div style="background:var(--paper); padding:80px 40px 60px; border-bottom:1px solid var(--border);">
    <div style="max-width:1200px; margin:0 auto;">
        <span class="sb-badge" style="background:rgba(141,198,63,0.1); color:var(--accent); margin-bottom:16px;">Quick Search</span>
        <h1 class="syne" style="color:#fff; font-size:48px; font-weight:800; line-height:1; margin-bottom:12px;">Refine Your <span style="color:var(--accent);">Journey</span></h1>
        <p style="color:var(--muted); font-size:16px;">Adjust your filters to find the perfect trip schedules.</p>
    </div>
</div>

<div class="section-wrap" style="padding-top: 60px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <livewire:trip />
    </div>
</div>

@endsection
