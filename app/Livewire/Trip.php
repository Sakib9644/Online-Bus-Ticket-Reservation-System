<?php

namespace App\Livewire;

use App\Models\Location;
use App\Models\Trip as ModelsTrip;
use Livewire\Component;

class Trip extends Component
{
    public $from;
    public $to;
    public $date;
    public $time;
    public $type;
    public $coach_no; // Course Number
    public $bus_name; // Bus Name
    public $times;
    public $origins;
    public $destinations;
    public $coachNumbers;
    public $busNames;
    public $perPage = 6;

    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function mount()
    {
        $this->times = ModelsTrip::select('time')->distinct()->pluck('time');
        
        // Fetch unique origins and destinations directly from Trips
        $this->origins = ModelsTrip::select('location_from')->distinct()->pluck('location_from');
        $this->destinations = ModelsTrip::select('location_to')->distinct()->pluck('location_to');
        
        // Fetch unique bus details for dropdowns
        $this->coachNumbers = \App\Models\Bus::select('coach_no')->distinct()->pluck('coach_no');
        $this->busNames = \App\Models\Bus::select('bus_name')->distinct()->pluck('bus_name');

        // Handle incoming request parameters for homepage redirects
        $this->from = request('from', $this->from);
        $this->to = request('to', $this->to);
        $this->date = request('date', $this->date);
        $this->time = request('time', $this->time);
        $this->type = request('type', $this->type);
        $this->coach_no = request('coach_no', $this->coach_no);
        $this->bus_name = request('bus_name', $this->bus_name);
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

        if (!empty($this->time)) {
            $query->where('time', $this->time);
            $hasFilters = true;
        }

        if (!empty($this->type)) {
            $query->whereHas('bus', function($q) {
                $q->where('bus_type', $this->type);
            });
            $hasFilters = true;
        }

        if (!empty($this->coach_no)) {
            $query->whereHas('bus', function($q) {
                $q->where('coach_no', 'like', '%' . $this->coach_no . '%');
            });
            $hasFilters = true;
        }

        if (!empty($this->bus_name)) {
            $query->whereHas('bus', function($q) {
                $q->where('bus_name', 'like', '%' . $this->bus_name . '%');
            });
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
            'origins' => $this->origins,
            'destinations' => $this->destinations,
            'times' => $this->times,
            'coachNumbers' => $this->coachNumbers,
            'busNames' => $this->busNames,
            'hasFilters' => $hasFilters,
        ]);
    }
}
