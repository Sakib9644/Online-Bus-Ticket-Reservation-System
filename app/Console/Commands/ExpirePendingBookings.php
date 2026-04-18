<?php

namespace App\Console\Commands;

use App\Services\BookingExpiryService;
use Illuminate\Console\Command;

class ExpirePendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release seats held by expired pending bookings';

    /**
     * Execute the console command.
     *
     * @param BookingExpiryService $bookingExpiryService
     * @return int
     */
    public function handle(BookingExpiryService $bookingExpiryService)
    {
        $released = $bookingExpiryService->releaseExpiredPending();

        $this->info('Expired pending bookings released: ' . $released);

        return 0;
    }
}
