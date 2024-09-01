@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('employees Types') }}</div>

                    <div class="card-body">
                        <a href="{{ route('employee.types.create') }}" class="btn btn-primary mb-3">{{ __('Create employees Type') }}</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeTypes as $employeeType)
                                    <tr>
                                        <td>{{ $employeeType->id }}</td>
                                        <td>{{ $employeeType->name }}</td>
                                        <td>
                                            <a href="{{ route('employee.types.edit', $employeeType->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                            <form method="POST" action="{{ route('employee.types.destroy', $employeeType->id) }}" class="d-inline">
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