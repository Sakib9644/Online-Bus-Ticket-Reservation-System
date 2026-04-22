<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }

    public function generateImagePrompt($destination)
    {
        if (empty($this->apiKey)) {
            Log::error("OpenAI API Key is missing. Check your services.php config.");
            return "";
        }

        try {
            // STEP 1: Use GPT-4o-mini as a "Research Agent" to describe the real geography
            $researchResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("https://api.openai.com/v1/chat/completions", [
                "model" => "gpt-4o-mini",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a geography expert specialized in Bangladesh's natural landscape."
                    ],
                    [
                        "role" => "user",
                        "content" => "Describe the specific real-world natural environment of {$destination}, Bangladesh. Focus on its unique geographical features (e.g., specific rivers, types of forests, hill formations, or wetlands). Provide a detailed visual description for a professional photographer to recreate this scene. Do NOT include humans or buildings."
                    ]
                ]
            ]);

            $visualDescription = "natural landscape of {$destination}, Bangladesh";
            if ($researchResponse->successful()) {
                $visualDescription = $researchResponse->json('choices.0.message.content');
            }

            // STEP 2: Feed that specific "Research" into DALL-E 3 for generation
            $imageResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("https://api.openai.com/v1/images/generations", [
                "model" => "dall-e-3",
                "prompt" => "A real, high-quality, professional natural landscape photograph of {$destination}, Bangladesh. The image must look like a real photo taken with a DSLR camera, NOT an illustration, NOT digital art, and NOT a painting. Focus on the actual geographical features: {$visualDescription}. NO humans, NO people, NO artificial buildings. Cinematic lighting, realistic textures, 8k resolution, National Geographic style.",
                "n" => 1,
                "size" => "1024x1024",
                "quality" => "hd",
                "style" => "natural"
            ]);

            if ($imageResponse->successful()) {
                return $imageResponse->json('data.0.url');
            }

            Log::error("DALL-E Generation Failed: " . $imageResponse->body());
        } catch (\Exception $e) {
            Log::error("OpenAI Service Error: " . $e->getMessage());
        }

        return "";
    }
}
