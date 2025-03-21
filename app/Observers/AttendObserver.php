<?php

namespace App\Observers;

use App\Models\Salary;
use App\Models\Attendance;
use App\Models\HrSetting;
use App\trait\SalaryCalc;
use Carbon\Carbon;

class AttendObserver
{
    use SalaryCalc;
    /**
     * Handle the Attendance "created" event.
     */
    public function created(Attendance $attendance): void
    {
        $date = Carbon::parse($attendance->date);
        $month = $date->month;
        $year = $date->year;
        $holidays = Json_decode(HrSetting::first()->holidays);
        $user = $attendance->user;
        $hr = HrSetting::first();

        $salaryExists = Salary::where('user_id', $attendance->user_id)
            ->where('month', $month)
            ->where('year', $year)
            ->exists();

        $salary = Salary::firstOrCreate(
            [
                'user_id' => $attendance->user_id,
                'month' => $month,
                'year' => $year
            ],
            [
                "delay_hours" => 0.0,
                "extra_hours" => 0.0,
                "delay_cost" => 0.0,
                "extra_cost" => 0.0,
                "salary" => $user->salary ?? 0,
                "absent" => 0,
                "net_salary" => $user->salary ?? 0,
            ]
        );

        $work_to = $user->end_time ?? $hr->end_time;
        $work_from = $user->start_time ?? $hr->start_time;

        $totalworkhour = (strtotime($work_to) - strtotime($work_from)) / 3600;
        $attaneces_count_func = $this->calcDayMonth(intval($year), intval($month), $holidays);

        $denominator = ($totalworkhour * $attaneces_count_func);
        if ($denominator > 0 && $user->salary >= 0) {
            $totalworkhourscost = $user->salary / $denominator;

            // Don't add daily salary to net_salary for each attendance record
            // $salary->net_salary += round($user->salary / $attaneces_count_func, 2);


            if ($attendance->late_hours > 0) {
                $salary->delay_hours += doubleval($attendance->late_hours);
                $delay_cost = (doubleval($hr->discount) * ($attendance->late_hours)) * $totalworkhourscost;
                $salary->delay_cost += $delay_cost;
                $salary->net_salary -= $delay_cost;
            }

            if ($attendance->extra_hours > 0) {
                $salary->extra_hours += doubleval($attendance->extra_hours);
                $extra_cost = (doubleval($hr->overtime) * doubleval($attendance->extra_hours)) * $totalworkhourscost;
                $salary->extra_cost += $extra_cost;
                $salary->net_salary += $extra_cost;
            }

            $salary->save();
        }
    }


    /**
     * Handle the Attendance "updated" event.
     */
    public function updated(Attendance $attendance): void
    {
        // Only proceed if the attendance record has actually changed
        if (!$attendance->isDirty()) {
            return;
        }

        $date = Carbon::parse($attendance->date);
        $month = $date->month;
        $year = $date->year;
        $holidays = Json_decode(HrSetting::first()->holidays);
        $user = $attendance->user;
        $hr = HrSetting::first();

        $salary = Salary::where('user_id', $attendance->user_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$salary) {

            $this->created($attendance);
            return;
        }

        $work_to = $user->end_time ?? $hr->end_time;
        $work_from = $user->start_time ?? $hr->start_time;

        $totalworkhour = (strtotime($work_to) - strtotime($work_from)) / 3600;
        $attaneces_count_func = $this->calcDayMonth(intval($year), intval($month), $holidays);

        $denominator = ($totalworkhour * $attaneces_count_func);
        if ($denominator > 0 && $user->salary >= 0) {
            $totalworkhourscost = $user->salary / $denominator;

            $original = $attendance->getOriginal();
            // dd($original);
            if (!empty($original['late_hours']) && $original['late_hours'] > 0) {
                $original_delay_cost = (doubleval($hr->discount) * doubleval($original['late_hours'])) * $totalworkhourscost;
                $salary->delay_hours -= $original['late_hours'];
                $salary->delay_cost -= $original_delay_cost;
                $salary->net_salary += $original_delay_cost;
            }


            if (!empty($original['extra_hours']) && $original['extra_hours'] > 0) {
                $original_extra_cost = (doubleval($hr->overtime) * doubleval($original['extra_hours'])) * $totalworkhourscost;
                $salary->extra_hours -= $original['extra_hours'];
                $salary->extra_cost -= $original_extra_cost;
                $salary->net_salary -= $original_extra_cost;
            }

            if ($attendance->late_hours > 0) {
                $salary->delay_hours += $attendance->late_hours;
                $delay_cost = (doubleval($hr->discount) * doubleval($attendance->late_hours)) * $totalworkhourscost;
                $salary->delay_cost += $delay_cost;
                $salary->net_salary -= $delay_cost;
            }

            if ($attendance->extra_hours > 0) {
                $salary->extra_hours += $attendance->extra_hours;
                $extra_cost = (doubleval($hr->overtime) * doubleval($attendance->extra_hours)) * $totalworkhourscost;
                $salary->extra_cost += $extra_cost;
                $salary->net_salary += $extra_cost;
            }

            $salary->save();
        }
    }

    /**
     * Handle the Attendance "deleted" event.
     */
    public function deleted(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     */
    public function restored(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     */
    public function forceDeleted(Attendance $attendance): void
    {
        //
    }
}
