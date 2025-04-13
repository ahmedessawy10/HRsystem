<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        AppSetting::create([
            'app_name' => 'HR System',
            'app_email' => 'admin@hrsystem.com',
            'app_phone' => '+1234567890',
            'app_address' => '123 HR Street'
        ]);
    }
}