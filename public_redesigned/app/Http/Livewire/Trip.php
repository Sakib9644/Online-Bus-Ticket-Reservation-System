<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\Trip as ModelsTrip;
use Livewire\Component;

class Trip extends Component
{
    public $from;
    public $to;
    public $date;
    public $time;
    public $locations;
    public $trips;

    public function mount()
    {
        $this->locations = Location::all();
        $this->trips = collect();
    }

public function search()
{
    // If no filters selected, clear trips and return

    $query = ModelsTrip::query();

    if ($this->from !== null && $this->from !== '') {
        $query->where('location_from', $this->from);
    }

    if ($this->to !== null && $this->to !== '') {
        $query->where('location_to', $this->to);
    }

    if ($this->date !== null && $this->date !== '') {
        $query->whereDate('date', $this->date);
    }

    if ($this->time !== null && $this->time !== '') {
        $query->where('time', $this->time);
    }
    $this->trips = $query->get();
}


    public function render()
    {
        return view('livewire.trip', [
            'trips' => $this->trips,
            'locations' => $this->locations,
        ]);
    }
}
