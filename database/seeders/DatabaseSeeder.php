<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(GendersTableSeeder::class);
        $this->call(PersonsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EmployeeTypesTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(WorkSchedulesTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
    }
}
