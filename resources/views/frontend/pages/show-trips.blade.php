@extends('frontend.index')
@section('content')
    <br><br>
    <div id="gallery">
        <div class="container">
            <div class="card-header mb-3">Search Trip</div>
            <div class="card-body mt-4">
                <div class="search-form-wrapper">
                    <div>
                        <div class="row">
                            <div class="col-sm-2">
                                <select class="form-control" wire:model="from" required>
                                    <option value="">Select From</option>
                                    @foreach ($locationFroms as $location)
                                        <option value="{{ $location->location_from }}">{{ $location->location_from }}</option>
                                    @endforeach
                                </select>
                                @error('from') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-sm-2">
                                <select class="form-control" wire:model="to" required>
                                    <option value="">Select To</option>
                                    @foreach ($locationTos as $location)
                                        <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                                    @endforeach
                                </select>
                                @error('to') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-sm-2">
                                <input type="date" class="form-control" wire:model="date" required />
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
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
                                @error('time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-sm-3">
                                <button wire:click="search" class="btn btn-primary form-control">SEARCH</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <livewire:trip :trips="$trips" />
                {{-- Results and messages show inside Livewire component view --}}
            </div>
        </div>
    </div>
@endsection
