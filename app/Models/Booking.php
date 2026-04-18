<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seat;

class Booking extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function scopePending($query)
    {
        return $query->whereRaw('LOWER(status) = ?', ['pending']);
    }

    public function scopeComplete($query)
    {
        return $query->whereRaw('LOWER(status) = ?', ['complete']);
    }

    public function scopeActiveSeatLock($query)
    {
        return $query->where(function ($statusQuery) {
            $statusQuery->complete()
                ->orWhere(function ($pendingQuery) {
                    $pendingQuery->pending()
                        ->where(function ($expiryQuery) {
                            $expiryQuery->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                        });
                });
        });
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
