<?php

namespace Database\Seeders;

use App\Http\Enums\EmployeeTypesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'user_id' => 2,
                'employee_type_id' => EmployeeTypesEnum::DOCTOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'employee_type_id' => EmployeeTypesEnum::DOCTOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 5,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 6,
                'employee_type_id' => EmployeeTypesEnum::DOCTOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 7,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 8,
                'employee_type_id' => EmployeeTypesEnum::DOCTOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 9,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 10,
                'employee_type_id' => EmployeeTypesEnum::DOCTOR,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 11,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('employees')->insert($employees);
    }
}
