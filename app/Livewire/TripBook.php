<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Services\BookingExpiryService;
use Illuminate\Support\Facades\DB;

class TripBook extends Component
{
    public $trip, $seats, $totalPrice = 0, $date, $time, $booked, $selectedSeats = [], $message = null, $demo = 0, $paymentMethod = 'online';

    private function releaseExpiredPendingBookings()
    {
        app(BookingExpiryService::class)->releaseExpiredPending();
    }

    private function activeSeatLockQuery()
    {
        return Booking::where('trip_id', $this->trip->id)->activeSeatLock();
    }

    public function mount($trip)
    {
        $this->releaseExpiredPendingBookings();

        $this->trip = $trip;
        $this->date = $trip->date;
        $this->time = $trip->time;
        $this->seats = [];
        $this->demo = $this->activeSeatLockQuery()
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
        if (count($this->selectedSeats) > 6) {
            $this->selectedSeats = array_slice($this->selectedSeats, 0, 6);
            $this->dispatch('seat-limit-exceeded', [
                'message' => 'You cannot select more than 6 seats per booking.'
            ]);
        }

        $this->totalPrice = count($this->selectedSeats) * $this->trip->fare;
    }

    public function searchSeat($silent = false)
    {
        $this->releaseExpiredPendingBookings();

        $this->booked = $this->activeSeatLockQuery()->get();

        $this->seats = $this->trip->bus->seats;

        $availableSeatsCount = $this->seats->count() - $this->booked->count();

        if (!$silent) {
            if ($availableSeatsCount <= 0) {
                // Livewire 3 syntax for browser events
                $this->dispatch('notify', 
                    type: 'error',
                    message: 'No seats available.'
                );
            } else {
                $this->dispatch('notify', 
                    type: 'success',
                    message: 'Seats are available.'
                );
            }
        }
    }

    public function book()
    {
        $this->releaseExpiredPendingBookings();

        if (empty($this->selectedSeats)) {
            $this->dispatch('notify', type: 'error', message: 'Please choose at least one seat before booking.');
            return;
        }

        if (count($this->selectedSeats) > 6) {
            $this->selectedSeats = array_slice($this->selectedSeats, 0, 6);
            $this->dispatch('seat-limit-exceeded', [
                'message' => 'You cannot select more than 6 seats per booking.'
            ]);
            return;
        }

        $currentBookingCount = $this->activeSeatLockQuery()
            ->where('user_id', auth()->id())
            ->count();

        if (($currentBookingCount + count($this->selectedSeats)) > 6) {
            $this->dispatch('seat-limit-exceeded', [
                'message' => "You cannot have more than 6 total seats booked for this trip. (You already have $currentBookingCount seat(s) booked, and you selected " . count($this->selectedSeats) . " more)."
            ]);
            return;
        }

        try {
            $bookingIds = [];
            $ticketNo = 'SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            $expiresAt = app(BookingExpiryService::class)->holdUntil($this->paymentMethod);

            DB::transaction(function () use (&$bookingIds, $ticketNo, $expiresAt) {
                // Final verification of seat availability
                $alreadyBooked = Booking::where('trip_id', $this->trip->id)
                    ->activeSeatLock()
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
                        'ticket_no' => $ticketNo,
                        'expires_at' => $expiresAt,
                    ]);
                    $bookingIds[] = $booking->id;
                }
            });

            $idsString = implode(',', $bookingIds);
            return redirect()->route('user.payment', ['id' => $idsString]);
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
            $this->searchSeat(); // Refresh to show taken seats
        }
    }
}
