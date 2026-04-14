@extends('admin.master')
@section('content')

    <h3>Location list</h3>

@if(session()->has('msg'))
    <p class="alert alert-danger">{{session()->get('msg')}}</p>
@endif 

@if(session()->has('success'))
    <p class="alert alert-success">{{session()->get('success')}}</p>
@endif 

    <a href="{{route('admin.location.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>Add</a>
<br>
<br>
<table class="table table-striped table-bordered table-hover">
    <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">From Location</th>
                <th scope="col">To Location</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $key => $location)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $location->location_from}}</td>
                    <td>{{ $location->location_to}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('admin.location.edit',$location->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{route('admin.location.delete',$location->id)}}"><i class="fas fa-trash-alt"></i></a>
                  </td>                 
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $locations->links() }}
@endsection