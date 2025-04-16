<?php
namespace App\Http\Controllers;

use App\Models\Cv;
use App\Services\CvAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CvController extends Controller
{
    protected $cvAnalysisService;

    public function __construct(CvAnalysisService $cvAnalysisService)
    {
        $this->cvAnalysisService = $cvAnalysisService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:10240', // 10MB max size
        ]);

        $file = $request->file('cv');
        $path = $file->storeAs('public/cvs', $file->getClientOriginalName());

        $cv = Cv::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'status' => 'pending', // initially pending for analysis
        ]);

        $this->cvAnalysisService->analyze($cv);

        return redirect()->route('cvs.index')->with('status', 'CV uploaded and analysis started');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf|max:10240'
        ]);

        $file = $request->file('cv_file');
        $path = $file->store('cvs', 'public'); // This stores in storage/app/public/cvs

        $cv = Cv::create([
            'file_name' => $file->getClientOriginalName(),
            'path' => $path,
            // ...other fields...
        ]);

        return redirect()->route('cvs.index');
    }

    public function index()
    {
        $cvs = Cv::latest()->get();
        
        // Debug output
        \Log::info('CV Count: ' . $cvs->count());
        \Log::info('CVs:', $cvs->toArray());
        
        return view('cv.index', compact('cvs'));
    }

    public function destroy(Cv $cv)
    {
        try {
            // Check if analysis is in progress
            if ($cv->status === 'processing') {
                return redirect()
                    ->route('cvs.index')
                    ->with('error', 'Cannot delete CV while analysis is in progress');
            }

            if (Storage::disk('public')->exists($cv->path)) {
                Storage::disk('public')->delete($cv->path);
            }

            $analysisPath = 'analyses/' . basename($cv->path, '.pdf') . '_analysis.json';
            if (Storage::disk('public')->exists($analysisPath)) {
                Storage::disk('public')->delete($analysisPath);
            }

            // Log deletion for audit
            \Log::info('Deleting CV:', [
                'id' => $cv->id,
                'file_name' => $cv->file_name,
                'path' => $cv->path
            ]);

            $cv->delete();

            return redirect()
                ->route('cvs.index')
                ->with('success', 'CV and associated analysis data deleted successfully');
        } catch (\Exception $e) {
            \Log::error('CV deletion failed:', [
                'cv_id' => $cv->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('cvs.index')
                ->with('error', 'Failed to delete CV: ' . $e->getMessage());
        }
    }
}
