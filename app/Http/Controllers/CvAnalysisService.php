<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CvAnalysisService
{
    protected $apiKey;
    protected $endpoint;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
        $this->endpoint = env('GROQ_ENDPOINT');
        $this->model = env('GROQ_MODEL');
    }

    public function analyze(Cv $cv)
    {
        try {
            Log::info("Starting analysis for CV ID: {$cv->id}");

            // Parse PDF content
            $contentPath = storage_path("app/public/{$cv->path}");

            if (!file_exists($contentPath)) {
                Log::error("CV file not found at path: {$contentPath}");
                return;
            }

            $content = file_get_contents($contentPath);

            // Build prompt
            $prompt = $this->buildPrompt($content);

            // Make request to Groq AI API
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.2
            ]);

            if (!$response->successful()) {
                Log::error("AI request failed for CV ID: {$cv->id}. Status: {$response->status()}", [
                    'response' => $response->body()
                ]);
                return;
            }

            $data = $response->json();
            $resultText = $data['choices'][0]['message']['content'] ?? null;

            if (!$resultText) {
                Log::error("Missing 'content' in AI response for CV ID: {$cv->id}", [
                    'response' => $data
                ]);
                return;
            }

            $analysisResult = json_decode($resultText, true);
            if (!is_array($analysisResult)) {
                Log::error("Failed to decode JSON response for CV ID: {$cv->id}", [
                    'resultText' => $resultText
                ]);
                return;
            }

            // Safe type checks before implode
            $softSkills = is_array($analysisResult['soft_skills'] ?? null) ? implode(', ', $analysisResult['soft_skills']) : null;
            $relevantExperience = is_array($analysisResult['relevant_experience'] ?? null) ? implode(', ', $analysisResult['relevant_experience']) : null;

            // Update the CV with analysis results
            $cv->update([
                'summary' => $analysisResult['summary'] ?? null,
                'experience_years' => $analysisResult['experience_years'] ?? null,
                'skill_score' => $analysisResult['skill_score'] ?? null,
                'soft_skills' => $softSkills,
                'education_score' => $analysisResult['education_score'] ?? null,
                'relevant_experience' => $relevantExperience,
                'fit_score' => $this->calculateFitScore($analysisResult),
                'status' => 'completed',
                'analysis_result' => $analysisResult,
            ]);

            Log::info("Analysis completed successfully for CV ID: {$cv->id}");

        } catch (\Throwable $e) {
            Log::error("Exception during CV analysis for ID: {$cv->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function buildPrompt($content)
    {
        return "Please analyze the following CV content and return a JSON structure with the following fields:
        - summary (short summary of the CV)
        - experience_years (calculated experience years from the CV)
        - skill_score (score for technical skills)
        - soft_skills (list of soft skills mentioned)
        - education_score (score for education level)
        - relevant_experience (list of relevant experience mentioned)
        - fit_score (a general fit score for the job)
        
        CV Content:
        {$content}";
    }

    private function calculateFitScore(array $analysisResult): int
    {
        $skillScore = $analysisResult['skill_score'] ?? 0;
        $educationScore = $analysisResult['education_score'] ?? 0;
        $experienceYears = $analysisResult['experience_years'] ?? 0;

        return round((
            $skillScore +
            $educationScore +
            $experienceYears * 10 // weight for experience
        ) / 3);
    }
}
