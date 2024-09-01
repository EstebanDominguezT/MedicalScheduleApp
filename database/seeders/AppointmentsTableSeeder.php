<?php

namespace Database\Seeders;

use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Appointment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Seleccionar 3 empleados administrativos al azar
        $employees = Employee::where('employee_type_id', EmployeeTypesEnum::ADMINISTRATIVE)
            ->inRandomOrder()
            ->take(3)
            ->get();

// Definir el rango de meses
        $months = [
            Carbon::now()->startOfMonth(),
            Carbon::now()->addMonth()->startOfMonth()
        ];

        foreach ($employees as $employee) {
            foreach ($months as $monthStart) {
                $weekStart = $monthStart->copy()->next(Carbon::MONDAY);

// Generar 8 reservas para este empleado en la primera semana de cada mes
                $appointmentTime = $weekStart->copy()->setTime(8, 0, 0);

                for ($i = 0; $i < 8; $i++) {
// Evitar horarios de almuerzo (por ejemplo, 12:00 PM a 1:00 PM)
                    if ($appointmentTime->format('H:i') === '12:00') {
                        $appointmentTime->addHour(); // Saltar la hora de almuerzo
                    }

                    $doctor = $this->findAvailableDoctor($appointmentTime);

                    if ($doctor) {
                        Appointment::create([
                            'doctor_id' => $doctor->id,
                            'patient_id' => $employee->id,
                            'start_datetime' => $appointmentTime,
                            'end_datetime' => $appointmentTime->copy()->addHour(),
                            'created_by' => $employee->user->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

// Avanzar al siguiente horario para la siguiente cita
                        $appointmentTime->addHour();

// Si el horario pasa las 3:00 PM, reiniciar al siguiente día de la semana
                        if ($appointmentTime->format('H:i') == '15:00') {
                            $appointmentTime = $weekStart->copy()->addDays($i % 5)->setTime(8, 0, 0);
                        }
                    }
                }
            }
        }
    }

    /**
     * Encuentra un doctor disponible para un tiempo específico.
     *
     * @param Carbon $appointmentTime
     * @return Employee|null
     */
    private function findAvailableDoctor(Carbon $appointmentTime)
    {
        return Employee::where('employee_type_id', EmployeeTypesEnum::DOCTOR)
            ->get()
            ->filter(function ($doctor) use ($appointmentTime) {
// Obtener citas en conflicto para este doctor
                $conflictAppointments = Appointment::where('doctor_id', $doctor->id)
                    ->where(function ($query) use ($appointmentTime) {
                        $query->where(function ($query) use ($appointmentTime) {
                            $query->whereDate('start_datetime', $appointmentTime->toDateString())
                                ->whereTime('start_datetime', '<=', $appointmentTime->format('H:i:s'))
                                ->whereTime('end_datetime', '>', $appointmentTime->format('H:i:s'));
                        });
                    })
                    ->count();

// Si no hay citas en conflicto, el doctor está disponible
                return $conflictAppointments === 0;
            })
            ->first();
    }
}
