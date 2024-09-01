<?php

namespace App\Http\Controllers;

use App\Models\EmployeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $employeeTypes = EmployeeType::all();
        return view('employeeTypes.index', compact('employeeTypes'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('employeeTypes.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:employee_types,name',
            ]);

            EmployeeType::create($validatedData);

            DB::commit();

            return redirect()->route('employee.types')->with('success', 'employees type created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.types')->with('error', 'An error occurred while creating the employee type.');
        }
    }

    public function show(int $id): \Illuminate\View\View
    {
        $employeeType = EmployeeType::findOrFail($id);
        return view('employeeTypes.show', compact('employeeType'));
    }

    public function edit(int $id): \Illuminate\View\View
    {
        $employeeType = EmployeeType::findOrFail($id);
        return view('employeeTypes.edit', compact('employeeType'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $employeeType = EmployeeType::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:employee_types,name,' . $employeeType->id,
            ]);

            $employeeType->update($validatedData);

            DB::commit();

            return redirect()->route('employee.types')->with('success', 'employees type updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.types')->with('error', 'An error occurred while updating the employee type.');
        }
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $employeeType = EmployeeType::findOrFail($id);
            $employeeType->delete();

            DB::commit();

            return redirect()->route('employee.types')->with('success', 'employees type deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.types')->with('error', 'An error occurred while deleting the employee type.');
        }
    }
}
