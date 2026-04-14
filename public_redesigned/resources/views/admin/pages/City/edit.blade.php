@extends('admin.master')

@section('content')

    <h3 class="mb-4">Edit City</h3>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>
                <p class="alert alert-danger">{{ $error }}</p>
            </div>
        @endforeach
    @endif

    @if (session()->has('msg'))
        <p class="alert alert-success">{{ session()->get('msg') }}</p>
    @endif

    <form action="{{ route('admin.city.update', $city->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="col-lg-6">
            <div class="card shadow position-relative">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit City Name</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control form-control-lg" value="{{ $city->name }}" name="name"
                            placeholder="City Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                    <a href="{{ route('admin.city') }}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text">Cancel</span>
                    </a>
                </div>
            </div>

        </div>

    </form>

@endsection