@extends('admin.master')
@section('content')

    <h3>Seat list</h3>
    
    @if (session()->has('msg'))
    <p class="alert alert-danger">{{ session()->get('msg') }}</p>
@endif

@if (session()->has('success'))
    <p class="alert alert-success">{{ session()->get('success') }}</p>
@endif


@if (session()->has('message'))
    <p class="alert alert-success">{{ session()->get('message') }}</p>
@endif

    <a href="{{ route('admin.seat.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
<br>
<br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Seat Id</th>
                <th scope="col">Seat Name</th>
                <th scope="col">Bus Name</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($seats as $key => $seat)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $seat->id}}</td>
                    <td>{{ $seat->name}}</td>
                    <td>{{ $seat->bus->bus_name}}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{route('admin.seat.edit',$seat->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.seat.delete',$seat->id)}}"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $seats->links() }}
@endsection