<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 40; $i++) {
            Seat::create([
                'name' => 'S'.$i,
                'bus_id' => 1,
            ]);
        }
        for($p = 1; $p <= 40; $p++) {
            Seat::create([
                'name' => 'A'.$p,
                'bus_id' => 3,
            ]);
        }
        for($i = 1; $i <= 40; $i++) {
            Seat::create([
                'name' => 'S'.$i,
                'bus_id' => 2,
            ]);
        }
        for($p = 1; $p <= 40; $p++) {
            Seat::create([
                'name' => 'A'.$p,
                'bus_id' => 4,
            ]);
        }

    }
}
