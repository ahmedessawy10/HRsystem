<?php

namespace App\trait;

use App\Models\HrSetting;

trait SalaryCalc
{

    public function calcSalary($salary, $total_late, $total_extra, $total_attend = 30, $work_from, $work_to)
    {

        $hr = HrSetting::first();
        $discount = $hr->discount;
        $add = $hr->overtime;

        $work_to = $work_to ?? $hr->end_time;
        $work_from = $work_from ?? $hr->start_time;

        $totalworkminuts = (strtotime($work_to) - strtotime($work_from)) / 60;
        $totalworkminutscost = $salary / ($totalworkminuts * $total_attend);
        $total_deduction =  ($discount * $total_late) * $totalworkminutscost;
        $total_increase =  ($add * $total_extra) * $totalworkminutscost;

        $net_salary = $salary + $total_increase - $total_deduction;



        return [
            "total_work_minutes" => $totalworkminuts,
            "total_work_minutes_cost" => $totalworkminutscost,
            "total_deduction" => $total_deduction,
            "total_increase" => $total_increase,
            "net_salary" =>  intval($net_salary),
        ];
    }


    function calcDayMonth($year, $month, $except = [5, 6])
    {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days_array = [];
        for ($day = 1; $day <= $days_in_month; $day++) {
            $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
            $day_of_week = date("w", strtotime($date));
            if (!in_array($day_of_week, $except)) {
                $days_array[] = $date;
            }

            return count($days_array);
        }
    }
}
