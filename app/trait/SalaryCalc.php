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

        $totalworkhour = (strtotime($work_to) - strtotime($work_from)) / 3600;
        $totalworkhourscost = $salary / ($totalworkhour * $total_attend);
        $total_deduction =  ($discount * ($total_late / 60)) * $totalworkhourscost;
        $total_increase =  ($add * ($total_extra / 60)) * $totalworkhourscost;

        $net_salary = $salary + $total_increase - $total_deduction;



        return [
            "total_work_hours" =>  $totalworkhour,
            "total_work_hours_cost" =>  $totalworkhourscost,
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
