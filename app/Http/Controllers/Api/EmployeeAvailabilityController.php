<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAvailabilityController extends Controller
{
    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required|date_format:H:i',
            ]);

            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);

            $availableEmployees = DB::select("SELECT * FROM employees e
            WHERE e.employee_type_id = " . EmployeeTypesEnum::DOCTOR . "
            AND NOT EXISTS ( SELECT 1 FROM appointments a WHERE a.doctor_id = e.id AND 
                a.start_datetime <= '". $dateTime ."' AND 
                a.end_datetime >= '". $dateTime ."' );"
            );

            foreach ($availableEmployees as $available) {
                $employee = Employee::find($available->id);

                $formattedResponse[] = [
                    'id' => $employee->id,
                    'name' => $employee->user->person->full_name(),
                    'email' => $employee->user->email,
                    'phone_number' => $employee->user->person->phone_number,
                    'available' => true,
                ];
            }

            if (!isset($formattedResponse)) {
                $formattedResponse = [];
            }

            return response()->json(array('data' => $formattedResponse ?? [], 'count' => count($formattedResponse)), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
