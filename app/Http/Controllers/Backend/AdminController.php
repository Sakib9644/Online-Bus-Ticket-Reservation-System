<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bus;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        $count = [
            'booking' => Booking::count(),
            'bus' => Bus::count(),
            'user' => User::count(),
            'revenue' => Booking::where('status', 'complete')->sum('amount'),
            'today' => Booking::whereDate('created_at', now()->today())->count(),
        ];

        $recentBookings = Booking::with(['user', 'seat.bus', 'trip'])
            ->latest()
            ->get()
            ->groupBy(function($item) {
                return $item->ticket_no ?: ($item->user_id . '|' . $item->date . '|' . $item->time);
            })
            ->take(5);

        return view('admin.pages.Dashboard.admin-dashboard', compact('count', 'recentBookings'));
    }
}