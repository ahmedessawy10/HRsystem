<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Department;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::with('department')->get();
        return view('careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('careers.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'required|string',
            'status' => 'required|in:open,close',
        ]);

        Career::create($request->all());

        return redirect()->route('careers.index')->with('success', 'Career created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $career = Career::with(['department', "applications"])->where('id', $id)->firstOrFail();


        return view('careers.show', compact('career'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
        $departments = Department::all();
        return view('careers.edit', compact('career', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'required|string',
            'status' => 'required|in:open,close',
        ]);

        $career->update($request->all());

        return redirect()->route('careers.index')->with('success', 'Career updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()->route('careers.index')->with('success', 'Career deleted successfully.');
    }
}
