@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Work Schedules') }}</div>

                    <div class="card-body">
                        @can('can-create-work-schedule')
                            <a href="{{ route('work_schedule.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
                        @endcan
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
                                        <td style="width: 100px">
                                            @can('can-update-work-schedule')
                                                <a href="{{ route('work_schedule.edit', $workSchedule) }}" class="btn btn-primary mb-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                            @endcan
                                            @can('can-delete-work-schedule')
                                                <form action="{{ route('work_schedule.destroy', $workSchedule) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mb-2"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            @endcan
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