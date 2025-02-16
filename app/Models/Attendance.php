<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'date', 'time_in', 'time_out', 'late_minutes', 'extra_minutes'
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

    /**
     * Calculate late minutes with grace period consideration.
     *
     * The calculation now subtracts the official time (plus the grace period)
     * from the actual check-in time. If the result is positive, that's the number
     * of minutes late; otherwise, it returns 0.
     *
     * @param string $officialTimeIn The official check-in time.
     * @param int $gracePeriod Minutes allowed as a grace period (default is 5 minutes).
     * @return int Returns the number of late minutes.
     */
    public function calculateLateMinutes($officialTimeIn, $gracePeriod = 5)
    {
        if (!$this->time_in) {
            return 0; 
        }

        $timeIn = Carbon::parse($this->time_in);
        $officialTime = Carbon::parse($officialTimeIn)->addMinutes($gracePeriod);

        if ($timeIn->greaterThan($officialTime)) {
        
            return $officialTime->diffInMinutes($timeIn);
        }

        return 0;
    }

    /**
     * Calculate extra minutes worked after the official check-out time.
     *
     * The calculation subtracts the official check-out time from the actual
     * check-out time. If extra minutes exceed 60, they are still stored as minutes.
     * A helper method is provided to format them when needed.
     *
     * @param string $officialTimeOut The official check-out time.
     * @param int $roundingInterval Minutes rounding interval (default is 5 minutes).
     * @return int Returns the number of extra minutes.
     */
    public function calculateExtraMinutes($officialTimeOut, $roundingInterval = 5)
    {
        if (!$this->time_out) {
            return 0; 
        }

        $timeOut = Carbon::parse($this->time_out);
        $officialTime = Carbon::parse($officialTimeOut);

        if ($timeOut->greaterThan($officialTime)) {
           
            $extraMinutes = $officialTime->diffInMinutes($timeOut);
            return (int) ceil($extraMinutes / $roundingInterval) * $roundingInterval;
        }

        return 0;
    }

    /**
     * Convert minutes into a formatted string showing hours and minutes.
     *
     * This is a presentation helper so you can display extra time in a more human-friendly format.
     *
     * @param int $minutes
     * @return string Formatted string (e.g., "1 hour(s) and 15 minute(s)" or "X minute(s)")
     */
    public function formatMinutesToHours($minutes)
    {
        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            return sprintf('%d hour(s) and %d minute(s)', $hours, $remainingMinutes);
        }

        return sprintf('%d minute(s)', $minutes);
    }
}
