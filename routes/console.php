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
Schedule::call(function () {
    $hr = HrSetting::first();
    if (!$hr) return;

    $holidays = json_decode($hr->holidays, true) ?? [];
    $isHoliday = in_array(now()->dayOfWeek, $holidays);
    $hasHolidayToday = Holiday::whereDate('date', now())->exists();

    if ($isHoliday && !$hasHolidayToday) {
        User::roles('employee')->with(['attendances', 'salaries'])->chunk(100, function ($users) {
            foreach ($users as $user) {
                $absent = $user->absents()
                    ->whereDate('absent_date', now())
                    ->exists();

                if (!$absent) {
                    $attended = $user->attendances()
                        ->whereDate('date', now())
                        ->exists();

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

                    if (!$attended) {
                        $salary->net_salary -= $salary->salary / 30;
                        $salary->absent += 1;
                        $salary->save();
                    }

                    $user->absents()->create([
                        'absent_date' => now()->toDateString(),
                        'reason' => 'Absent',
                    ]);
                }
            }
        });
    }
})->daily()->at('7:56')->timezone('Africa/Cairo');
