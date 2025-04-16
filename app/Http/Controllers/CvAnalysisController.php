<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Support\Facades\Http;

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
            $content = file_get_contents(storage_path("app/public/{$cv->path}"));
            $prompt = $this->buildPrompt($content);

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
                \Log::error("AI API request failed", ['response' => $response->body()]);
                throw new \Exception('Groq API request failed.');
            }

            $data = $response->json();
            $resultText = $data['choices'][0]['message']['content'];
            $analysisResult = json_decode($resultText, true);

            if (!is_array($analysisResult)) {
                \Log::error("Failed to decode AI response", ['result' => $resultText]);
                throw new \Exception('Invalid AI response.');
            }

            $cv->update([
                'summary' => $analysisResult['summary'],
                'experience_years' => $analysisResult['experience_years'],
                'skill_score' => $analysisResult['skill_score'],
                'soft_skills' => implode(', ', $analysisResult['soft_skills']),
                'education_score' => $analysisResult['education_score'],
                'relevant_experience' => implode(', ', $analysisResult['relevant_experience']),
                'fit_score' => $this->calculateFitScore($analysisResult),
                'status' => 'completed',
                'analysis_result' => $analysisResult,
            ]);
        } catch (\Throwable $e) {
            \Log::error("CV analysis failed: {$e->getMessage()}", ['exception' => $e]);
            $cv->update(['status' => 'failed']);
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
        - fit_score (a general fit score for the job)\n\nCV Content:\n{$content}";
    }

    private function calculateFitScore(array $analysisResult): int
    {
        return round((
            $analysisResult['skill_score'] +
            $analysisResult['education_score'] +
            $analysisResult['experience_years'] * 10
        ) / 3);
    }
}