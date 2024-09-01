<?php

namespace App\Http\Controllers;

use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkScheduleController extends Controller
{
    public function index(): \Illuminate\View\View
    {

        if (auth()->user()->hasRole('administrator')) {
            $workSchedules = WorkSchedule::all();
        } else {
            $workSchedules = WorkSchedule::where('employee_id', auth()->user()->employee->id)->get();
        }


        return view('work-schedules.index', compact('workSchedules'));
    }

    public function create(): \Illuminate\View\View
    {
        $employees = Employee::where('employee_type_id', EmployeeTypesEnum::DOCTOR)->get();
        return view('work-schedules.create', compact('employees'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'lunch_start_time' => 'required|date_format:H:i|before:end_time|after:start_time',
                'lunch_end_time' => 'required|date_format:H:i|after:lunch_start_time|before:end_time',
                'date' => 'required|date',
            ]);

            $workScheduleExists = WorkSchedule::where('employee_id', $validatedData['employee_id'])
                ->where('date', Carbon::parse($validatedData['date'])->toDateString())
                ->get();

            if ($workScheduleExists->count() > 0) {
                return redirect()->route('work_schedule.index')->with('error', 'Work schedule already exists for the selected date.');
            }

            WorkSchedule::create([
                'employee_id' => $validatedData['employee_id'],
                'date' => Carbon::parse($validatedData['date'])->toDateString(),
                'start_time' => Carbon::parse($validatedData['date'].' '.$validatedData['start_time'])->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($validatedData['date'].' '.$validatedData['end_time'])->format('Y-m-d H:i:s'),
                'lunch_start_time' =>  Carbon::parse($validatedData['date'].' '.$validatedData['lunch_start_time'])->format('Y-m-d H:i:s'),
                'lunch_end_time' => Carbon::parse($validatedData['date'].' '.$validatedData['lunch_end_time'])->format('Y-m-d H:i:s'),
            ]);

            DB::commit();

            return redirect()->route('work_schedule.index')->with('success', 'Work schedule created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('work_schedule.index')->with('error', 'An error occurred while creating the work schedule.');
        }
    }

    public function show(int $id): \Illuminate\View\View
    {
        $workSchedule = WorkSchedule::findOrFail($id);
        return view('work-schedules.show', compact('workSchedule'));
    }

    public function edit(int $id): \Illuminate\View\View
    {
        $workSchedule = WorkSchedule::findOrFail($id);
        $employees = Employee::all();
        return view('work-schedules.edit', compact('workSchedule', 'employees'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
            try {
                DB::beginTransaction();

            $workSchedule = WorkSchedule::findOrFail($id);

            $validatedData = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'lunch_start_time' => 'required|date_format:H:i|before:end_time|after:start_time',
                'lunch_end_time' => 'required|date_format:H:i|after:lunch_start_time|before:end_time',
                'date' => 'required|date',
            ]);

            $workSchedule->update([
                'employee_id' => $validatedData['employee_id'],
                'date' => Carbon::parse($validatedData['date'])->toDateString(),
                'start_time' => Carbon::parse($validatedData['date'].' '.$validatedData['start_time'])->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse($validatedData['date'].' '.$validatedData['end_time'])->format('Y-m-d H:i:s'),
                'lunch_start_time' =>  Carbon::parse($validatedData['date'].' '.$validatedData['lunch_start_time'])->format('Y-m-d H:i:s'),
                'lunch_end_time' => Carbon::parse($validatedData['date'].' '.$validatedData['lunch_end_time'])->format('Y-m-d H:i:s'),
            ]);

            DB::commit();

            return redirect()->route('work_schedule.index')->with('success', 'Work schedule updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('work_schedule.index')->with('error', 'An error occurred while updating the work schedule.');
        }
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            WorkSchedule::destroy($id);

            DB::commit();

            return redirect()->route('work_schedule.index')->with('success', 'Work schedule deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('work_schedule.index')->with('error', 'An error occurred while deleting the work schedule.');
        }
    }
}