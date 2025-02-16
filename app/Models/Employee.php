<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch all employees from the users table
        $employees = User::all();

        // Pass the data to the view
        return view('employees.index', compact('employees'));
    }

    public function show($id)
    {
        // Fetch a single employee by ID
        $employee = User::findOrFail($id);

        // Pass the data to the view
        return view('employees.show', compact('employee'));
    }
}
