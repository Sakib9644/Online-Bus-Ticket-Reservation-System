@extends('admin.master')
@section('content')

    <h3>Bus Route list</h3>
    
    @if(session()->has('success'))
    <p class="alert alert-success">
        {{session()->get('success')}}
    </p>
@endif

    <a href="{{ route('admin.busroute.create') }}" class="btn btn-success">Add Bus Route</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Bus No</th>
                <th scope="col">Bus Type</th>
                <th scope="col">Location From</th>
                <th scope="col">Location To</th>
                <th scope="col">Bus Route Time</th>
                <th scope="col">Bus Route Date</th>
                <th scope="col">Bus Departure From</th>
                <th scope="col">Bus Departure To</th>
                <th scope="col">Bus Fare</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($busroutes as $key => $busroute)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $busroute->bus_no}}</td>
                    <td>{{ $busroute->bus_type}}</td>
                    <td>{{ $busroute->location_from}}</td>
                    <td>{{ $busroute->location_to}}</td>
                    <td>{{ $busroute->bus_route_time}}</td>
                    <td>{{ $busroute->bus_route_date}}</td>
                    <td>{{ $busroute->bus_departure_from}}</td>
                    <td>{{ $busroute->bus_departure_to}}</td>
                    <td>{{ $busroute->bus_fare}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('admin.bus_route.details', $busroute->id)}}"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-info" href=""><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('admin.bus_route.delete', $busroute->id)}}"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

  