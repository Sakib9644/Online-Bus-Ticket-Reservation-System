@extends('admin.master')

@section('content')

    @if(session()->has('message'))
        <p class="alert alert-success">
            {{session()->get('message')}}
        </p>
    @endif
    <h4 style="color:rgb(43, 46, 226)" front size="24px">
        Dashboard
    </h4>
@endsection