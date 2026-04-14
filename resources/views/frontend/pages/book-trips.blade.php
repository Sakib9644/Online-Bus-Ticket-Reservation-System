@extends('frontend.index')
@section('content')

<div class="section-wrap" style="padding-top:40px; background: var(--paper);">
    <livewire:trip-book :trip="$trip" />
</div>

@endsection
