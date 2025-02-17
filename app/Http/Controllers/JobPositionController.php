<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosition;
use App\Models\Department;
use App\Models\Employee;

class JobPositionController extends Controller
{
    public function index()
    {
        $jobpositions = JobPosition::with('department')->get();
        $departments = Department::all();
        return view('job_positions.index', compact('jobpositions', 'departments'));
    }
    public function create()
    {
        return view('job_positions.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);
    
        JobPosition::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);
    
        return response()->json(['message' => 'تمت إضافة الوظيفة بنجاح!']);
    }
    
    

    public function edit($id)
    {
        $jobPosition = JobPosition::findOrFail($id);
        return response()->json($jobPosition);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);
    
        $jobPosition = JobPosition::findOrFail($id);
        $jobPosition->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);
    
        return response()->json(['message' => 'تم تعديل الوظيفة بنجاح!']);
    }
    
    
    public function destroy($id)
    {
        JobPosition::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'تم حذف المسمى الوظيفي بنجاح');
    }
}
