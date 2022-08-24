@extends('admin.master')
@section('content')

    <div class="col-12">
        <h3 class="mb-4">Add Trip</h3>
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
            <div class="card-body">

                <form action="{{ route('admin.trip.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Enter Location From</label>
                                <select class="form-control" required name="location from">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->location_from }}">{{ $location->location_from }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Enter Location To</label>
                                <select class="form-control" required name="location to">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus</label>
                                <select class="form-control" required name="bus_id">
                                    @foreach ($buses as $bus)
                                        <option value="{{ $bus->id }}">{{ $bus->bus_name }} - {{  ucfirst($bus->bus_type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Date</label>
                                <input required name="date" type="date" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Time</label>
                                <select class="form-control" required name="time">
                                    <option value="">Time Period</option>
                                    <option value="Morning (07:00AM)">Morning (07:00AM)</option>
                                    <option value="Morning (09:00AM)">Morning (09:00AM)</option>
                                    <option value="Morning (11:00AM)">Morning (11:00AM)</option>
                                    <option value="Afternoon (01:00PM)">Afternoon (01:00PM)</option>
                                    <option value="Afternoon (03:00PM)">Afternoon (03:00PM)</option>
                                    <option value="Afternoon (05:00PM)">Afternoon (05:00PM)</option>
                                    <option value="Night (07:00PM)">Night (07:00PM)</option>
                                    <option value="Night (09:00PM)">Afternoon (09:00PM)</option>
                                    <option value="Night (11:00PM)">Night (11:00PM)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Bus Fare</label>
                                <input required name="bus fare" type="number" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>
                        <a href="{{ route('admin.trip') }}" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-times"></i>
                            </span>
                            <span class="text">Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
