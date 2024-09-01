<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Enums\EmployeeTypesEnum;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $genders = Gender::all();
        return view('auth.register', compact('genders'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8',
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
                'role_id' => EmployeeTypesEnum::ADMINISTRATIVE,
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'person_id' => $person->id,
            ]);

            $role = Role::findOrFail(EmployeeTypesEnum::ADMINISTRATIVE);
            $user->syncRoles($role->name);

            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_type_id' => EmployeeTypesEnum::ADMINISTRATIVE,
            ]);

            DB::commit();

            return redirect()->route('/login');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('register')->with('error', 'An error occurred while creating the user');
        }
    }
}
