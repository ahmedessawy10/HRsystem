<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use App\Models\Holiday;
use App\Models\HrSetting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Fetch HR settings and holidays
Schedule::call(function () {
    $hr = HrSetting::first();
    if (!$hr) return;

    $holidays = json_decode($hr->holidays, true) ?? [];
    $isHoliday = in_array(now()->dayOfWeek, $holidays);
    $hasHolidayToday = Holiday::whereDate('date', now())->exists();
    $date = Carbon::parse(now());
    $month = $date->month;
    $year = $date->year;
    $monthDay = $this->calcDayMonth($year, $month, $holidays); // Days in the current month
    $dailyRate = 0;

    if ($isHoliday || $hasHolidayToday) { // If today is a holiday
        User::roles('employee')->with(['attendances', 'salaries'])->chunk(100, function ($users) use ($month, $year, $monthDay, $dailyRate) {
            foreach ($users as $user) {
                $dailyRate = $user->salary / $monthDay;

                $salary = Salary::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'month' => $month,
                        'year' => $year,
                    ],
                    [
                        'delay_hours' => 0.0,
                        'extra_hours' => 0.0,
                        'delay_cost' => 0.0,
                        'extra_cost' => 0.0,
                        'salary' => $user->salary ?? 0,
                        'absent' => $monthDay,
                        'net_salary' => 0,
                    ]
                );

                // If employee was absent, reduce the salary
                if ($salary->absent > 0) {
                    $salary->absent -= 1; // Deduct one day for attendance
                    $salary->net_salary += $dailyRate; // Add salary for the day present
                }

                $salary->save();
            }
        });
    }
})->daily()->at('12:00')->timezone('Africa/Cairo');
