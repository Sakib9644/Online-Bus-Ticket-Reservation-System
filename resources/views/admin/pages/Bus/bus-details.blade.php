@extends('admin.master')
@section('content')

<h3> Bus Details </h3>

<p>                        
    <img src="{{url('/uploads/'.$bus->image)}}" width="100px" alt="">
</p>
<p>Bus Name:{{$bus->bus_name}} </p>
<p>Bus No:{{$bus->bus_no}} </p>
<p>Bus Type:{{$bus->bus_type}} </p>

@endsection