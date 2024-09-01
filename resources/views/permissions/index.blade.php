@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Permissions') }}</div>

                <div class="card-body">
                    @can('can-create-permission')
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create Permission</a>
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
                            @foreach ($permissions as $permission)
                                <tr>
                                    <th scope="row">{{ $permission->id }}</th>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @can('can-update-permission')
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('can-delete-permission')
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline;">
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