<?php

namespace Database\Seeders;

use App\Http\Enums\EmployeeTypesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeTypes = [
            [
                'id' => EmployeeTypesEnum::DOCTOR,
                'name' => 'Doctor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'name' => 'Administrativo',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('employee_types')->insert($employeeTypes);
    }
}
