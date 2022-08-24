<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create(
            [
                'name'=>'Dhaka',
            ]
        );
        City::create(
            [
                'name'=>'Khulna',
            ]
        );
        City::create(
            [
                'name'=>'Jessore',
            ]
        );
        City::create(
            [
                'name'=>'Satkhira',
            ]
        );
        City::create(
            [
                'name'=>'Mymenshingh',
            ]
        );
        City::create(
            [
                'name'=>'Chittagong',
            ]
        );
        City::create(
            [
                'name'=>'Coxs Bazar',
            ]
        );

    }
}