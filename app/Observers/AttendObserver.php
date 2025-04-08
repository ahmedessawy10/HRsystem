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

    public function created(Attendance $attendance): void
    {
        $date = Carbon::parse($attendance->date);
        $month = $date->month;
        $year = $date->year;
        $hr = HrSetting::first();
        $holidays = json_decode($hr->holidays);
        $user = $attendance->user;

        $month_day = $this->calcDayMonth($year, $month, $holidays);
        // Calculate daily rate with more precision
        $daily_rate = $user->salary / $month_day;

        $exists = Attendance::where('user_id', $attendance->user_id)
            ->whereDate('date', $attendance->date)
            ->where('id', '<', $attendance->id)
            ->exists();
        if ($exists) return;

        $salary = Salary::firstOrCreate(
            [
                'user_id' => $attendance->user_id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'delay_hours' => 0.0,
                'extra_hours' => 0.0,
                'delay_cost' => 0.0,
                'extra_cost' => 0.0,
                'salary' => $user->salary ?? 0,
                'absent' => $month_day,
                'net_salary' => 0,
            ]
        );

        // Update attendance and calculate net salary
        $salary->absent = max(0, $salary->absent - 1);
        $salary->net_salary += $daily_rate;

        if ($attendance->user_id == 4) dump($salary->net_salary);

        // Calculate late hours cost
        if ($attendance->late_hours > 0) {
            $delay_cost = doubleval($hr->discount) * doubleval($attendance->late_hours);
            $salary->delay_hours += $attendance->late_hours;
            $salary->delay_cost += $delay_cost;
            $salary->net_salary -= $delay_cost;
        }

        // Calculate extra hours cost
        if ($attendance->extra_hours > 0) {
            $extra_cost = doubleval($hr->overtime) * doubleval($attendance->extra_hours);
            $salary->extra_hours += $attendance->extra_hours;
            $salary->extra_cost += $extra_cost;
            $salary->net_salary += $extra_cost;
        }

        $salary->save();
    }

    public function updated(Attendance $attendance): void
    {
        if (!$attendance->isDirty()) return;

        $date = Carbon::parse($attendance->date);
        $month = $date->month;
        $year = $date->year;
        $hr = HrSetting::first();
        $user = $attendance->user;

        $salary = Salary::where('user_id', $attendance->user_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$salary) {
            $this->created($attendance);
            return;
        }

        $original = $attendance->getOriginal();
        $month_day = $this->calcDayMonth($year, $month, json_decode($hr->holidays));
        $daily_rate = $user->salary / $month_day;

        // إعادة حساب الراتب الأساسي
        $base_salary = ($month_day - $salary->absent) * $daily_rate;
        $salary->net_salary = $base_salary;

        // تحديث حسابات التأخير والساعات الإضافية
        $this->updateDelayAndExtraHours($attendance, $salary, $hr, $original);

        $salary->save();
    }

    private function updateDelayAndExtraHours($attendance, $salary, $hr, $original)
    {
        // إزالة الحسابات القديمة
        if (!empty($original['late_hours']) && $original['late_hours'] > 0) {
            $salary->delay_hours -= $original['late_hours'];
            $delay_cost = doubleval($hr->discount) * doubleval($original['late_hours']);
            $salary->delay_cost -= $delay_cost;
        }

        if (!empty($original['extra_hours']) && $original['extra_hours'] > 0) {
            $salary->extra_hours -= $original['extra_hours'];
            $extra_cost = doubleval($hr->overtime) * doubleval($original['extra_hours']);
            $salary->extra_cost -= $extra_cost;
        }

        // إضافة الحسابات الجديدة
        if ($attendance->late_hours > 0) {
            $delay_cost = doubleval($hr->discount) * doubleval($attendance->late_hours);
            $salary->delay_hours += $attendance->late_hours;
            $salary->delay_cost += $delay_cost;
            $salary->net_salary -= $delay_cost;
        }

        if ($attendance->extra_hours > 0) {
            $extra_cost = doubleval($hr->overtime) * doubleval($attendance->extra_hours);
            $salary->extra_hours += $attendance->extra_hours;
            $salary->extra_cost += $extra_cost;
            $salary->net_salary += $extra_cost;
        }
    }

    public function deleted(Attendance $attendance): void
    {
        $date = Carbon::parse($attendance->date);
        $month = $date->month;
        $year = $date->year;
        $hr = HrSetting::first();
        $user = $attendance->user;

        $holidays = json_decode($hr->holidays);
        $month_day = $this->calcDayMonth($year, $month, $holidays);
        $daily_rate = $user->salary / $month_day;

        $salary = Salary::where('user_id', $attendance->user_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$salary) return;

        $salary->absent += 1;
        $salary->net_salary -= $daily_rate;

        if ($attendance->late_hours > 0) {
            $delay_cost = doubleval($hr->discount) * doubleval($attendance->late_hours);
            $salary->delay_hours -= $attendance->late_hours;
            $salary->delay_cost -= $delay_cost;
            $salary->net_salary += $delay_cost;
        }

        if ($attendance->extra_hours > 0) {
            $extra_cost = doubleval($hr->overtime) * doubleval($attendance->extra_hours);
            $salary->extra_hours -= $attendance->extra_hours;
            $salary->extra_cost -= $extra_cost;
            $salary->net_salary -= $extra_cost;
        }

        $salary->save();
    }

    public function restored(Attendance $attendance): void {}
    public function forceDeleted(Attendance $attendance): void {}
}
