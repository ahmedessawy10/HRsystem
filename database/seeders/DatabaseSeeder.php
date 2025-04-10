<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AppSetting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\HolidaySeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\AppSettingSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\JobPositionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AppSettingSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            JobPositionSeeder::class,
            PermissionSeeder::class,
            HolidaySeeder::class,
            HrSettingSeeder::class,
            EmployeeSeeder::class,
            AttendanceSeeder::class,
        ]);

        // Add this line in the run() method
        $this->call(AppSettingsSeeder::class);
    }
}
