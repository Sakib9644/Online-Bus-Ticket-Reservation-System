@extends('admin.master')

@section('content')

<div class="col-12">
    <h3 class="mb-4">Add Bus</h3>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>
                <p class="alert alert-success">{{ $error }}</p>
            </div>
        @endforeach
    @endif
</div>

    <div class="col-12">
        <div class="card shadow position-relative">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bus Informations</h6>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.bus.update', $bus->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus Name</label>
                                <input name="bus name" type="text" value="{{ $bus->bus_name }}"
                                    placeholder="Bus Name" class="form-control">

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus Number</label>
                                <input name="bus_no" type="text" value="{{ $bus->bus_no }}"
                                    placeholder="Bus Number" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus Type</label>
                                <select class="form-control" name="bus_type" value="{{ $bus->bus_type }}">
                                    <option value="">Select Bus Type</option>
                                    <option value="Ac Bus" @if ($bus->bus_type == 'ac' ? 'selected' : '')                                    @endif>AC Bus</option>
                                    <option value="Non Ac Bus" @if ($bus->bus_type == 'non-ac' ? 'selected' : '') @endif>Non AC Bus</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus Image</label>
                                <input name="bus_image" type="file" class="form-control">
                                <img src="{{ url('/uploads/' . $bus->image) }}" width="80">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                    <a href="{{ route('admin.bus') }}" class="btn btn-danger btn-icon-split">
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