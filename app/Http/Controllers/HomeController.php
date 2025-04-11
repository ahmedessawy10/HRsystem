<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Events\Notifications;
use App\Jobs\AnalyzeCVWithAI;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function home()
    {
        return view("front-pages.index");
    }

    public function careers()
    {
        $careers = Career::where("status", "open")->with("department")->get();
        return view("front-pages.careers", compact("careers"));
    }

    public function showCareer($id)
    {
        $career = Career::with(['department', "applications"])->where('id', $id)->firstOrFail();
        return view("front-pages.career-details", compact("career"));
    }

    public function applyCareer(Request $request, $id)
    {

        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "cv" => "required|file|mimes:pdf,doc,docx|max:2048",
            "phone" => "required|string",
            "cover_letter" => "nullable|string",
        ]);



        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvs'), $filename);
            $data['cv'] = ' ' . $filename;
        }
        $data['career_id'] = $id;
        $data['status'] = "pending";
        $data['ai_rate'] = null;
        $data['ai_summary'] = null;
        $application = CareerApplication::create($data);
        AnalyzeCVWithAI::dispatch($application);

        return redirect()->back()->with("success", "Application submitted successfully. and we will notify you soon.");
    }
    public function notify()
    {
        event(new Notifications(Auth::user(), "You have a new message!"));
    }
}
