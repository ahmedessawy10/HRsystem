<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid issues during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate(); // Truncate permissions table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert permissions
        Permission::insert([
            ['name' => 'permission view_only', 'guard_name' => 'web'],
            ['name' => 'permission create_and_view', 'guard_name' => 'web'],
            ['name' => 'permission update', 'guard_name' => 'web'],
            ['name' => 'permission delete', 'guard_name' => 'web'],
            ['name' => 'role view_only', 'guard_name' => 'web'],
            ['name' => 'role create_and_view', 'guard_name' => 'web'],
            ['name' => 'role update', 'guard_name' => 'web'],
            ['name' => 'role delete', 'guard_name' => 'web'],
            ['name' => 'holiday create', 'guard_name' => 'web'],
            ['name' => 'holiday update', 'guard_name' => 'web'],

        ]);

        // Create or retrieve roles
        $AdminRole = Role::firstOrCreate(['name' => 'admin']); // Super-admin role
        $HrRole = Role::firstOrCreate(['name' => 'hr_manager']);
        $EmployeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Assign permissions to roles
        $allPermissionNames = Permission::pluck('name');
        $AdminRole->givePermissionTo($allPermissionNames); // Admin gets all permissions
        $HrRole->givePermissionTo([
            'permission create_and_view',
            'permission update',
            'permission delete',
            'role view_only',
            'role create_and_view',
            'role update',
            'role delete',
        ]);

        // Create or retrieve users
        $Admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'fullname' => "Admin user",
            'email' => 'admin@gmail.com', // Corrected email to match the query
            'status' => "active",
            'password' => Hash::make('123456'),
        ]);

        $Hr = User::firstOrCreate([
            'email' => 'hrManger@gmail.com',
        ], [
            'name' => 'hr manager',
            'fullname' => "hr manager",
            'email' => 'hrManger@gmail.com',
            'status' => "active",
            'password' => Hash::make('123456'),

        ]);

        $Employee = User::firstOrCreate([
            'email' => 'employee@gmail.com',
        ], [
            'name' => 'employee1',
            'fullname' => "employee N1",
            'email' => 'employee@gmail.com',
            'status' => "active",
            "start_time" => date('H:i:s', strtotime('10:00:00')),
            "end_time" => date('H:i:s', strtotime('18:00:00')),
            'password' => Hash::make('123456'),
        ]);

        // Assign roles to users
        $Admin->assignRole($AdminRole);
        $Hr->assignRole($HrRole);
        $Employee->assignRole($EmployeeRole);
    }
}
