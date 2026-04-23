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
     * Generate keywords for a destination using Gemini or OpenAI fallback
     */
    public function generateKeywords($destination)
    {
        // Try Gemini first
        if ($this->apiKey) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey;
            $response = Http::post($url, [
                "contents" => [["parts" => [["text" => "Return a comma-separated list of 10 specific keywords for a real-world high-quality photograph representing the actual landscape and landmarks of {$destination}, Bangladesh. Focus on geographical authenticity. Return ONLY the words."]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
            
            if ($response->status() === 403) {
                Log::warning("Gemini API Key reported as LEAKED. Please update your GEMINI_API_KEY in .env.");
            }
        }

        // Fallback to OpenAI if Gemini fails
        $openaiKey = config('services.openai.key');
        if ($openaiKey) {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $openaiKey])
                ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-4o-mini",
                    "messages" => [["role" => "user", "content" => "List 10 comma-separated keywords for a realistic, non-artificial photograph of {$destination}, Bangladesh. Focus on actual geography."]]
                ]);
            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        }

        return "bangladesh,landscape,authentic,{$destination}";
    }

    /**
     * Generate a highly descriptive visual prompt for maximum realism
     */
    public function generateVisualDescription($destination)
    {
        $promptText = "Describe the authentic real-world geography, natural features, and actual landmarks of {$destination}, Bangladesh for a documentary photographer. Focus on realistic textures, honest representation, and genuine lighting conditions. Avoid any 'cinematic' or 'artistic' language. Describe the scene as it would look through a camera lens in real life. NO humans. 50 words.";

        if ($this->apiKey) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey;
            $response = Http::post($url, [
                "contents" => [["parts" => [["text" => $promptText]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
        }

        // Fallback to OpenAI
        $openaiKey = config('services.openai.key');
        if ($openaiKey) {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $openaiKey])
                ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-4o-mini",
                    "messages" => [["role" => "user", "content" => $promptText]]
                ]);
            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        }

        return "A realistic, high-resolution photograph of the natural landscape in {$destination}, Bangladesh, capturing authentic textures and natural sunlight.";
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
                        "prompt" => "A 100% authentic, unedited RAW photograph of {$destination}, Bangladesh. {$description}. Shot on 35mm film, documentary style, realistic natural lighting, authentic colors. This must look like a real-world photo taken by a traveler, NOT a digital render. Sharp details, natural atmospheric haze, NO vibrant filters, NO excessive saturation, NO CGI, NO digital art. National Geographic style."
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
     * Main method to generate an image URL or Base64
     */
    public function generateImage($destination)
    {
        // Try Gemini Imagen 3 first as requested
        $imagenData = $this->generateImagen3($destination);
        if ($imagenData) {
            return $imagenData;
        }

        // Fallback to DALL-E 3
        $description = $this->generateVisualDescription($destination);
        $openaiKey = config('services.openai.key');

        if ($openaiKey) {
            try {
                $response = Http::withHeaders(['Authorization' => 'Bearer ' . $openaiKey])
                    ->post("https://api.openai.com/v1/images/generations", [
                        "model" => "dall-e-3",
                        "prompt" => "An ultra-realistic, professional DSLR raw photograph of the natural landscape and city view of {$destination}, Bangladesh. {$description}. The image must look like a genuine, unprocessed photo taken with a high-end camera. Authentic natural colors, realistic textures, natural sunlight. NO digital art, NO CGI, NO 3D render, NO illustrations, NO filters. National Geographic documentary style.",
                        "n" => 1,
                        "size" => "1024x1024",
                        "quality" => "hd",
                        "style" => "natural"
                    ]);

                if ($response->successful()) {
                    return $response->json('data.0.url');
                }
                
                Log::error("DALL-E image generation failed: " . $response->body());
            } catch (\Exception $e) {
                Log::error("DALL-E Generation Error: " . $e->getMessage());
            }
        }

        // Final fallback
        $keywords = $this->generateKeywords($destination);
        $encodedKeywords = urlencode(str_replace(',', ' ', $keywords));
        return "https://loremflickr.com/1200/800/{$encodedKeywords}/all";
    }
}
