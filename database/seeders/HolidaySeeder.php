<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Holiday::insert(
            [
                [
                    'occation' => 'Revolution Day',
                    'date' => '2023-01-25',
                ],
                [
                    'occation' => 'Sinai Liberation Day',
                    'date' => '2023-04-25',
                ],
                [
                    'occation' => 'Labour Day',
                    'date' => '2023-05-01',
                ],
                [
                    'occation' => 'Armed Forces Day',
                    'date' => '2023-10-06',
                ],
                [
                    'occation' => 'National Day',
                    'date' => '2023-10-18',
                ],
                [
                    'occation' => 'Coptic Christmas',
                    'date' => '2023-01-07',
                ],
                [
                    'occation' => 'Sham el-Nessim',
                    'date' => '2023-04-17',
                ],
                [
                    'occation' => 'Eid al-Fitr',
                    'date' => '2023-04-21',
                ],
                [
                    'occation' => 'Eid al-Adha',
                    'date' => '2023-06-28',
                ],
                [
                    'occation' => 'Islamic New Year',
                    'date' => '2023-07-19',
                ],
                [
                    'occation' => 'Prophet Muhammad\'s Birthday',
                    'date' => '2023-09-27',
                ],
            ]

        );
    }
}
