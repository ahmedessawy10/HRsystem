<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')->paginate();
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $users = User::all(['id', 'fullname']);
        return view('attendance.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'late_minutes' => 'required|integer',
            'extra_minutes' => 'required|integer',
        ]);


        Attendance::create([
            'user_id' => $request->user,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'late_minutes' => $request->late_minutes,
            'extra_minutes' => $request->extra_minutes,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully.');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully');
    }
}
