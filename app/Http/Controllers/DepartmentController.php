<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
                         ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit($id)
{
    $department = Department::findOrFail($id);
    return response()->json($department); // لإرجاع البيانات إلى الـ Modal
}

public function update(Request $request, $id)
{
    $request->validate(['name' => 'required|unique:departments,name,'.$id]);

    $department = Department::findOrFail($id);
    $department->update($request->all());

    return redirect()->back()->with('success', 'تم تحديث القسم بنجاح');
}


public function destroy($id)
{
    Department::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'تم حذف القسم بنجاح');
}
}
