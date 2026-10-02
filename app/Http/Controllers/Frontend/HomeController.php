<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Location;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $buses = Bus::all();
        $locations = Location::all();
        
        $divisionNames = ['Dhaka', 'Chattogram', 'Rajshahi', 'Khulna', 'Barishal', 'Sylhet', 'Rangpur', 'Mymensingh'];
        $popularDistricts = ['Cox\'s Bazar', 'Rangamati', 'Bandarban', 'Cumilla', 'Bogura', 'Noakhali'];

        // Fetch cities from database to use their uploaded images
        $citiesFromDb = City::all()->keyBy('name');

        // Calculate Popular Destinations based on Ticket Sales (Bookings)
        $popularBySales = Booking::join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->select('trips.location_to', \DB::raw('count(bookings.id) as total_sales'))
            ->groupBy('trips.location_to')
            ->orderBy('total_sales', 'desc')
            ->get()
            ->pluck('total_sales', 'location_to')
            ->toArray();

        $imageMap = [
            'Dhaka' => url('/uploads/cities/dhaka.png'), 
            'Chattogram' => url('/uploads/cities/chittagong.png'), 
            'Rajshahi' => url('/uploads/cities/rajshahi.png'), 
            'Khulna' => url('/uploads/cities/khulna.png'), 
            'Barishal' => url('/uploads/cities/barishal.png'), 
            'Sylhet' => url('/uploads/cities/sylhet.png'), 
            'Rangpur' => url('/uploads/cities/rangpur.png'), 
            'Mymensingh' => url('/uploads/cities/mymensingh.png'), 
            'Cox\'s Bazar' => url('/uploads/cities/coxs_bazar.png'), 
            'Rangamati' => url('/uploads/cities/rangamati.png'), 
            'Bandarban' => url('/uploads/cities/bandarban.png'), 
            'Cumilla' => url('/uploads/cities/cumilla.png'), 
            'Bogura' => url('/uploads/cities/bogura.png'), 
            'Noakhali' => url('/uploads/cities/noakhali.png') 
        ];

        $descMap = [
            'Dhaka' => 'The vibrant capital city',
            'Chattogram' => 'Majestic hills & harbor',
            'Rajshahi' => 'The city of silk & education',
            'Khulna' => 'Gateway to the Sundarbans',
            'Barishal' => 'Venice of the East',
            'Sylhet' => 'Serene tea gardens & hills',
            'Rangpur' => 'Land of heritage & history',
            'Mymensingh' => 'Cultural hub of the Brahmaputra',
            'Cox\'s Bazar' => 'World\'s longest sea beach',
            'Rangamati' => 'Serene beauty of Kaptai Lake',
            'Bandarban' => 'The roof of Bangladesh',
            'Cumilla' => 'Ancient history & archeology',
            'Bogura' => 'Oldest city of Bengal',
            'Noakhali' => 'Land of coastal beauty'
        ];

        $destinations = [];
        $allItems = array_merge($divisionNames, $popularDistricts);
        
        foreach ($allItems as $name) {
            $dbCity = $citiesFromDb->get($name);
            $img = ($dbCity && $dbCity->image) ? url('/uploads/cities/'.$dbCity->image) : ($imageMap[$name] ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800');
            
            $destinations[] = [
                'name' => $name,
                'img' => $img,
                'desc' => $descMap[$name] ?? 'Explore the beauty of ' . $name,
                'sales' => $popularBySales[$name] ?? 0
            ];
        }

        // Sort destinations by sales count (descending)
        usort($destinations, function($a, $b) {
            return $b['sales'] <=> $a['sales'];
        });

        $trips = Trip::with('bus')->withCount('bookings')->orderByDesc('bookings_count')->get();
        return view('frontend.pages.home', compact('buses', 'locations', 'trips', 'destinations'));
    }
    public function reserveForm()
    {
        $locations = Location::all();
        return view('frontend.pages.reserve-form', compact('locations'));
    }

    public function order(Request  $request)
    {

        $new = new Booking();

        $rand = rand(1, 10);


        if (Booking::where('booking_code', $new)->exist()) {

            return $rand;
        }

        $new->booking_code = $rand;
        $new->save();
    }

    public function showTrip(Request $request)
    {
        $locations = Location::all();
        $trips = Trip::with('bus')
            ->where('location_from', $request->from)
            ->where('location_to', $request->to)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->get();
        return view('frontend.pages.show-trips', compact('trips', 'locations'));
    }

    public function bookTrip($id)
    {
        $locations = Location::all();
        $trip = Trip::with('bus')->findOrFail($id);
        return view('frontend.pages.book-trips', compact('trip'));
    }
}
