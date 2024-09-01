@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Work Schedule') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('work_schedule.update', $workSchedule) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="employee_id" class="form-label required">Doctor</label>
                                <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror {{ (auth()->user()->hasRole('administrator')) ? '': 'readonly-select' }}" required>
                                    <option value="">Select Doctor</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ (auth()->user()->id == $employee->user_id) ? 'selected': '' }}>{{ $employee->user->person->full_name() }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label form-label-lg">{{ __('Start Date') }}</label>
                                <input type="date" name="date" id="date" class="form-control  @error('date') is-invalid @enderror" value="{{ $workSchedule->date }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_time" class="form-label form-label-lg">{{ __('Start Time') }}</label>
                                <input type="time" name="start_time" id="start_time" class="form-control  @error('start_time') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($workSchedule->start_time)->format('H:i') }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_time" class="form-label form-label-lg">{{ __('End Time') }}</label>
                                <input type="time" name="end_time" id="end_time" class="form-control  @error('end_time') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($workSchedule->end_time)->format('H:i') }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lunch_start_time" class="form-label form-label-lg">{{ __('Lunch Start Time') }}</label>
                                <input type="time" name="lunch_start_time" id="lunch_start_time" class="form-control  @error('lunch_start_time') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($workSchedule->lunch_start_time)->format('H:i') }}">
                                @error('lunch_start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lunch_end_time" class="form-label form-label-lg">{{ __('Lunch End Time') }}</label>
                                <input type="time" name="lunch_end_time" id="lunch_end_time" class="form-control  @error('lunch_end_time') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($workSchedule->lunch_end_time)->format('H:i') }}">
                                @error('lunch_end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection