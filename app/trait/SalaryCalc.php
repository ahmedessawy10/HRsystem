<?php

namespace App\Trait;

use App\Models\HrSetting;

trait SalaryCalc
{
    public function calcSalary($salary, $total_late, $total_extra, $total_attend = 30, $work_from = null, $work_to = null)
    {
        $hr = HrSetting::first();
        $discount = $hr->discount;
        $add = $hr->overtime;

        $work_from = $work_from ?? $hr->start_time;
        $work_to = $work_to ?? $hr->end_time;

        // حساب عدد ساعات العمل اليومية
        $totalworkhour = (strtotime($work_to) - strtotime($work_from)) / 3600;
        $totalworkhour = max(($totalworkhour * $total_attend), 1); // منع القسمة على صفر

        // حساب تكلفة الساعة الواحدة
        $totalworkhourscost = $salary / $totalworkhour;

        // حساب الخصومات والإضافات
        $total_deduction = ($discount * $total_late) * $totalworkhourscost;
        $total_increase = ($add * $total_extra) * $totalworkhourscost;

        // حساب الراتب الصافي
        $net_salary = $salary + $total_increase - $total_deduction;

        return [
            "total_work_hours" => $totalworkhour / $total_attend, // عدد ساعات العمل اليومية
            "total_work_hours_cost" => $totalworkhourscost,
            "total_deduction" => round($total_deduction, 2),
            "total_increase" => round($total_increase, 2),
            "net_salary" => round($net_salary, 2),
        ];
    }

    public function calcDayMonth($year, $month, $except = [5, 6])
    {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $working_days = 0;

        for ($day = 1; $day <= $days_in_month; $day++) {
            $day_of_week = date("w", strtotime("$year-$month-$day"));
            if (!in_array($day_of_week, $except)) {
                $working_days++;
            }
        }

        return $working_days;
    }
}
