@extends('admin.master')

@section('content')
    <h1>Add driver</h1>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <div>
            <p class="alert alert-danger">{{$error}}</p>
        </div>
    @endforeach
@endif

@if(session()->has('msg'))

    <p class="alert alert-success">{{session()->get('msg')}}</p>
@endif

    <form action="{{route('admin.driver.store')}}" method="POST">
        @csrf
        
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter Driver Name</label>
        <input required name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter Driver Id</label>
        <input required name="id" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter Driver Phone Number</label>
        <input required name="phone" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter Bus Name</label>
        <input required name="bus name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter Bus No</label>
        <input required name="bus no" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection