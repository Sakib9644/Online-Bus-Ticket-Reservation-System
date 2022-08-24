@extends('admin.master')
@section('content')

    <h3>User list</h3>

    @if(session()->has('msg'))
    <p class="alert alert-danger">{{session()->get('msg')}}</p>
@endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Member since</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->phone}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d Y') }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
@endsection
