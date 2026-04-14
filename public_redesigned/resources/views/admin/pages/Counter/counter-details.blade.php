@extends('admin.master')
@section('content')

<h3> Counter Details</h3>

<p>Counter Name:{{$counter->counter_name}}</p>
<p>Counter Name:{{$counter->counter_no}}</p>
<p>Counter Phone Number:{{$counter->counter_phone}}</p>

@endsection