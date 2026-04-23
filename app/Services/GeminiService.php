<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    /**
     * Generate keywords for a destination focusing on historical significance
     */
    public function generateKeywords($destination)
    {
        if ($this->apiKey) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey;
            $response = Http::post($url, [
                "contents" => [["parts" => [["text" => "Return a comma-separated list of 10 specific keywords for a real-world high-quality photograph representing the actual ancient architecture, palaces (Rajbari), Zamindar Bari, and historical monuments of the {$destination} district, Bangladesh. Focus on historical buildings and ruins. Return ONLY the words."]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }

            if ($response->status() === 403) {
                Log::warning("Gemini API Key reported as LEAKED or Invalid. Please update your GEMINI_API_KEY in .env.");
            }
        }

        return "bangladesh,heritage,architecture,ancient,landmark,{$destination}";
    }

    /**
     * Generate a visual description focusing on a specific historical landmark
     */
    public function generateVisualDescription($destination)
    {
        $promptText = "Identify a specific, world-famous historical monument in {$destination}, Bangladesh (e.g., Lalbagh Fort, Ahsan Manzil, Sixty Dome Mosque). Provide a 50-word visual description focusing ENTIRELY on its ancient Mughal or Colonial architecture, red brickwork, ornate domes, and historical grandeur. ABSOLUTELY NO modern apartment buildings, NO generic city streets, NO modern canals, and NO modern vehicles. The image must look like a National Geographic heritage feature. NO humans. Return only the description.";

        if ($this->apiKey) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey;
            $response = Http::post($url, [
                "contents" => [["parts" => [["text" => $promptText]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
        }

        return "A realistic, high-resolution photograph of a major historical landmark in the {$destination} district, Bangladesh, capturing ancient textures and natural sunlight.";
    }

    /**
     * Generate an image using Gemini Imagen 3
     */
    public function generateImagen3($destination)
    {
        if (!$this->apiKey)
            return null;

        $description = $this->generateVisualDescription($destination);
        $url = "https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-001:predict?key=" . $this->apiKey;

        try {
            $response = Http::timeout(60)->post($url, [
                "instances" => [
                    [
                        "prompt" => "A majestic RAW photograph of the specific historical monument in {$destination}, Bangladesh: {$description}. FOCUS: Ancient Mughal architecture, ornate red bricks, domes, and heritage masonry. FORBIDDEN: No modern buildings, No apartments, No skyscrapers, No generic streets, No modern trash, No modern boats, No modern vehicles. This must be a clean, professional heritage site photograph. Shot on 35mm film, realistic natural lighting. National Geographic style."
                    ]
                ],
                "parameters" => [
                    "sampleCount" => 1,
                    "aspectRatio" => "1:1"
                ]
            ]);

            if ($response->successful()) {
                $base64 = $response->json('predictions.0.bytesBase64Encoded');
                if ($base64) {
                    return 'data:' . $response->json('predictions.0.mimeType', 'image/png') . ';base64,' . $base64;
                }
            }

            Log::error("Gemini Imagen 3 failed: " . $response->body());
        } catch (\Exception $e) {
            Log::error("Gemini Imagen 3 Error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Main method to generate an image URL or Base64 (Exclusively Gemini)
     */
    public function generateImage($destination)
    {
        // Use Gemini Imagen 3 as requested
        $imagenData = $this->generateImagen3($destination);
        if ($imagenData) {
            return $imagenData;
        }

        // Final fallback to a generic search if Gemini fails (No OpenAI)
        $keywords = $this->generateKeywords($destination);
        $safeKeywords = "bangladesh," . str_replace(',', ',bangladesh,', $keywords);
        $encodedKeywords = urlencode(str_replace(',', ' ', $safeKeywords));
        return "https://loremflickr.com/1200/800/{$encodedKeywords}/all";
    }
}
