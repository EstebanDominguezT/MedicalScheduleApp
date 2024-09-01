<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Person;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employeeTypes = EmployeeType::all();
        $employees = Employee::select('employees.*','users.email','persons.*','employee_types.name as employee_type','genders.name as gender')
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->join('persons', 'users.person_id', '=', 'persons.id')
        ->join('employee_types', 'employees.employee_type_id', '=', 'employee_types.id')
        ->join('genders','genders.id','=','persons.gender_id')
        ->get();

        return view('employees.index', compact('employees', 'employeeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
