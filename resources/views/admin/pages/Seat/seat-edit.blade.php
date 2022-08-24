@extends('admin.master')
@section('content')

<div class="col-12">
    <h3 class="mb-4">Edit Seat</h3>
</div>

<div class="col-12">
    <div class="card shadow position-relative">
        <div class="card-body">

            <form action="{{route('admin.seat.update',$seat->id)}}" method="POST">
             @csrf
            @method('put')
        <div class="row">
        <div class="col-lg-6">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Seat Name</label>
            <input value="{{ $seat->name}}" name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Enter Bus Name</label>
            <select class="form-control" name="bus_id" value="{{$seat->bus}}">
                <option value="">Select Bus</option>
                @foreach ($buses as $bus)
                  <option value="{{ $bus->id }}">{{ $bus->bus_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
    <button type="submit" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Submit</span>
    </button>
    <a href="{{ route('admin.location') }}" class="btn btn-danger btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-times"></i>
        </span>
        <span class="text">Cancel</span>
    </a>    </form>
@endsection