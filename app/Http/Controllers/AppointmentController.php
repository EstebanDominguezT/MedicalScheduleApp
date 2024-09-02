<?php

namespace App\Http\Controllers;

use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $doctors = Employee::where('employee_type_id', EmployeeTypesEnum::DOCTOR)->get();

        if (auth()->user()->hasRole('administrator')) {
            $patients = Employee::where('employee_type_id', EmployeeTypesEnum::ADMINISTRATIVE)->get();
        } else {
            $patients = Employee::where('employee_type_id', EmployeeTypesEnum::ADMINISTRATIVE)
                ->where('user_id', auth()->user()->id)
                ->first();
        }

        if (auth()->user()->hasRole('administrator')) {
            $appointments = Appointment::all();
        } elseif (auth()->user()->hasRole('doctor')) {
            $appointments = Appointment::where('doctor_id', auth()->user()->id)->get();
        } else {
            $appointments = Appointment::where('patient_id', auth()->user()->id)->get();
        }

        return view('appointments.index', compact('doctors', 'patients', 'appointments'));
    }

    public function create(): \Illuminate\View\View
    {
        $doctors = Employee::where('employee_type_id', EmployeeTypesEnum::DOCTOR)->get();
        $patients = Employee::where('employee_type_id', EmployeeTypesEnum::ADMINISTRATIVE)->get();

        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $appointments = Appointment::where('patient_id', $request->patient_id)
                ->where('doctor_id', $request->doctor_id)
                ->whereDate('start_datetime', $request->start_datetime)
                ->get();

            if ($appointments->count() > 0) {
                return redirect()->route('appointments.index')->with('error', 'Doctor already has an appointment at the selected time.');
            }

            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:employees,id',
                'patient_id' => 'required|exists:employees,id',
                'start_datetime' => 'required|date',
                'end_datetime' => 'required|date|after:start_datetime',
            ]);

            Appointment::create([
                'doctor_id' => $validatedData['doctor_id'],
                'patient_id' => $validatedData['patient_id'],
                'start_datetime' => $validatedData['start_datetime'],
                'end_datetime' => $validatedData['end_datetime'],
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('appointments.index')->with('error', 'An error occurred while creating the appointment.');
        }
    }

    public function show(int $id): \Illuminate\View\View
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(int $id): \Illuminate\View\View
    {
        $appointment = Appointment::findOrFail($id);
        $doctors = Employee::where('employee_type_id', 1)->get();
        $patients = Employee::where('employee_type_id', 2)->get();

        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        try {
           DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);

            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:employees,id',
                'patient_id' => 'required|exists:employees,id',
                'start_datetime' => 'required|date',
                'end_datetime' => 'required|date|after:start_datetime',
            ]);

            $appointment->update($validatedData);

            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('appointments.index')->with('error', 'An error occurred while updating the appointment.');
        }
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            DB::commit();

            return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('appointments.index')->with('error', 'An error occurred while deleting the appointment.');
        }
    }

    public function availableHours(Request $request): \Illuminate\Http\JsonResponse
    {
        $doctorId = $request->doctor_id;
        $date = $request->date;
        $currentAppointmentId = $request->appointment_id;

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $date)
            ->get();

        $events = [];

        $workSchedule = WorkSchedule::where('employee_id', $doctorId)
            ->where('date', $date)
            ->first();

        $workHoursStart = (!is_null($workSchedule)) ? Carbon::parse($workSchedule->start_time) : null;
        $workHoursEnd = (!is_null($workSchedule)) ? Carbon::parse($workSchedule->end_time) : null;
        $workLunchStart = (!is_null($workSchedule)) ? Carbon::parse($workSchedule->lunch_start_time) : null;
        $workLunchEnd = (!is_null($workSchedule)) ? Carbon::parse($workSchedule->lunch_end_time) : null;

        if (!is_null($workHoursStart) && !is_null($workHoursEnd)) {
            while ($workHoursStart->lessThan($workHoursEnd)) {
                $slotEndTime = $workHoursStart->copy()->addHour();

                $isLunchTime = ($workLunchStart && $workLunchEnd) && (
                        ($workHoursStart->greaterThanOrEqualTo($workLunchStart) && $workHoursStart->lessThan($workLunchEnd)) ||
                        ($slotEndTime->greaterThan($workLunchStart) && $slotEndTime->lessThanOrEqualTo($workLunchEnd))
                    );

                if ($isLunchTime) {
                    $events[] = [
                        'title' => 'Almuerzo',
                        'start' => $workHoursStart->toDateTimeString(),
                        'end' => $slotEndTime->toDateTimeString(),
                        'backgroundColor' => 'orange',
                        'borderColor' => 'orange',
                    ];
                } else {
                    $appointment = $appointments->first(function ($appointment) use ($workHoursStart, $slotEndTime) {
                        return ($appointment->start_datetime < $slotEndTime) && ($appointment->end_datetime > $workHoursStart);
                    });

                    if ($appointment) {
                        $isCurrentAppointment = ($appointment->id == $currentAppointmentId);
                        $events[] = [
                            'title' => $isCurrentAppointment ? 'Seleccionado' : 'Ocupado',
                            'start' => $workHoursStart->toDateTimeString(),
                            'end' => $slotEndTime->toDateTimeString(),
                            'backgroundColor' => $isCurrentAppointment ? '#007bff' : 'red', // Azul para seleccionado
                            'borderColor' => $isCurrentAppointment ? '#007bff' : 'red',
                            'isOccupied' => !$isCurrentAppointment,
                        ];
                    } else {
                        $events[] = [
                            'title' => 'Disponible',
                            'start' => $workHoursStart->toDateTimeString(),
                            'end' => $slotEndTime->toDateTimeString(),
                            'backgroundColor' => 'green',
                            'borderColor' => 'green',
                            'isOccupied' => false,
                        ];
                    }
                }

                $workHoursStart->addHour();
            }
        }

        return response()->json($events);
    }
}
