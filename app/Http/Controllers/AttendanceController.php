<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    private $officialTimeIn = '08:00:00'; // Official check-in time
    private $officialTimeOut = '17:00:00'; // Official check-out time

    // Show attendance records for the current user
    public function index()
    {
        $userId = Auth::id();
        $attendances = Attendance::where('user_id', $userId)->orderBy('date', 'desc')->get();

        return view('attendance.index', compact('attendances'));
    }

    // Check-in
    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Check if the user has already checked in today
        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if (!$attendance) {
            // Create a new attendance record
            $attendance = Attendance::create([
                'user_id' => $userId,
                'date' => $today,
                'time_in' => $currentTime,
                'late_minutes' => 0, // Will be updated later
                'extra_minutes' => 0,
            ]);

            // Update late minutes
            $attendance->late_minutes = $attendance->calculateLateMinutes($this->officialTimeIn);
            $attendance->save();

            return redirect()->back()->with('success', 'Check-in recorded successfully!');
        }

        return redirect()->back()->with('error', 'You have already checked in today.');
    }

    // Check-out
    public function checkOut()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if ($attendance && !$attendance->time_out) {
            $attendance->time_out = $currentTime;
            $attendance->extra_minutes = $attendance->calculateExtraMinutes($this->officialTimeOut);
            $attendance->save();

            return redirect()->back()->with('success', 'Check-out recorded successfully!');
        }

        return redirect()->back()->with('error', 'You haven’t checked in today or have already checked out.');
    }
}
