<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $startTime = strtotime('08:00:00');
        $endTime = strtotime('17:00:00');

        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        do {
            $randomDate = Carbon::now()->startOfMonth()->addDays(rand(0, 365)); 
        } while (
            in_array($randomDate->dayOfWeek, [5, 6]) || 
            Attendance::where('user_id', $user->id)->where('date', $randomDate->format('Y-m-d'))->exists()
        );

       
        $random1 = rand(0, 3600); 
        $random2 = rand(0, 3600); 

        $timeInTimestamp = mt_rand($startTime, $startTime + $random1);
        $timeOutTimestamp = mt_rand($timeInTimestamp, $endTime + $random2);

        return [
            'user_id' => $user->id,
            'date' => $randomDate->format('Y-m-d'),
            'time_in' => date('H:i:s', $timeInTimestamp),
            'time_out' => date('H:i:s', $timeOutTimestamp),
            'late_minutes' => floor(abs($timeInTimestamp - $startTime) / 60),
            'extra_minutes' => floor(abs($endTime - $timeOutTimestamp) / 60),
        ];
    }
}