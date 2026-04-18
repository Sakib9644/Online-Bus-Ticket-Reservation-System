<?php

namespace App\Services;

use App\Models\Booking;

class BookingExpiryService
{
    const ONLINE_HOLD_MINUTES = 15;
    const MANUAL_HOLD_MINUTES = 30;

    public function holdMinutesFor($paymentMethod)
    {
        return strtolower((string) $paymentMethod) === 'manual'
            ? self::MANUAL_HOLD_MINUTES
            : self::ONLINE_HOLD_MINUTES;
    }

    public function holdUntil($paymentMethod)
    {
        return now()->addMinutes($this->holdMinutesFor($paymentMethod));
    }

    public function releaseExpiredPending()
    {
        return Booking::query()
            ->pending()
            ->where(function ($query) {
                $query->where(function ($withExpiry) {
                    $withExpiry->whereNotNull('expires_at')
                        ->where('expires_at', '<=', now());
                })->orWhere(function ($legacyPending) {
                    $legacyPending->whereNull('expires_at')
                        ->where('created_at', '<=', now()->subMinutes(self::MANUAL_HOLD_MINUTES));
                });
            })
            ->delete();
    }
}
