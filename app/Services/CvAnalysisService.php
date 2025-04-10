<?php

namespace App\Services;

use App\Models\CvAnalysis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class CvAnalysisService
{
    protected string $apiKey;
    protected string $apiUrl;

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
        $this->apiKey = config('services.huggingface.api_key');
        $this->apiUrl = config('services.huggingface.api_url');
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
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post('https://api-inference.huggingface.co/models/facebook/bart-large-cnn', [
            'inputs' => $text,
            'parameters' => [
                'max_length' => 300,
                'min_length' => 100,
            ]
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return $result[0]['summary_text'] ?? 'Summary not available';
        }

        return 'Error generating summary';
    }

    protected function calculateExperienceYears(string $text): int
    {
        preg_match_all('/(\d+)\s*(?:year|yr)s?\s+(?:of\s+)?experience/', 
            strtolower($text), 
            $matches
        );

        if (!empty($matches[1])) {
            return max(array_map('intval', $matches[1]));
        }

        return 0;
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
        // Remove BOM if present
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