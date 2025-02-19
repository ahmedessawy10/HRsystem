<?php

namespace App\Http\Controllers;

use App\Models\HrSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HrSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hrSetting = HrSetting::find(1);
        return view('appSettings.hrSetting.index', compact('hrSetting'));
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
        // dd($request);
        $request->validate([
            'discount' => 'numeric|required',
            'overtime' => 'numeric|required',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'holidays' => 'nullable|array',
            'holidays.*' => 'integer|in:0,1,2,3,4,5,6',
        ]);
        HrSetting::updateOrCreate([
            'id' => 1
        ], [
            'discount' => $request->discount,
            'overtime' => $request->overtime,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'holidays' => json_encode($request->holidays),
        ]);

        return redirect()->back()->with('success', __('update message'));
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
