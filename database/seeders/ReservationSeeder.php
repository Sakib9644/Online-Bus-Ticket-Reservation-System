<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Location;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        // Example: Create a route from Dhaka to all other districts
        foreach ($districts as $district) {
            if ($district !== 'Dhaka') {
                Location::create([
                    'location_from' => 'Dhaka',
                    'location_to' => $district,
                ]);
                $buses = Bus::all();
           foreach($buses as $key => $bus){

                 Trip::create([
                'location_from' => 'Dhaka',
                'location_to' => $district,
                'bus_id' => $bus->id,
                'date' => now(),
                'time' => 'Night (09:00PM)',
                'fare' => '100'+ $key,
            ]);

           }
            }
        }
}
    }
