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

    // Calculate late minutes
    public function calculateLateMinutes($officialTimeIn)
    {
        if (!$this->time_in) {
            return 0;
        }

        $timeIn = Carbon::parse($this->time_in);
        $officialTime = Carbon::parse($officialTimeIn);

        return $timeIn->gt($officialTime) ? $timeIn->diffInMinutes($officialTime) : 0;
    }

    // Calculate extra minutes
    public function calculateExtraMinutes($officialTimeOut)
    {
        if (!$this->time_out) {
            return 0;
        }

        $timeOut = Carbon::parse($this->time_out);
        $officialTime = Carbon::parse($officialTimeOut);

        return $timeOut->gt($officialTime) ? $timeOut->diffInMinutes($officialTime) : 0;
    }
}
