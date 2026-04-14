<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;

use Illuminate\Support\Facades\DB;

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
        
        $this->searchSeat(true);
    }

    public function render()
    {
        return view('livewire.trip-book');
    }

    public function updatedSelectedSeats($value)
    {
        $this->totalPrice = count($this->selectedSeats) * $this->trip->fare;
    }

    public function searchSeat($silent = false)
    {
        $this->booked = Booking::where('date', $this->date)
            ->where('time', $this->time)
            ->get();

        $this->seats = $this->trip->bus->seats;

        $availableSeatsCount = $this->seats->count() - $this->booked->count();

        if (!$silent) {
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
    }

    public function book()
    {
        if (empty($this->selectedSeats)) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Please choose at least one seat before booking.']);
            return;
        }

        $currentBookingCount = Booking::where('bus_id', $this->trip->bus_id)
            ->where('user_id', auth()->id())
            ->count();

        if (($currentBookingCount + count($this->selectedSeats)) > 7) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'You cannot book more than 7 seats in total.']);
            return;
        }

        try {
            DB::transaction(function () {
                // Final verification of seat availability
                $alreadyBooked = Booking::where('date', $this->trip->date)
                    ->where('time', $this->trip->time)
                    ->whereIn('seat_id', $this->selectedSeats)
                    ->lockForUpdate() // Lock the rows to prevent race conditions
                    ->exists();

                if ($alreadyBooked) {
                    throw new \Exception('One or more selected seats have just been booked by another passenger. Please refresh.');
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
            });

            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Tickets booked successfully! You can book more seats or view your bookings later.']);
            
            $this->reset('selectedSeats');
            $this->totalPrice = 0;
            $this->searchSeat(); // Refresh the view to show newly booked seats as "Filled"

            // No redirect, stay on page as requested


        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => $e->getMessage()]);
            $this->searchSeat(); // Refresh to show taken seats
        }
    }
}

