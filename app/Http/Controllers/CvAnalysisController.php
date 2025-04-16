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
        // Parse PDF content
        $content = file_get_contents(storage_path("app/public/{$cv->path}"));
        
        // Build the prompt to send to the AI model
        $prompt = $this->buildPrompt($content);

        // Make request to AI service (Groq API)
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

        $data = $response->json();
        $resultText = $data['choices'][0]['message']['content'];

        // Process the response and update CV data
        $analysisResult = json_decode($resultText, true);
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
    }

<<<<<<< HEAD
    public function destroy(CvAnalysis $cvAnalysis)
    {
        try {
            // Delete the physical file first
            if (Storage::disk('public')->exists($cvAnalysis->file_path)) {
                Storage::disk('public')->delete($cvAnalysis->file_path);
            }

            // Delete the database record
            $cvAnalysis->delete();

            return redirect()
                ->route('cvs.index')
                ->with('success', 'CV deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('cvs.index')
                ->with('error', 'Failed to delete CV: ' . $e->getMessage());
        }
    }
}
=======
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
        return round((
            $analysisResult['skill_score'] +
            $analysisResult['education_score'] +
            $analysisResult['experience_years'] * 10 // Example weighting
        ) / 3);
    }
}
>>>>>>> 76648bc3219032719be35a468517b8a31a54407c
