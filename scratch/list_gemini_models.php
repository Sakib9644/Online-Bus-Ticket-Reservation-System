<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = config('services.gemini.key');
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $key;
$response = Illuminate\Support\Facades\Http::get($url);
echo $response->body();
