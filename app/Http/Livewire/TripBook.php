<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class TripBook extends Component
{
    public $trip, $seats, $totalPrice, $date, $time, $booked;
    public $availableBuses, $availableDates, $availableTimes;
    public $selectedSeats = [];

    public function mount($trip)
    {
        $this->seats = [];
        $this->trip = $trip;
        $this->date = $this->trip->date;
        $this->time = $this->trip->time;
    }

    public function render()
    {
        return view('livewire.trip-book');
    }

    public function updatedSelectedSeats($value)
    {
        if ($value) {
            $this->totalPrice = count($this->selectedSeats) * $this->trip->fare;
        } else {
            $this->reset(['selectedSeats']);
        }
    }

    public function searchSeat()
    {
        $this->booked = Booking::where('date', $this->date)
            ->where('time', $this->time)
            ->get();
        $this->seats = $this->trip->bus->seats;
    }

    public function book()
    {
        $this->selectedSeats;
        $this->totalPrice = count($this->selectedSeats) * $this->trip->fare;
        if ($this->selectedSeats) {
            foreach ($this->selectedSeats as $key => $value) {
                $data = array(
                    'seat_id' => $value,
                    'user_id' => auth()->id(),
                    'bus_id' => $this->trip->bus_id,
                    'date' => $this->trip->date,
                    'time' => $this->trip->time,
                    'amount' => $this->trip->fare,
                );
                Booking::Create($data);
            }
        }
        Session::flash('message', 'Your Ticket Booked. Please complete the transaction,
        otherwise, your booking may be pending');
    }
}