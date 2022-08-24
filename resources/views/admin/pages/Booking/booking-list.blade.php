@extends('admin.master')
@section('content')

    <h3>Booking list</h3>

    @if(session()->has('msg'))
    <p class="alert alert-danger">{{session()->get('msg')}}</p>
@endif

    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Seat Name</th>
                <th scope="col">User/Passenger</th>
                <th scope="col">Bus Name</th>
                <th scope="col">Seat Name</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
                
                
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $key => $booking)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $booking->seat->name}}</td>
                    <td>{{ $booking->user->name}}</td>
                    <td>{{ $booking->seat->bus->bus_name}}</td>
                    <td>{{ $booking->seat->name}}</td>
                    <td>{{ $booking->date}}</td>
                    <td>{{ $booking->time}}</td>
                    <td>{{ $booking->amount}}</td>
                    <td>{{ $booking->status}}</td>
                    <td><button class="btn btn-danger btn-sm" data-toggle="modal"
                        data-target="#exampleModal{{$booking->id}}">Cancel</button></td>
                   
                    
                     

                    
                    

                    


                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$booking->id}}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form action="{{route('admin.booking.delete',$booking->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"
                                        id="exampleModalLabel{{$booking->id}}">Delete
                                        confiramation
                                    </h5>
                                    <button type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                        <span aria-fidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </tr>
            @endforeach
        </tbody>
    </table>
   
@endsection