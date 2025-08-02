<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;

class TripBook extends Component
{
    public $trip, $seats, $totalPrice = 0, $date, $time, $booked, $selectedSeats = [], $message = null, $demo = 0;

    public function mount($trip)
    {

        $this->trip = $trip;
        $this->date = $trip->date;
        $this->time = $trip->time;
        $this->seats = [];
        $this->demo = Booking::where('bus_id', $this->trip->bus_id)
            ->where('user_id', auth()->id())
            ->count();
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
            $this->reset('selectedSeats');
            $this->totalPrice = 0;
        }
    }

    public function searchSeat()
    {
        $this->booked = Booking::where('date', $this->date)
            ->where('time', $this->time)
            ->get();

        $this->seats = $this->trip->bus->seats;

        $availableSeatsCount = $this->seats->count() - $this->booked->count();

        if ($availableSeatsCount <= 0) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'No seats available.'
            ]);
        } else {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Seats are available.'
            ]);
        }
    }

    public function book()
    {
        if (empty($this->selectedSeats)) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Please choose at least one seat before booking.']);
            return;
        }

        $bus = Booking::where('bus_id', $this->trip->bus_id)->where('user_id', auth()->user()->id)->count();
        if ($bus >= 7) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'You have Already Booked 7 Seats from this bus.']);
            return;
        }

        foreach ($this->selectedSeats as $seatId) {
            Booking::create([
                'seat_id' => $seatId,
                'user_id' => auth()->id(),
                'bus_id' => $this->trip->bus_id,
                'date' => $this->trip->date,
                'time' => $this->trip->time,
                'amount' => $this->trip->fare,
            ]);
        }

        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Your Ticket Booked. Please complete the transaction, otherwise, your booking may be pending.']);

        // Reset after booking
    }
}
