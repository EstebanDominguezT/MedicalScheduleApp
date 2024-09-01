@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Work Schedules') }}</div>

                    <div class="card-body">
                        <a href="{{ route('work_schedule.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('employees') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Lunch Start') }}</th>
                                    <th>{{ __('Lunch End') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workSchedules as $workSchedule)
                                    <tr>
                                        <td>{{ $workSchedule->employee->user->person->full_name() }}</td>
                                        <td>{{ $workSchedule->start_time }}</td>
                                        <td>{{ $workSchedule->end_time }}</td>
                                        <td>{{ $workSchedule->lunch_start_time }}</td>
                                        <td>{{ $workSchedule->lunch_end_time }}</td>
                                        <td>
                                            <a href="{{ route('work_schedule.edit', $workSchedule) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                            <form action="{{ route('work_schedule.destroy', $workSchedule) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection