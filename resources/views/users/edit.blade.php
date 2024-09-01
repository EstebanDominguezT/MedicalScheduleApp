@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT') <!-- Usamos PUT o PATCH para actualizar -->

                            <!-- Email -->
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password (Optional, leave blank if not changing) -->
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <small class="form-text text-muted">
                                        Leave blank if you don't want to change the password.
                                    </small>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="row mb-3">
                                <label for="role_id" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                                <div class="col-md-6">
                                    <select id="role_id" class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->first()->id == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- employees Type -->
                            <div class="row mb-3">
                                <label for="employee_type_id" class="col-md-4 col-form-label text-md-end">{{ __('employees Type') }}</label>

                                <div class="col-md-6">
                                    <select id="employee_type_id" class="form-select @error('employee_type_id') is-invalid @enderror" name="employee_type_id" required>
                                        @foreach ($employeeTypes as $employeeType)
                                            <option value="{{ $employeeType->id }}" {{ $user->employee->employee_type_id == $employeeType->id ? 'selected' : '' }}>
                                                {{ $employeeType->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('employee_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->person->first_name) }}" required autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Middle Name -->
                            <div class="row mb-3">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                                <div class="col-md-6">
                                    <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', $user->person->middle_name) }}">

                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->person->last_name) }}" required>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="row mb-3">
                                <label for="gender_id" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                                <div class="col-md-6">
                                    <select id="gender_id" class="form-select @error('gender_id') is-invalid @enderror" name="gender_id" required>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->id }}" {{ $user->person->gender_id == $gender->id ? 'selected' : '' }}>
                                                {{ $gender->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('gender_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="row mb-3">
                                <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $user->person->date_of_birth) }}">

                                    @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- National ID -->
                            <div class="row mb-3">
                                <label for="national_id" class="col-md-4 col-form-label text-md-end">{{ __('National ID') }}</label>

                                <div class="col-md-6">
                                    <input id="national_id" type="text" class="form-control @error('national_id') is-invalid @enderror" name="national_id" value="{{ old('national_id', $user->person->national_id) }}">

                                    @error('national_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->person->address) }}">

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Postal Code -->
                            <div class="row mb-3">
                                <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('Postal Code') }}</label>

                                <div class="col-md-6">
                                    <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code', $user->person->postal_code) }}">

                                    @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="row mb-3">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $user->person->phone_number) }}">

                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
