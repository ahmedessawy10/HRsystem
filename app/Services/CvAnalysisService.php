<?php

namespace App\Services;

use App\Models\CvAnalysis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class CvAnalysisService
{
    protected string $apiKey;
    protected string $endpoint;
    protected string $model;

    protected array $skillKeywords = [
        'php', 'laravel', 'javascript', 'html', 'css', 'mysql',
        'python', 'java', 'react', 'angular', 'vue', 'node'
    ];

    protected array $softSkillKeywords = [
        'teamwork', 'communication', 'leadership', 'problem solving',
        'adaptability', 'time management', 'critical thinking'
    ];

    protected array $educationKeywords = [
        'bachelor', 'master', 'phd', 'degree', 'university',
        'diploma', 'certification', 'graduate'
    ];

    public function __construct()
    {
        $this->apiKey = config('groq.api_key') ?? throw new \RuntimeException('GROQ API key not configured');
        $this->endpoint = config('groq.endpoint');
        $this->model = config('groq.model');
    }

    public function analyze(CvAnalysis $cv)
    {
        try {
            $content = $this->extractText($cv->file_path);
            
            if (!$content) {
                throw new \Exception('Could not extract text from CV');
            }

            // Calculate all scores
            $experienceYears = $this->calculateExperienceYears($content);
            Log::debug('Experience calculation:', [
                'cv_id' => $cv->id,
                'years' => $experienceYears,
                'content_sample' => substr($content, 0, 200) // First 200 chars for context
            ]);
            $skillScore = $this->calculateScore($content, $this->skillKeywords);
            $softSkills = $this->calculateScore($content, $this->softSkillKeywords);
            $educationScore = $this->calculateScore($content, $this->educationKeywords);
            $relevantExperience = $this->calculateRelevantExperience($content);
            
            // Get summary using Hugging Face API
            $summary = $this->getSummary($content);

            return [
                'summary' => $summary,
                'experience_years' => $experienceYears,
                'skill_score' => $skillScore,
                'soft_skills' => $softSkills,
                'education_score' => $educationScore,
                'relevant_experience' => $relevantExperience,
                'fit_score' => $this->calculateFitScore([
                    'skill_score' => $skillScore,
                    'soft_skills' => $softSkills,
                    'education_score' => $educationScore,
                    'relevant_experience' => $relevantExperience
                ])
            ];
        } catch (\Exception $e) {
            Log::error('CV Analysis failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function extractText(string $filePath): string
    {
        $fullPath = storage_path('app/public/' . $filePath);
        $parser = new Parser();
        $pdf = $parser->parseFile($fullPath);
        return $pdf->getText();
    }

    protected function getSummary(string $text): string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a CV analysis expert. Provide a concise summary of the following CV text.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'max_tokens' => config('groq.max_tokens', 2048),
                'temperature' => config('groq.options.temperature', 0.7)
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['choices'][0]['message']['content'] ?? 'Summary not available';
            }

            Log::error('GROQ API Error:', ['response' => $response->json()]);
            return 'Error generating summary';
        } catch (\Exception $e) {
            Log::error('GROQ API Exception:', ['message' => $e->getMessage()]);
            return 'Error generating summary';
        }
    }

    protected function calculateExperienceYears(string $text): int
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a CV analysis expert. Extract the total years of experience from the following CV text. Respond with ONLY a number representing total years. If unclear, estimate based on work history.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'max_tokens' => 10,
                'temperature' => 0.3
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $years = (int) preg_replace('/[^0-9]/', '', $result['choices'][0]['message']['content']);
                return $years > 0 ? $years : 0;
            }

            return 0;
        } catch (\Exception $e) {
            Log::error('Experience calculation failed: ' . $e->getMessage());
            return 0;
        }
    }

    protected function calculateScore(string $text, array $keywords): int
    {
        $text = strtolower($text);
        $score = 0;
        
        foreach ($keywords as $keyword) {
            if (str_contains($text, strtolower($keyword))) {
                $score += 20;
            }
        }

        return min($score, 100);
    }

    protected function calculateRelevantExperience(string $text): int
    {
        $relevantKeywords = array_merge(
            $this->skillKeywords,
            ['developer', 'software', 'web', 'application', 'programming']
        );
        return $this->calculateScore($text, $relevantKeywords);
    }

    protected function calculateFitScore(array $scores): int
    {
        return (int) round(
            ($scores['skill_score'] * 0.4) +
            ($scores['soft_skills'] * 0.2) +
            ($scores['education_score'] * 0.2) +
            ($scores['relevant_experience'] * 0.2)
        );
    }

    protected function cleanContent(string $content): string
    {
        $content = str_replace("\xEF\xBB\xBF", '', $content);
        
        // Detect encoding from our list of supported encodings
        $detectedEncoding = mb_detect_encoding($content, $this->encodings, true);
        
        // If no valid encoding detected, default to ISO-8859-1
        if (!$detectedEncoding) {
            $detectedEncoding = 'ISO-8859-1';
        }

        // Convert to UTF-8
        $content = mb_convert_encoding($content, 'UTF-8', $detectedEncoding);

        // Remove invalid characters
        $content = preg_replace('/[\x00-\x1F\x7F]/u', '', $content);

        return $content;
    }
}
