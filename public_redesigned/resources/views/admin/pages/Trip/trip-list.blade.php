@extends('admin.master')
@section('content')

    <h3 class="mb-3">Trip list</h3>

    @if(session()->has('message'))
    <p class="alert alert-success">{{session()->get('message')}}</p>
@endif 

@if(session()->has('msg'))
    <p class="alert alert-danger">{{session()->get('msg')}}</p>
@endif 

@if(session()->has('success'))
    <p class="alert alert-success">{{session()->get('success')}}</p>
@endif 

    <a href="{{route('admin.trip.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Trip</a>
<br>
<br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">From Location</th>
                <th scope="col">To Location</th>
                <th scope="col">Bus</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Fare</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($trips as $key => $trip)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $trip->location_from}}</td>
                    <td>{{ $trip->location_to}}</td>
                    <td>{{ $trip->bus->bus_name}}</td>
                    <td>{{ $trip->date}}</td>
                    <td>{{ $trip->time}}</td>
                    <td>{{ $trip->fare}}</td>
                    <td><a href="{{route('admin.trip.edit',$trip->id)}}"><button
                        class="btn btn-primary btn-sm">Edit</button></a></td>
                    <td><button class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#exampleModal{{$trip->id}}">Delete</button>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$trip->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="{{route('admin.trip.delete',$trip->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="exampleModalLabel{{$trip->id}}}}">Delete
                                            confirmation
                                        </h5>
                                        <button type="button" class="close"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-fidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>
   

@endsection