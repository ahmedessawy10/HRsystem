<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Attendance::class;
    public function definition(): array
    {
        $startTime = strtotime('08:00:00');
        $endTime = strtotime('17:00:00');

        // توليد تاريخ عشوائي لهذا الشهر مع استبعاد الجمعة والسبت
        $user = User::inRandomOrder()->first() ?? User::factory()->create();


        do {
            $randomDate = Carbon::now()->startOfMonth()->addDays(rand(0, 29));
        } while (
            in_array($randomDate->dayOfWeek, [5, 6]) ||
            Attendance::where('user_id', $user->id)->where('date', $randomDate->format('Y-m-d'))->exists()
        );

        $random1 = rand(0, 3600);
        $random2 = rand(0, 3600);

        $timeInTimestamp = mt_rand($startTime + $random1, $endTime);
        $timeOutTimestamp = mt_rand($timeInTimestamp, $endTime + $random2);

        return [
            'user_id' => $user->id,
            'date' => $randomDate->format('Y-m-d'),
            'time_in' => date('H:i:s', $timeInTimestamp),
            'time_out' => date('H:i:s', $timeOutTimestamp),
            'late_minutes' => floor(abs($timeInTimestamp - $startTime) ),
            'extra_minutes' => floor(abs($endTime - $timeOutTimestamp)),
        ];
    }
}
