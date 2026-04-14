@extends('admin.master')
@section('content')

    <div class="col-12">
        <h3 class="mb-4">Edit Location</h3>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>
                    <p class="alert alert-success">{{ $error }}</p>
                </div>
            @endforeach
        @endif

        @if (session()->has('msg'))
            <p class="alert alert-success">{{ session()->get('msg') }}</p>
        @endif
    </div>

    <div class="col-12">
        <div class="card shadow position-relative">
            <div class="card-body">
                <form action="{{route('admin.location.update',$location->id)}}" method="POST">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Enter Location From</label>
                                <select class="form-control" value="{{ $location->location_from}}" required name="location from" >
                                    <option value=""></option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Jessore">Jessore</option>
                                    <option value="Satkhira">Satkhira</option>
                                    <option value="Mymenshingh">Mymenshingh</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Cox's Bazar">Cox's Bazar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Enter Location To</label>
                                <select class="form-control" value="{{ $location->location_to}}" required name="location to">
                                    <option value=""></option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Jessore">Jessore</option>
                                    <option value="Satkhira">Satkhira</option>
                                    <option value="Mymenshingh">Mymenshingh</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Cox's Bazar">Cox's Bazar</option>
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
                    </a>
                </form>
            </div>
        </div>
    </div>

@endsection