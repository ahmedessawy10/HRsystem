<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')->latest('date')->paginate();
        
        // Only use event, don't send notification directly
        event(new Notifications(Auth::user(), "You have a new message!"));
        
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $users = User::role('employee')->select('id', 'fullname')->get();
        return view('attendance.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date|unique:attendances,date,NULL,id,user_id,' . $request->user_id,
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            // 'late_minutes' => 'required|integer',
            // 'extra_minutes' => 'required|integer',
        ]);

        // $data = $request->validated();

        $user = User::find($request->user_id);



        if ($request->time_in) {
            $startTime = Carbon::parse($user->start_time);
            $timeIn = Carbon::parse($request->time_in);
            $delay = $timeIn->greaterThan($startTime) ? $timeIn->diffInMinutes($startTime) / 60 : 0;
            $data['late_hours'] = abs($delay);
        }
        if ($request->time_out) {
            $endTime = Carbon::parse($user->end_time);
            $timeOut = Carbon::parse($request->time_out);
            $extra = $timeOut->greaterThan($endTime) ? $timeOut->diffInMinutes($endTime) / 60 : 0;
            $data['extra_hours'] = abs($extra);
        }
        Attendance::create($data);

        return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully.');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            // 'late_minutes' => 'required|integer',
            // 'extra_minutes' => 'required|integer',
        ]);
        $attendance = Attendance::findOrFail($id);
        $user = User::find($attendance->user_id);

        if ($request->time_in) {
            $startTime = Carbon::parse($user->start_time);
            $timeIn = Carbon::parse($request->time_in);
            $delay = $timeIn->greaterThan($startTime) ? $timeIn->diffInMinutes($startTime) / 60 : 0;
            $attendance['time_in'] = $request->time_in;
            $attendance['late_hours'] = abs($delay);
        }
        if ($request->time_out) {
            $endTime = Carbon::parse($user->end_time);
            $timeOut = Carbon::parse($request->time_out);
            $extra = $timeOut->greaterThan($endTime) ? $timeOut->diffInMinutes($endTime) / 60 : 0;
            $attendance['time_out'] = $request->time_out;
            $attendance['extra_hours'] = abs($extra);
        }

        // dd($attendance);
        $attendance->save();
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully');
    }
}
