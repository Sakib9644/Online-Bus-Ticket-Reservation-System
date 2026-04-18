<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\City;
use App\Models\Location;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Data Cleanup
        Schema::disableForeignKeyConstraints();
        DB::table('bookings')->truncate();
        DB::table('trips')->truncate();
        DB::table('locations')->truncate();
        DB::table('seats')->truncate();
        DB::table('buses')->truncate();
        DB::table('cities')->truncate();
        Schema::enableForeignKeyConstraints();

        $operators = ['Hanif Enterprise', 'Ena Transport', 'Shohagh Paribahan', 'Green Line', 'Desh Travels', 'Syamoli', 'Saintmartin Travels', 'S.R Travels', 'Soudia', 'Nabil Paribahan'];
        $districts = [
            'Dhaka', 'Gazipur', 'Kishoreganj', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail', 'Faridpur', 'Madaripur', 'Gopalganj',
            'Chattogram', 'Cox\'s Bazar', 'Bandarban', 'Khagrachari', 'Rangamati', 'Noakhali', 'Feni', 'Lakshmipur', 'Chandpur', 'Cumilla', 'Brahmanbaria',
            'Rajshahi', 'Chapainawabganj', 'Naogaon', 'Natore', 'Joypurhat', 'Pabna', 'Sirajganj', 'Bogura',
            'Khulna', 'Bagerhat', 'Satkhira', 'Jessore', 'Jhenaidah', 'Magura', 'Meherpur', 'Narail', 'Chuadanga', 'Kushtia',
            'Barishal', 'Bhola', 'Jhalokathi', 'Patuakhali', 'Pirojpur', 'Barguna',
            'Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj',
            'Rangpur', 'Dinajpur', 'Thakurgaon', 'Panchagarh', 'Nilphamari', 'Lalmonirhat', 'Kurigram', 'Gaibandha',
            'Mymensingh', 'Netrokona', 'Jamalpur', 'Sherpur'
        ];

        // 2. Generate Cities for all districts
        foreach ($districts as $district) {
            City::create(['name' => $district]);
        }

        // 2. Generate 100 Buses & 40 Seats each
        $createdBuses = [];
        for ($i = 1; $i <= 100; $i++) {
            $operator = $operators[array_rand($operators)];
            $bus = Bus::create([
                'bus_name' => $operator . ' ' . $i,
                'coach_no' => 'GT-' . (1000 + $i),
                'bus_type' => $i % 2 == 0 ? 'ac' : 'non-ac',
            ]);

            $createdBuses[] = $bus;

            // Generate 40 seats (A1-A4, B1-B4, ..., J1-J4)
            $rows = range('A', 'J');
            foreach ($rows as $row) {
                for ($s = 1; $s <= 4; $s++) {
                    Seat::create([
                        'name' => $row . $s,
                        'bus_id' => $bus->id,
                    ]);
                }
            }
        }

        // 3. Generate Locations & Trips
        // We'll take around 40 districts from the list
        $destinations = array_slice($districts, 1, 40);

        foreach ($destinations as $district) {
            Location::create([
                'location_from' => 'Dhaka',
                'location_to' => $district,
            ]);

            // Create Morning and Night trips for each destination
            $bus1 = $createdBuses[array_rand($createdBuses)];
            $bus2 = $createdBuses[array_rand($createdBuses)];

            Trip::create([
                'location_from' => 'Dhaka',
                'location_to' => $district,
                'bus_id' => $bus1->id,
                'date' => now()->addDays(rand(1, 7)),
                'time' => 'Morning (08:00AM)',
                'fare' => rand(600, 1500),
            ]);

            Trip::create([
                'location_from' => 'Dhaka',
                'location_to' => $district,
                'bus_id' => $bus2->id,
                'date' => now()->addDays(rand(1, 7)),
                'time' => 'Night (09:00PM)',
                'fare' => rand(600, 1500),
            ]);
        }
    }
}
