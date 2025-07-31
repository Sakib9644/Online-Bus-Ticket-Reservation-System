<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bus::create(
            [
                'bus_name'=>'Super Delux',
                'bus_no' => '123456',
                'bus_type' => 'ac',
            ]
        );
        Bus::create(
            [
                'bus_name'=>'Google Delux',
                'bus_no' => '134565',
                'bus_type' => 'ac',
            ]
        );
        Bus::create(
            [
                'bus_name'=>'Facebook Delux',
                'bus_no' => '546454',
                'bus_type' => 'non-ac',
            ]
        );
        Bus::create(
            [
                'bus_name'=>'Insagram Delux',
                'bus_no' => '323232',
                'bus_type' => 'non-ac',
            ]
        );

    }
}
