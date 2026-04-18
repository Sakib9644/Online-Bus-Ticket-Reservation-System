<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name'=>'Admin',
                'phone'=>'01700000000',
                'email'=>'admin@gmail.com',
                'password'=>bcrypt('admin'),
                'role'=>'admin'
            ]
        );
        User::create(
            [
                'name'=>'Sadman Sakib',
                'phone'=>'01758459726',
                'email'=>'sakib@gmail.com',
                'password'=>bcrypt('12345'),
                'role'=>'user'
            ]
        );


    }
}
