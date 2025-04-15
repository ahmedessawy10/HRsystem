<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate(5);
        return view('appSettings.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appSettings.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {

        $request->validate([
            'name' => 'unique:departments,name'
        ]);


        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'create department successfully');
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
    public function edit($id)
    {

        $dep = Department::find($id);
        return  view('appSettings.departments.edit', compact('dep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $id,
        ]);

        Department::find($id)->update($request->all());

        return redirect()->route('departments.index')->with('success', 'edit department successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Department::destroy($id);

        return  redirect()->route('departments.index')->with('success', 'deleted successfully');
    }
}
