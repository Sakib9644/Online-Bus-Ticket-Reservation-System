<?php

use App\Models\City;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mappings = [
    'Dhaka' => 'dhaka.png',
    'Chattogram' => 'chittagong.png',
    'Rajshahi' => 'rajshahi.png',
    'Khulna' => 'khulna.png',
    'Barishal' => 'barishal.png',
    'Sylhet' => 'sylhet.png',
    'Rangpur' => 'rangpur.png',
    'Mymensingh' => 'mymensingh.png',
    'Cox\'s Bazar' => 'coxs_bazar.png',
    'Rangamati' => 'rangamati.png',
    'Bandarban' => 'bandarban.png',
    'Cumilla' => 'cumilla.png',
    'Bogura' => 'bogura.png',
    'Noakhali' => 'noakhali.png'
];

foreach ($mappings as $name => $img) {
    City::where('name', $name)->update(['image' => $img]);
    echo "Updated $name with $img\n";
}
