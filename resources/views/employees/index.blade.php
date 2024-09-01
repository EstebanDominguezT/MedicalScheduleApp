@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Employees') }}</div>

                    <div class="card-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Gender') }}</th>
                                    <th scope="col">{{ __('Birthday') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <th scope="row">{{ $employee->id }}</th>
                                        <td>{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->gender  }}</td>
                                        <td>{{ $employee->date_of_birth  }}</td>
                                        <td>{{ $employee->phone_number }}</td>
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