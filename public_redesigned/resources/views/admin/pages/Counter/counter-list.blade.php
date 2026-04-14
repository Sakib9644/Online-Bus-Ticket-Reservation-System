@extends('admin.master')
@section('content')

    <h3>Counter list</h3>

    <a href="{{ route('admin.counter.create') }}" class="btn btn-success">Add counter</a>
<br>
<br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Counter Name</th>
                <th scope="col">Counter No</th>
                <th scope="col">Counter Phone</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($counters as $key => $counter)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $counter->counter_name }}</td>
                    <td>{{ $counter->counter_no }}</td>
                    <td>{{ $counter->counter_phone }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('admin.counter.details',$counter->id)}}"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-info" href=""><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('admin.counter.delete',$counter->id)}}"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection