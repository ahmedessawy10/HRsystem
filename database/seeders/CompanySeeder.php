<?php

namespace Database\Seeders;


use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'address' => '6 october',
            'latitude' => "30.785536",
            'longitude' => "30.9886976",
            'radius' => 50,
            'city' => "cairo",
            "phone" => "10911023458",
            "email" => "ITI@gmail.com",
            "name" => "ITI"
        ]);
    }
}
