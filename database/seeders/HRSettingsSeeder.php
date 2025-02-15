<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HRSetting;

class HRSettingsSeeder extends Seeder
{
    public function run()
    {
        HRSetting::create([
            'overtime' => 10.00,
            'discount' => 5.00,
            'day_off_1' => 'الجمعة',
            'day_off_2' => 'السبت',
            'start_time' => '09:00:00', // أضف قيمة افتراضية هنا
            'end_time' => date('H:i:s', strtotime('18:00:00')),

        ]);
    }
}
