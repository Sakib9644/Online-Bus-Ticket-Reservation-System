<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;

use Illuminate\Support\Facades\DB;

class TripBook extends Component
{
    public $trip, $seats, $totalPrice = 0, $date, $time, $booked, $selectedSeats = [], $message = null, $demo = 0, $paymentMethod = 'online';

    public function mount($trip)
    {
        $this->trip = $trip;
        $this->date = $trip->date;
        $this->time = $trip->time;
        $this->seats = [];
        $this->demo = Booking::where('trip_id', $this->trip->id)
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
        $this->booked = Booking::where('trip_id', $this->trip->id)
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

        $currentBookingCount = Booking::where('trip_id', $this->trip->id)
            ->where('user_id', auth()->id())
            ->count();

        if (($currentBookingCount + count($this->selectedSeats)) > 7) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => "You cannot book more than 7 seats for this trip. (You already have $currentBookingCount seats, and you selected " . count($this->selectedSeats) . " more)"]);
            return;
        }

            $bookingIds = [];
            $ticketNo = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            DB::transaction(function () use (&$bookingIds, $ticketNo) {
                // Final verification of seat availability
                $alreadyBooked = Booking::where('trip_id', $this->trip->id)
                    ->whereIn('seat_id', $this->selectedSeats)
                    ->lockForUpdate()
                    ->exists();

                if ($alreadyBooked) {
                    throw new \Exception('One or more selected seats have just been booked by another passenger. Please refresh.');
                }

                foreach ($this->selectedSeats as $seatId) {
                    $booking = Booking::create([
                        'trip_id' => $this->trip->id,
                        'seat_id' => $seatId,
                        'user_id' => auth()->id(),
                        'bus_id' => $this->trip->bus_id,
                        'date' => $this->trip->date,
                        'time' => $this->trip->time,
                        'amount' => $this->trip->fare,
                        'status' => 'Pending',
                        'ticket_no' => $ticketNo
                    ]);
                    $bookingIds[] = $booking->id;
                }
            });

            if ($this->paymentMethod == 'online') {
                $idsString = implode(',', $bookingIds);
                return redirect()->route('user.payment', ['id' => $idsString]);
            }

            $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Reservation created! Please complete payment manually.']);
            return redirect()->route('booking.details');


        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => $e->getMessage()]);
            $this->searchSeat(); // Refresh to show taken seats
        }
    }
}

