<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Display a list of employees
    public function index()
    {
        $employees = User::role("employee")->paginate(10); // Fetch all employees
        return view('employees.index', compact('employees'));
    }

    // Display the form to create a new employee
    public function create()
    {
        $departments = Department::all();
        $job_positions = JobPosition::all();

        return view('employees.create', compact("departments", "job_positions"));
    }

    // Store a new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits_between:11,15',
            'address' => 'required|string',
            'salary' => 'required|string',
            'join_date' => 'required|date',
            'leave_date' => 'nullable|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required|in:active,inactive,pending,leave',
            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|digits:14',
            'birthdate' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(20)->toDateString()],
            'department_id' => 'required|integer',
            'job_position_id' => 'required|integer',
        ]);

        $validatedData['password'] = bcrypt('123456');
        $user = User::create($validatedData);


        $user->assignRole(["employee"]);
        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    // Display a single employee
    public function show($id)
    {
        $employee = User::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    // Display the form to edit an employee
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $departments = Department::all();
        $job_positions = JobPosition::all();
        return view('employees.edit', compact('employee', "departments", "job_positions"));
    }

    // Update an employee
    public function update(Request $request, $id)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|min:11',
            'address' => 'required|string',
            'salary' => 'required|string',
            'join_date' => 'required|date',
            'leave_date' => 'nullable|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'status' => 'required|in:active,inactive,pending,leave',
            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|numeric|min:14',
            'birthdate' => ['nullable', 'date', 'before_or_equal:' . Carbon::now()->subYears(20)->toDateString()],
            'department_id' => 'required|integer',
            'job_position_id' => 'required|integer',
        ]);

        $employee = User::findOrFail($id);
        $employee->update($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    // Delete an employee
    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
