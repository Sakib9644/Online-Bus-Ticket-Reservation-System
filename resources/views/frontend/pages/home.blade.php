@extends('frontend.index')
@section( 'content')
<br>
<br>
<div id="gallery">

                    <div class="card-header" color="red"><marquee behavior="t" direction="">Available Bus ({{count($buses)}})</marquee>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            @forelse ($buses as $bus )
                                <div class="col-md-4 mt-2 text-center" style="border: 1px solid #ccc;">
                                    <img src="{{ url('/uploads/' . $bus->image) }}" height="120">
                                    <p><h2>Bus Name:{{  $bus->bus_name }}</p></h2>
                                    <p><h2>Bus No:{{  $bus->bus_no }}</p></h2>
                                    <p><h2>Bus Type:{{ $bus->bus_type }}</p></h2>
                                </div>
                            @empty
                                <p>no buses to show</p>

                            @endforelse

                        </div>

                    </div>
    <style>
        .card-header {
            background-color: #005587;
            color: #fff;
            font-size: 24px;
            text-align: center;
        }
    </style>
    </div>

@endsection





