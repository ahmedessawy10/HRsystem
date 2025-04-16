<?php

namespace App\Jobs;

use App\Models\User;
use Smalot\PdfParser\Parser;
use App\Events\Notifications;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnalyzeCVWithAI implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct(public $application) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cvPath = public_path('uploads/cvs/' . trim($this->application->cv));
        $extension = pathinfo($cvPath, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($cvPath);
            $cvText = $pdf->getText();
        } else {
            $cvText = file_get_contents($cvPath);
        }

        $truncatedCV = mb_substr($cvText, 0, 4000);
        $jobDescription = mb_substr($this->application->career->description, 0, 1000);
        $prompt = <<<EOD
        Analyze the following CV in comparison with the provided job description.
        
        CV:
        $truncatedCV
        
        Job Description:
        $jobDescription
        
        Please answer the following:
        1. Is the candidate a good fit?
        2. Give a score out of 100.
        3. Write a short justification (3-4 lines) why you gave this score.
        Only return in this format:
        
        Score: [number]/100
        Feedback: [short feedback]
        EOD;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'neversleep/noromaid-20b',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ]
        ]);

        $result = $response->json();
        $aiResponse = $result['choices'][0]['message']['content'] ?? null;

        if ($aiResponse) {
            preg_match('/Score:\s*(\d+)/', $aiResponse, $scoreMatch);
            preg_match('/Feedback:\s*(.+)/is', $aiResponse, $feedbackMatch);

            $this->application->ai_rate = $scoreMatch[1] ?? null;
            $this->application->ai_summary = $aiResponse;
            $this->application->save();
        }

        $application = $this->application;

        User::role("hrManager")->get()->each(function ($user) use ($application) {

            event(new Notifications($user, "New application received for the position: " . $application->career->name . "."));
        });
    }
}
