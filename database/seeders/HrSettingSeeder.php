<?php

namespace Database\Seeders;

use App\Models\HrSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HrSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HrSetting::create([
            'discount' => 2,
            'overtime' => 2,
            'start_time' => date('H:i:s', strtotime('10:00:00')),
            'end_time' => date('H:i:s', strtotime('18:00:00')),
            'day_off_1' => "friday",
            'day_off_2' => "sunday",
        ]);
    }
}
