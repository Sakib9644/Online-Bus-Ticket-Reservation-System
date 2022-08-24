@extends('frontend.index')
@section('content')
    <br>
    <div id="gallery">
        <div class="container">
            <h2 class="">Book Trip</h2>
            <div class="card-header mb-3">Book Your trip here</div>
            <div class="card-body mt-4">
                <div class="search-form-wrapper">
                    <form method="get" action="{{ route('frontend.showTrip') }}">

                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>{{ $trip->location_from }} to {{ $trip->location_to }}</b>
                        </div>
                        <div class="panel-body">
                            <p>
                                <b>Fare:</b> {{ $trip->fare }}
                            </p>
                            <p>
                                <b>Bus:</b> {{ $trip->bus->bus_name }}
                            </p>
                            <p>
                                <b>Bus Number:</b> {{ $trip->bus->bus_no }}
                            </p>
                            <p>
                                <b>Bus Type:</b> {{ ucfirst($trip->bus->bus_type) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">

                    <div class="panel panel-default">
                        
                        <div class="panel-heading">
                            <b>Available Seats </b>
                        </div>
                        <div class="panel-body">
                            <livewire:trip-book :trip="$trip" /> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
