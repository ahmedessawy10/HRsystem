<?php
// app/Http/Controllers/HolidayController.php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the holidays.
     */
    public function index()
    {
        // $holidays = Holiday::orderBy('date', 'asc')->get();
        $holidays = Holiday::orderBy('date', 'asc')->paginate(5);
        return view('holidays.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new holiday.
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store a newly created holiday in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'occation' => 'required|string|max:255',
            'date'     => 'required|date',
        ]);

        Holiday::create($validated);

        return redirect()->route('holiday.index')->with('success', 'Holiday created successfully.');
    }

    /**
     * Show the form for editing the specified holiday.
     */
    public function edit(Holiday $holiday)
    {
        return view('holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified holiday in storage.
     */
    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate([
            'occation' => 'required|string|max:255',
            'date'     => 'required|date',
        ]);

        $holiday->update($validated);

        return redirect()->route('holiday.index')->with('success', 'Holiday updated successfully.');
    }

    /**
     * Remove the specified holiday from storage.
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('holiday.index')->with('success', 'Holiday deleted successfully.');
    }

    /**
     * Copy (duplicate) the specified holiday.
     */
    public function copy(Holiday $holiday)
    {
        $newHoliday = $holiday->replicate();
        $newHoliday->occation = $holiday->occation . ' (Copy)';
        $newHoliday->save();

        return redirect()->route('holiday.index')->with('success', 'Holiday copied successfully.');
    }

    /**
     * Display a calendar view of holidays.
     */
    public function calendar()
    {
        // $holidays = Holiday::all();
        $holidays = Holiday::paginate(5); 
        return view('holidays.calendar', compact('holidays'));
    }

    /**
     * Display holiday reports.
     */
    public function report()
    {
        $holidays = Holiday::all();
        return view('holidays.report', compact('holidays'));
    }
}
