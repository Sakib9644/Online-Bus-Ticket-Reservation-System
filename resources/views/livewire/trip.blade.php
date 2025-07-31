<div>
    <form wire:change="search">
        <div class="row mb-3">
            <div class="col-sm-3">
                <select class="form-control" wire:model="from" required>
                    <option value="">Select From</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location_from }}">{{ $location->location_from }}</option>
                    @endforeach
                </select>
                @error('from')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-sm-3">
                <select class="form-control" wire:model="to" required>
                    <option value="">Select To</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                    @endforeach
                </select>
                @error('to')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-sm-2">
                <input type="date" class="form-control" wire:model="date" required />
                @error('date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-sm-3">
                <select class="form-control" wire:model="time" required>
                    <option value="">Time Period</option>
                    <option value="Morning (07:00AM)">Morning (07:00AM)</option>
                    <option value="Morning (09:00AM)">Morning (09:00AM)</option>
                    <option value="Morning (11:00AM)">Morning (11:00AM)</option>
                    <option value="Afternoon (01:00PM)">Afternoon (01:00PM)</option>
                    <option value="Afternoon (03:00PM)">Afternoon (03:00PM)</option>
                    <option value="Afternoon (05:00PM)">Afternoon (05:00PM)</option>
                    <option value="Night (07:00PM)">Night (07:00PM)</option>
                    <option value="Night (09:00PM)">Night (09:00PM)</option>
                    <option value="Night (11:00PM)">Night (11:00PM)</option>
                </select>
                @error('time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


        </div>
    </form>

    @if ($trips->count() > 0)
        <div class="row">
            @foreach ($trips as $trip)
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>{{ $trip->location_from }} to {{ $trip->location_to }}</b>
                        </div>
                        <div class="panel-body">
                            <p>
                                <b>Fare:</b> {{ $trip->fare }}
                            </p>
                            <p>
                                <b>Bus:</b> {{ $trip->bus->bus_name }}
                            </p>
                            <p>
                                <b>Bus Type:</b> {{ ucfirst($trip->bus->bus_type) }}
                            </p>
                            <p>
                                <b>Avilable Ticket:</b> {{ $trip->bus->seats->count() - $trip->bus->booking->count() }}
                            </p>





                            <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="btn btn-primary btn-sm">Book
                                Now </a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No trips available.</p>
    @endif
</div>
