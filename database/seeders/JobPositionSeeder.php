<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 وظائف برمجية
        JobPosition::insert([
            // 🔹 وظائف برمجية (Development Department - ID: 3)
            [
                'name' => 'Full-Stack Developer',
                'department_id' => 3,
            ],
            [
                'name' => 'Frontend Developer',
                'department_id' => 3,
            ],
            [
                'name' => 'Backend Developer',
                'department_id' => 3,
            ],
            [
                'name' => 'Mobile App Developer',
                'department_id' => 3,
            ],
            [
                'name' => 'DevOps Engineer',
                'department_id' => 3,
            ],
            [
                'name' => 'Cybersecurity Analyst',
                'department_id' => 3,
            ],
            [
                'name' => 'Data Scientist',
                'department_id' => 3,
            ],
            [
                'name' => 'Machine Learning Engineer',
                'department_id' => 3,
            ],
            [
                'name' => 'Cloud Engineer',
                'department_id' => 3,
            ],
            [
                'name' => 'Software Architect',
                'department_id' => 3,
            ],
            [
                'name' => 'Database Administrator',
                'department_id' => 3,
            ],
            [
                'name' => 'Game Developer',
                'department_id' => 3,
            ],
            [
                'name' => 'Embedded Systems Engineer',
                'department_id' => 3,
            ],

            // 🔹 وظائف إدارة ومحاسبة (HR - ID: 1, Accounting - ID: 4)
            [
                'name' => 'Project Manager',
                'department_id' => 1, // HR
            ],
            [
                'name' => 'Product Manager',
                'department_id' => 1, // HR
            ],
            [
                'name' => 'Scrum Master',
                'department_id' => 1, // HR
            ],
            [
                'name' => 'HR Manager',
                'department_id' => 1, // HR
            ],
            [
                'name' => 'Accountant',
                'department_id' => 4, // Accounting
            ],
            [
                'name' => 'Financial Analyst',
                'department_id' => 4, // Accounting
            ],
            [
                'name' => 'Operations Manager',
                'department_id' => 1, // HR
            ],
            [
                'name' => 'Business Analyst',
                'department_id' => 1, // HR
            ],

            // 🔹 وظائف التسويق والمبيعات (Sale - ID: 4)
            [
                'name' => 'Marketing Manager',
                'department_id' => 4, // Sale
            ],
            [
                'name' => 'SEO Specialist',
                'department_id' => 4, // Sale
            ],
            [
                'name' => 'Social Media Manager',
                'department_id' => 4, // Sale
            ],
            [
                'name' => 'Content Writer',
                'department_id' => 4, // Sale
            ],
            [
                'name' => 'Sales Representative',
                'department_id' => 4, // Sale
            ],
            [
                'name' => 'Customer Support Specialist',
                'department_id' => 4, // Sale
            ],

            // 🔹 وظائف التصميم والإبداع (Development - ID: 3)
            [
                'name' => 'UI/UX Designer',
                'department_id' => 3, // Development
            ],

            // 🔹 وظائف أخرى (Development - ID: 3, HR - ID: 1)
            [
                'name' => 'QA Engineer',
                'department_id' => 3, // Development
            ],
            [
                'name' => 'Network Engineer',
                'department_id' => 3, // Development
            ],
            [
                'name' => 'IT Support Specialist',
                'department_id' => 3, // Development
            ],
            [
                'name' => 'Legal Consultant',
                'department_id_id' => 1, // HR
            ],
            [
                'name' => 'Research Scientist',
                'department_id' => 3, // Development
            ],
        ]);
    }
}
