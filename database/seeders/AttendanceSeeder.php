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
        // Attendance::factory()->count(100)->create();


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

        foreach ($users as $user) {
            foreach ($days as $day) {
                $startTime = strtotime('08:00:00');
                $endTime = strtotime('17:00:00');

                $f1 = mt_rand(15, 200) / 100;
                $f2 = mt_rand(15, 200) / 100;
                $timeInTimestamp = $startTime + $f1;
                $timeOutTimestamp = $endTime + $f2;

                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $day,
                    'time_in' => date('H:i:s', $timeInTimestamp),
                    'time_out' => date('H:i:s', $timeOutTimestamp),
                    'late_hours' => round(max(0, ($timeInTimestamp - $startTime)), 2),
                    'extra_hours' => round(max(0, ($timeOutTimestamp - $endTime)), 2),
                ]);
            }
        }
    }
}
