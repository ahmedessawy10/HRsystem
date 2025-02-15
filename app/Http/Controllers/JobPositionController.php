<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosition;
use App\Models\Department;
use App\Models\Employee; // إضافة نموذج الموظف

class JobPositionController extends Controller
{
    public function index()
    {
        $jobpositions = JobPosition::with('department')->get();
        $departments=Department::all();
        return view('job_positions.index', compact('jobpositions','departments'));
    }

    /**
     * ✅ جلب جميع الموظفين بناءً على القسم المحدد
     */
    public function getEmployeesByDepartment(Request $request)
    {
        $employees = Employee::where('department_id', $request->department_id)->get();
        return response()->json($employees);
    }

    /**
     * ✅ إضافة أو تحديث مسمى وظيفي لموظف معين
     */
    public function updateJobPosition(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'job_position' => 'nullable|string|max:255',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $employee->job_position = $request->job_position;
        $employee->save();

        return response()->json(['message' => 'تم تحديث المسمى الوظيفي بنجاح!']);
    }

    /**
     * ✅ حذف المسمى الوظيفي لموظف معين
     */
    public function deleteJobPosition(Request $request)
    {
        $employee = Employee::findOrFail($request->employee_id);
        $employee->job_position = null;
        $employee->save();

        return response()->json(['message' => 'تم حذف المسمى الوظيفي بنجاح!']);
    }
}
