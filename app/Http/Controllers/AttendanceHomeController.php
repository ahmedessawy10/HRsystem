<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceHomeController extends Controller
{
    private $officialTimeIn = '08:00:00';
    private $officialTimeOut = '17:00:00';

    /**
     * Calculate the distance (in meters) between two coordinates using the Haversine formula.
     *
     * @param float $lat1 User latitude.
     * @param float $lng1 User longitude.
     * @param float $lat2 Company latitude.
     * @param float $lng2 Company longitude.
     * @return float Distance in meters.
     */
    protected function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000;
        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    /**
     * Verify that the user's location is within the company's allowed radius.
     *
     * @param Request $request
     * @return bool|string Returns true if within location, or an error message.
     */
    protected function verifyLocation(Request $request)
    {

        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');

        if (!$userLatitude || !$userLongitude) {
            return "Location data is missing.";
        }

        $company = Company::first();
        if (!$company) {
            return "Company location is not configured.";
        }

        $distance = $this->calculateDistance($userLatitude, $userLongitude, $company->latitude, $company->longitude);

        if ($distance > $company->radius) {
            return "You are not within the allowed company location.";
        }

        return true;
    }

    public function index()
    {
        $userId = Auth::id();
        $attendances = Attendance::where('user_id', Auth::id())->orderBy("date", "desc")->paginate(5);

        return view('attendance_home.index', compact('attendances'));
    }


    public function checkIn(Request $request)
    {

        $locationCheck = $this->verifyLocation($request);
        if ($locationCheck !== true) {
            return redirect()->back()->with('error', $locationCheck);
        }

        $userId = Auth::id();
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();


        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if (!$attendance) {

            $attendance = Attendance::create([
                'user_id'       => $userId,
                'date'          => $today,
                'time_in'       => $currentTime,
                'late_minutes'  => 0,
                'extra_minutes' => 0,
            ]);


            $attendance->late_minutes = $attendance->calculateLateMinutes($this->officialTimeIn);
            $attendance->save();

            return redirect()->back()->with('success', 'Check-in recorded successfully!');
        }

        return redirect()->back()->with('error', 'You have already checked in today.');
    }

    public function checkOut(Request $request)
    {

        $locationCheck = $this->verifyLocation($request);
        if ($locationCheck !== true) {
            return redirect()->back()->with('error', $locationCheck);
        }

        $userId = Auth::id();
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now();

        $officialCheckoutTime = Carbon::parse($this->officialTimeOut);
        if ($currentTime->lessThan($officialCheckoutTime)) {
            return redirect()->back()->with('error', 'You cannot check out before the official check-out time.');
        }

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if ($attendance && !$attendance->time_out) {
            $attendance->time_out = $currentTime->toTimeString();
            $attendance->extra_minutes = $attendance->calculateExtraMinutes($this->officialTimeOut);
            $attendance->save();

            return redirect()->back()->with('success', 'Check-out recorded successfully!');
        }

        return redirect()->back()->with('error', 'You haven’t checked in today or have already checked out.');
    }
}
