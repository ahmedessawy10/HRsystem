<?php

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
$hr = HrSetting::first();
if (!$hr) {
    return; // Exit if no HR settings are found
}

$holidays = json_decode($hr->holidays, true) ?? [];
$isHoliday = in_array(now()->dayOfWeek, $holidays);
$hasHolidayToday = Holiday::whereDate('date', now())->exists();

// Schedule the task if today is a holiday and no specific holiday is set
if ($isHoliday && !$hasHolidayToday) {
    Schedule::call(function () {
        User::roles('employee')->with(['attendances', 'salaries'])->chunk(100, function ($users) {
            foreach ($users as $user) {
                // Check if the user already has an absence record for today
                $absent = $user->absents()
                    ->where('user_id', $user->id)
                    ->where('absent_date', now()->toDateString())
                    ->exists();

                if (!$absent) {
                    // Check if the user has attendance for today
                    $attend = $user->attendances->where('date', now()->toDateString())->first();

                    // Fetch or create the salary record for the current month and year
                    $salary = $user->salaries()
                        ->firstOrCreate(
                            [
                                'month' => now()->month,
                                'year' => now()->year,
                            ],
                            [
                                'salary' => $user->salary ?? 0,
                                'net_salary' => $user->salary ?? 0,
                                'absent' => 0,
                            ]
                        );

                    // Deduct salary for absence if the user didn't attend
                    if (!$attend) {
                        $salary->net_salary -= $salary->salary / 30;
                        $salary->absent += 1;
                        $salary->save();
                    }

                    // Create an absence record for the user
                    $user->absents()->create([
                        'user_id' => $user->id,
                        'absent_date' => now()->toDateString(),
                        'reason' => 'Absent',
                    ]);
                }
            }
        });
    })->daily()->at('23:00');
}
