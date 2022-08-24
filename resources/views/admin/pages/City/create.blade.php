@extends('admin.master')

@section('content')

    <h3 class="mb-4">Add City</h3>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>
                <p class="alert alert-danger">{{ $error }}</p>
            </div>
        @endforeach
    @endif

    <form action="{{ route('admin.city.store') }}" method="POST">
        @csrf
        <div class="col-lg-6">
            <div class="card shadow position-relative">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add City Name</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control form-control-lg" name="name" placeholder="City Name"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                </div>
            </div>

        </div>

    </form>

@endsection