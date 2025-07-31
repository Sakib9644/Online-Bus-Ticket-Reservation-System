<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Trip as ModelsTrip;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Trip extends Component
{
    public $from, $to, $date, $time;
    public $locations;
    public $trips;

    public function mount()
    {
        $this->locations = Location::all();
        $this->trips = collect();
    }

    public function search()
    {
        $this->validate([
            'from' => 'required',
            'to' => 'required',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $this->trips = ModelsTrip::with('bus')
        ->where('location_from', $this->from)
        ->where('location_to', $this->to)
        ->where('date', $this->date)
        ->where('time', $this->time)
        ->get();
    }

    public function render()
    {
        return view('livewire.trip');
    }
}
