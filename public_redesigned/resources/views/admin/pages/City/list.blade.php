@extends('admin.master')
@section('content')

    <h3 class="mb-4">Cities</h3>


    @if (session()->has('msg'))
        <p class="alert alert-danger">{{ session()->get('msg') }}</p>
    @endif

    @if (session()->has('success'))
        <p class="alert alert-success">{{ session()->get('success') }}</p>
    @endif

    
    @if (session()->has('message'))
        <p class="alert alert-success">{{ session()->get('message') }}</p>
    @endif

    <a href="{{ route('admin.city.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add City</a>
    <br>
    <br>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Names</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cities as $key => $city)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $city->name }}</td>
                    <td class="text-end">
                        <a class="btn btn-info btn-sm" href="{{ route('admin.city.edit', $city->id) }}">Edit</i></a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" href="{{ route('admin.city.delete', $city->id) }}">Delete</i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection