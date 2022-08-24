@extends('admin.master')
@section('content')

    <h3>Driver list</h3>

    <a href="{{route('admin.driver.create')}}" class="btn btn-success">Add Driver</a>
    <br>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Driver Name</th>
                <th scope="col">Driver Id</th>
                <th scope="col">Driver Phone Number</th>
                <th scope="col">Bus Name</th>
                <th scope="col">Bus No</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($drivers as $key=> $driver)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $driver->driver_name }}</td>
                    <td>{{ $driver->driver_id }}</td>
                    <td>{{ $driver->driver_phone_number }}</td>
                    <td>{{ $driver->bus_name }}</td>
                    <td>{{ $driver->bus_no }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('admin.driver.details',$driver->id)}}"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-info" href=""><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('admin.driver.delete',$driver->id)}}"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
