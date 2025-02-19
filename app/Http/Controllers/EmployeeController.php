<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Display a list of employees
    public function index()
    {
        $employees = User::paginate(10); // Fetch all employees
        return view('employees.index', compact('employees'));
    }

    // Display the form to create a new employee
    public function create()
    {

        return view('employees.create');
    }

    // Store a new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fullname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'salary' => 'nullable|string',
            'join_date' => 'nullable|date',
            'leave_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'role' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,pending,leave',
            'gender' => 'nullable|in:male,female',
            'nationality_id' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'department_id' => 'nullable|integer',
            'job_position_id' => 'nullable|integer',
        ]);

        User::create($validatedData);

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
        return view('employees.edit', compact('employee'));
    }

    // Update an employee
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fullname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'salary' => 'nullable|string',
            'join_date' => 'nullable|date',
            'leave_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'role' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,pending,leave',
            'gender' => 'nullable|in:male,female',
            'nationality_id' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'department_id' => 'nullable|integer',
            'job_position_id' => 'nullable|integer',
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
