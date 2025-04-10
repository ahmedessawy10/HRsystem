<?php

namespace App\Http\Controllers;

use App\Models\CvAnalysis;
use Illuminate\Http\Request;
use App\Services\CvAnalysisService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Jobs\AnalyzeCvJob;

class CvAnalysisController extends Controller
{
    protected $cvAnalysisService;

    public function __construct(CvAnalysisService $cvAnalysisService)
    {
        $this->cvAnalysisService = $cvAnalysisService;
    }

    public function index()
    {
        $cvs = CvAnalysis::latest()->paginate(10);
        return view('cv.index', compact('cvs'));
    }

    public function create()
    {
        return view('cv.create');
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function showUploadForm()
    {
        $cvs = CvAnalysis::latest()->paginate(10);
        return view('cv.upload', compact('cvs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

        try {
            $file = $request->file('cv_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('cvs', $fileName, 'public');

            $analysis = CvAnalysis::create([
                'user_id' => auth()->id(),
                'file_name' => $fileName,  
                'file_path' => $filePath,  
                'status' => 'processing'
            ]);

            // Queue the analysis job
            dispatch(new \App\Jobs\AnalyzeCvJob($analysis));

            return redirect()->route('cv-analysis.index')
                ->with('success', 'CV uploaded successfully and analysis started.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error uploading CV: ' . $e->getMessage());
        }
    }

    /**
     * Analyze uploaded CV file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyze(Request $request)
    {
        Log::info('Starting CV analysis', ['request' => $request->all()]);

        $request->validate([
            'cv_file' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

        try {
            // Check if file exists
            if (!$request->hasFile('cv_file') || !$request->file('cv_file')->isValid()) {
                throw new \Exception('Invalid file upload');
            }

            $file = $request->file('cv_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('cvs', $fileName, 'public');

            // Create CV record
            $cv = CvAnalysis::create([
                'user_id' => auth()->id(),
                'file_name' => $fileName,
                'file_path' => $filePath,
                'status' => 'processing'
            ]);

            // Pass the model instance directly
            dispatch(new AnalyzeCvJob($cv));

            return response()->json([
                'success' => true,
                'message' => 'CV uploaded and queued for analysis',
                'data' => $cv
            ]);

        } catch (\Exception $e) {
            Log::error('CV Analysis failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error analyzing CV: ' . $e->getMessage()
            ], 500);
        }
    }
}