<?php

namespace App\Jobs;

use App\Models\CvAnalysis;
use App\Services\CvAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeCvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected CvAnalysis $cv;

    public function __construct(CvAnalysis $cv)
    {
        $this->cv = $cv;
    }

    public function handle(CvAnalysisService $cvAnalysisService)
    {
        try {
            $result = $cvAnalysisService->analyze($this->cv);
            
            $this->cv->update([
                'status' => 'completed',
                'analysis_result' => $result,
                'summary' => $result['summary'] ?? null,
                'experience_years' => $result['experience_years'] ?? 0,
                'skill_score' => $result['skill_score'] ?? 0,
                'soft_skills' => $result['soft_skills'] ?? 0,
                'education_score' => $result['education_score'] ?? 0,
                'relevant_experience' => $result['relevant_experience'] ?? 0
            ]);

            $this->cv->calculateFitScore();

        } catch (\Exception $e) {
            $this->cv->update(['status' => 'failed']);
            throw $e;
        }
    }
}