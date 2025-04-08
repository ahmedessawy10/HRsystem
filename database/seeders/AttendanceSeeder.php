<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {



        $lastMonth = Carbon::now()->subMonth()->month;
        $year = Carbon::now()->year;
        $days = [];


        $startDate = Carbon::create($year, $lastMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();


        while ($startDate <= $endDate) {
            if (!in_array($startDate->dayOfWeek, [5, 6])) {
                $days[] = $startDate->format('Y-m-d');
            }
            $startDate->addDay();
        }


        $users = Role::find(3)->users;

        // Inside the run method
        foreach ($users as $user) {
            foreach ($days as $day) {
                $startTime = strtotime('08:00:00');
                $endTime = strtotime('17:00:00');
        
                // More realistic late and extra hours
                $f1 = mt_rand(0, 60) / 100;  // Max 36 minutes late
                $f2 = mt_rand(0, 120) / 100; // Max 1.2 hours extra
        
                $timeInTimestamp = $startTime + ($f1 * 3600); // Convert to seconds
                $timeOutTimestamp = $endTime + ($f2 * 3600); // Convert to seconds
        
                Attendance::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'date' => $day,
                    ],
                    [
                        'user_id' => $user->id,
                        'date' => $day,
                        'time_in' => date('H:i:s', $timeInTimestamp),
                        'time_out' => date('H:i:s', $timeOutTimestamp),
                        'late_hours' => round($f1, 2),
                        'extra_hours' => round($f2, 2),
                    ]
                );
            }
        }
    }
}