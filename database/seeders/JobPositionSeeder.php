<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosition;
use App\Models\Department;

class JobPositionSeeder extends Seeder
{
    public function run()
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            $this->call(DepartmentSeeder::class); // تأكد أن الأقسام موجودة أولًا
        }

        $jobPositions = [
            'HR Manager' => 'HR',
            'HR Specialist' => 'HR',
            'Software Engineer' => 'Development',
            'Backend Developer' => 'Development',
            'Accountant' => 'Accounting',
            'Financial Analyst' => 'Accounting',
            'Sales Representative' => 'Sales',
            'Sales Manager' => 'Sales'
        ];

        foreach ($jobPositions as $title => $deptName) {
            $department = Department::where('name', $deptName)->first();

            if ($department) {
                JobPosition::firstOrCreate([
                    'name' => $title, // ✅ استخدام `name` بدلًا من `title`
                    'department_id' => $department->id
                ]);
            }
        }
    }
}
