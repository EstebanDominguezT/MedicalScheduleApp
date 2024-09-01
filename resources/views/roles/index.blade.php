@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Roles') }}</div>

                <div class="card-body">
                    @can('can-create-role')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('can-add-permission-to-role')
                                            <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-primary"> Add Permissions</a>
                                        @endcan
                                        @can('can-update-role')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('can-delete-role')
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
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