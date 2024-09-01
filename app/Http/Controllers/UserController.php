<?php

namespace App\Http\Controllers;

use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): \Illuminate\View\View
    {
        $users = User::with('roles', 'employee', 'person')->get();
        return view('users.index', compact('users'));
    }

    public function show($id): \Illuminate\View\View
    {
        $user = User::with('roles', 'employee', 'person')->findOrFail($id);
        return view('user', compact('user'));
    }

    public function create(): \Illuminate\View\View
    {
        $roles = Role::all();
        $genders = Gender::all();
        $employeeTypes = EmployeeType::all();
        return view('users.create', compact('roles', 'genders', 'employeeTypes'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8',
                'role_id' => ['required', Rule::exists('roles', 'id')],
                'employee_type_id' => ['required', Rule::in([EmployeeTypesEnum::DOCTOR, EmployeeTypesEnum::ADMINISTRATIVE])],
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender_id' => ['required', Rule::exists('genders', 'id')],
                'date_of_birth' => 'nullable|date|before:today',
                'national_id' => 'nullable|string|max:50|unique:persons,national_id',
                'address' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:20',
                'phone_number' => 'nullable|string|max:50|unique:persons,phone_number',
            ]);

            $person = Person::create($validatedData);

            $user = User::create([
                'role_id' => $validatedData['role_id'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'person_id' => $person->id,
            ]);

            $role = Role::findOrFail($validatedData['role_id']);
            $user->syncRoles($role->name);

            Employee::create([
                'user_id' => $user->id,
                'employee_type_id' => $validatedData['employee_type_id'],
            ]);

            DB::commit();

            return redirect()->route('users')->with('status', 'User created successfully with roles');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users')->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }

    public function edit(int $id): \Illuminate\View\View
    {
        $user = User::with('person', 'employee')->findOrFail($id);
        $roles = Role::all();
        $genders = Gender::all();
        $employeeTypes = EmployeeType::all();

        return view('users.edit', compact('user', 'roles', 'genders', 'employeeTypes'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $person = $user->person;

            $validatedData = $request->validate([
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
                'password' => 'nullable|string|min:8|confirmed',
                'role_id' => ['required', Rule::exists('roles', 'id')],
                'employee_type_id' => ['required', Rule::in([EmployeeTypesEnum::DOCTOR, EmployeeTypesEnum::ADMINISTRATIVE])],
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender_id' => ['required', Rule::exists('genders', 'id')],
                'date_of_birth' => 'nullable|date|before:today',
                'national_id' => ['nullable', 'string', 'max:50', Rule::unique('persons', 'national_id')
                    ->where(function ($query) use ($person) {
                        $query->where('id', '!=', $person->id);
                    }),
                ],
                'address' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:20',
                'phone_number' => ['nullable', 'string', 'max:50', Rule::unique('persons', 'phone_number')->ignore($person->id)],
            ]);

            $person->update($validatedData);
            $user->update([
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            ]);
            $role = Role::findOrFail($validatedData['role_id']);
            $user->syncRoles($role->name);
            $user->employee->update([
                'employee_type_id' => $validatedData['employee_type_id'],
            ]);

            DB::commit();

            return redirect()->route('users')->with('status', 'User updated successfully with roles');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users')->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::with('employee', 'person')->findOrFail($id);

            if ($user->employee) {
                $user->employee->delete();
            }

            $person = Person::findOrFail($user->person->id);
            $user->delete();
            $person->delete();

            DB::commit();

            return redirect()->route('users')->with('status', 'User deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users')->with('error', 'An error occurred while deleting the user: ' . $e->getMessage());
        }
    }
}
