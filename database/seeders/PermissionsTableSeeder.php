<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'can-create-employee',
            'can-read-employee',
            'can-update-employee',
            'can-delete-employee',
            'can-create-employee-type',
            'can-read-employee-type',
            'can-update-employee-type',
            'can-delete-employee-type',
            'can-create-appointment',
            'can-read-appointment',
            'can-update-appointment',
            'can-delete-appointment',
            'can-create-work-schedule',
            'can-read-work-schedule',
            'can-update-work-schedule',
            'can-delete-work-schedule',
            'can-create-role',
            'can-read-role',
            'can-update-role',
            'can-delete-role',
            'can-add-permission-to-role',
            'can-create-permission',
            'can-read-permission',
            'can-update-permission',
            'can-delete-permission',
            'can-create-user',
            'can-read-user',
            'can-update-user',
            'can-delete-user',
        ];

        foreach ($permissions as $permission) {
            Permission::create(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
