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
    public $locations;
    public $perPage = 6;

    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function mount()
    {
        $this->locations = Location::all();
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function search()
    {
        // Reset pagination on search
        $this->perPage = 6;
    }

    public function render()
    {
        $query = ModelsTrip::query();
        $hasFilters = false;

        if (!empty($this->from)) {
            $query->where('location_from', $this->from);
            $hasFilters = true;
        }

        if (!empty($this->to)) {
            $query->where('location_to', $this->to);
            $hasFilters = true;
        }

        if (!empty($this->date)) {
            $query->whereDate('date', $this->date);
            $hasFilters = true;
        }

        // Only fetch and show trips if at least one filter is applied
        if ($hasFilters) {
            $trips = $query->take($this->perPage)->get();
        } else {
            $trips = collect();
        }

        return view('livewire.trip', [
            'trips' => $trips,
            'locations' => $this->locations,
        ]);
    }
}
