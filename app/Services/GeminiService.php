<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function generateImagePrompt($destination)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey;

        $response = Http::post($url, [
            "contents" => [
                [
                    "parts" => [
                        ["text" => "Return a comma-separated list of 10 specific keywords for a high-quality photo representing the heritage, culture, and famous landmarks of {$destination}, Bangladesh. Include historical sites, traditional architecture, cultural monuments, and local heritage spots. Avoid general nature/flowers; focus on cultural and historical significance. Return ONLY the comma-separated words, no other text."]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text');
        }

        return "bangladesh,nature,landscape,{$destination}";
    }
}
