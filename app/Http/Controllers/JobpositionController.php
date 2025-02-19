<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobpositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobpositions = JobPosition::with('department')->orderBy('updated_at', 'desc')->paginate(5);
        return view('appSettings.jobposition.index', compact('jobpositions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $departments = Department::all();
        return view('appSettings.jobposition.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'department_id' => "exists:departments,id|required",
            'name' => "required|unique:job_positions,name",
        ]);

        JobPosition::create($request->all());

        return redirect()->route('jobpositions.index')->with('success', __('app.create message'));
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
        $departments = Department::all();
        $job = JobPosition::find($id);
        return view('appSettings.jobposition.edit', compact('departments', 'job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'department_id' => "exists:departments,id|required",
            'name' => "required|unique:job_positions,name," . $id,
        ]);

        JobPosition::find($id)->update($request->all());
        return redirect()->route('jobpositions.index')->with('success', __('app.update message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        JobPosition::find($id)->destroy($id);
        return redirect()->route('jobpositions.index')->with('success', __('app.delete message'));
    }
}
