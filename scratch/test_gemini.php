<?php
// scratch/test_gemini.php
$apiKey = 'AIzaSyD-Wljbbh9E30-XPno6tCHw_3slkto5-j4';
$prompt = "A high-quality natural landscape of Bogura, Bangladesh, showing ancient Mahasthangarh ruins, green hills, and tropical trees. Professional photography.";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => "Generate a detailed image prompt for a text-to-image AI for: " . $prompt]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
