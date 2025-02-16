<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'Admin',
        'fullname' => 'Admin User',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'active',
    ]);
}
}
