@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Appointments') }}</div>

                    <div class="card-body">
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Create Appointment</a>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Employee</th>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Session Start At</th>
                                    <th scope="col">Session End At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <th scope="row">{{ $appointment->id }}</th>
                                        <td>{{ $appointment->patient->user->person->full_name() }}</td>
                                        <td>{{ $appointment->doctor->user->person->full_name() }}</td>
                                        <td>{{ $appointment->start_datetime }}</td>
                                        <td>{{ $appointment->end_datetime }}</td>
                                        <td>
                                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
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