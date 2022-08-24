@extends('frontend.index')
@section( 'content')
<br>
<br>
<div id="gallery">
    
            <div class="container">
				<div class="card-header mb-3">Search Trip</div>
                    <div class="card-body mt-4">
							<div class="search-form-wrapper">
								<form method="get" action="{{ route('frontend.showTrip') }}">
									<div class="row">
										<div class="col-sm-2">
											<select class="form-control" required name="from">
												@foreach ($locations as $location)
												<option value="{{$location->location_from}}">{{$location->location_from}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-sm-2">
											<select class="form-control" required name=" to">
												@foreach ($locations as $location)
												<option value="{{$location->location_to}}">{{$location->location_to}}</option>
												@endforeach
											</select>
										</div>
                                        <div class="col-sm-2">
											<input name="date" class="form-control" type="date" required>
										</div>
                                        <div class="col-sm-3">
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
										<div class="col-sm-3 search-btn">
											<button type="submit" class="btn form-control smera-danger " style="background-color:black;"onMouseOver="this.style.backgroundColor=''" onMouseOut="this.style.backgroundColor='black'">SEARCH</button>
										</div>
									</div>
								</form>
                        </div>
                    </div>
			</div>
    </div>

@endsection

            	
            
            
    
