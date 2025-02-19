<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppSetting::create([
            'name' => 'Hr system',
            'logo' => 'logoDefault.png',
            'favicon' => 'favicon.png',
            'time_zone' => 'Africa/Cairo',
            'currancy' => 'EGY',
            'language' => 'en',
            'date_format' => 'dd-MM-yyyy',
            'time_format' => 'HH:mm a',
        ]);
    }
}
