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
                "contents" => [["parts" => [["text" => "Return a comma-separated list of 10 specific keywords for a real-world high-quality photograph representing the actual historical landmarks, ancient architecture, and heritage sites of {$destination}, Bangladesh. Focus on historical authenticity. Return ONLY the words."]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
            
            if ($response->status() === 403) {
                Log::warning("Gemini API Key reported as LEAKED or Invalid. Please update your GEMINI_API_KEY in .env.");
            }
        }

        return "bangladesh,history,heritage,landmark,{$destination}";
    }

    /**
     * Generate a visual description focusing on a specific historical landmark
     */
    public function generateVisualDescription($destination)
    {
        $promptText = "First, identify the most famous historical landmark or ancient heritage site in the {$destination} district, Bangladesh. Then, provide a 50-word visual description of that specific place for a documentary photographer. Focus on its unique architectural features, weathered textures, and natural surroundings. Describe the scene as it would look through a camera lens in real life. NO humans. Return only the description.";

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
        if (!$this->apiKey) return null;

        $description = $this->generateVisualDescription($destination);
        $url = "https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-001:predict?key=" . $this->apiKey;

        try {
            $response = Http::timeout(60)->post($url, [
                "instances" => [
                    [
                        "prompt" => "A professional, high-resolution RAW photograph of the historical site in {$destination}, Bangladesh: {$description}. The image must capture the authentic architectural details, weathered surfaces, and natural environment of this specific landmark. Shot on 35mm film, documentary style, realistic natural lighting. NO digital art, NO vibrant filters, NO CGI, NO artificial saturation. National Geographic documentary photography."
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
        $encodedKeywords = urlencode(str_replace(',', ' ', $keywords));
        return "https://loremflickr.com/1200/800/{$encodedKeywords}/all";
    }
}
