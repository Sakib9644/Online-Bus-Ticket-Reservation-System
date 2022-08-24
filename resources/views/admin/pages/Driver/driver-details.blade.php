@extends('admin.master')
@section('content')

<h3> Driver Details </h3>

<p>Driver Name:{{$driver->driver_name}} </p>
<p>Driver Id:{{$driver->driver_id}} </p>
<p>Driver Phone Number:{{$driver->driver_phone_number}} </p>
<p>Bus Name:{{$driver->bus_name}} </p>
<p>Bus No:{{$driver->bus_no}} </p>

@endsection