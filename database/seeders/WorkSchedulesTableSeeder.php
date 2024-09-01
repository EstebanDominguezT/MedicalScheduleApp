<?php

namespace Database\Seeders;

use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all()->where('employee_type_id', EmployeeTypesEnum::DOCTOR);
        $startDate = Carbon::now()->startOfMonth()->subMonth();
        $endDate = Carbon::now()->addMonth()->endOfMonth();

        foreach ($employees as $employee) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekday()) {
                    WorkSchedule::create([
                        'employee_id' => $employee->id,
                        'date' => $date->toDateString(),
                        'start_time' => Carbon::parse($date->toDateString() . ' 08:00:00')->format('Y-m-d H:i:s'),
                        'end_time' => Carbon::parse($date->toDateString() . ' 15:00:00')->format('Y-m-d H:i:s'),
                        'lunch_start_time' => Carbon::parse($date->toDateString() . ' 12:00:00')->format('Y-m-d H:i:s'),
                        'lunch_end_time' => Carbon::parse($date->toDateString() . ' 13:00:00')->format('Y-m-d H:i:s'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
