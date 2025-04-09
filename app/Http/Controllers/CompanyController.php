<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all companies from the database
        $company = Company::find(1);

        // Return a view with the list of companies
        return view('appSettings.app.company', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "name" => ["required", "string"],
            "phone" => ["required", "string"],
            "address" => ["required", "string"],
            "email" => ["required", "email"],
            "latitude" => ["required", "string"],
            "longitude" => ["required", "string"],
            "radius" => ["required", "string"],
            "city" => ["required", "string"],

        ]);


        // dd($request);
        Company::updateOrCreate(
            [
                'id' => 1
            ],
            [

                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "email" => $request->email,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
                "radius" => $request->radius,
                "city" => $request->city,
            ]
        );

        return redirect()->back()->with("success", __("app.update_success"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
