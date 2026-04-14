@extends('frontend.index')
@section('content')
    <br><br>
    <div id="gallery">
        <div class="container">
            <div class="card-header mb-3">Search Trip</div>
            <div class="card-body mt-4">
                <livewire:trip />
            </div>
        </div>
    </div>
@endsection
