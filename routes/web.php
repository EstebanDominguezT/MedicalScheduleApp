<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest', 'nocache'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'create'])->name('register.store');
});

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/getEmployees', [EmployeeController::class, 'getEmployees'])->name('dashboard.getEmployees');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('roles/{roleId}/permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.permissions');
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permissions');
    Route::resource('users', UserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::resource('employee/types', EmployeeTypeController::class, ['as' => 'employee'])->except(['show']);
    Route::resource('appointments', AppointmentController::class)->except(['show']);
    Route::get('/appointment/available-hours', [AppointmentController::class, 'availableHours'])->name('appointments.available-hours');
    Route::resource('work_schedule', WorkScheduleController::class)->except(['show']);
    Route::resource('employees', EmployeeController::class)->except(['show']);
});