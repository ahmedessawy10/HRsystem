<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Notifications;
use App\Models\CareerApplication;

class CareerApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careerApplications = CareerApplication::all();
        return view('career_applications.index', compact('careerApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('career_applications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'phone' => 'required|string|max:15',
            'cover_letter' => 'nullable|string',
        ]);

        $careerApplication = new CareerApplication($request->all());
        $careerApplication->save();

        User::role("hrManager")->get()->each(function ($user) use ($careerApplication) {

            event(new Notifications($user, "New application received for the position: " . $careerApplication->career->name . "." ));
        });

        return redirect()->route('career_applications.index')->with('success', 'Application submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CareerApplication $careerApplication)
    {
        return view('career_applications.show', compact('careerApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareerApplication $careerApplication)
    {
        return view('career_applications.edit', compact('careerApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CareerApplication $careerApplication)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'phone' => 'required|string|max:15',
            'cover_letter' => 'nullable|string',
        ]);

        $careerApplication->update($request->all());

        return redirect()->route('career_applications.index')->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerApplication $careerApplication)
    {
        //
    }
}
