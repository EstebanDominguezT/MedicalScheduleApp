<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrator']);
    }

    public function index(): \Illuminate\View\View
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('roles.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles,name|max:255',
            ]);

            Role::create($validatedData);

            DB::commit();

            return redirect()->route('roles')->with('status', 'Role created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles')->with('error', 'An error occurred while creating the role');
        }
    }

    public function show($roleId): \Illuminate\View\View
    {
        $role = Role::findOrFail($roleId);
        return view('roles.show', compact('role'));
    }

    public function edit($roleId): \Illuminate\View\View
    {
        $role = Role::findOrFail($roleId);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $roleId): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = Role::findOrFail($roleId);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            ]);

            $role->update($validatedData);

            DB::commit();

            return redirect()->route('roles')->with('status', 'Role updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles')->with('error', 'An error occurred while updating the role');
        }
    }

    public function destroy($roleId): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = Role::findOrFail($roleId);
            $role->delete();

            DB::commit();

            return redirect()->route('roles')->with('status', 'Role deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles')->with('error', 'An error occurred while deleting the role');
        }
    }

    public function addPermissionToRole($roleId): \Illuminate\View\View
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $permissions = Permission::all();
        $assignedPermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.add-permissions', compact('role', 'permissions', 'assignedPermissions'));
    }

    public function givePermissionToRole(Request $request, $roleId): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = Role::findOrFail($roleId);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return redirect()->route('roles')->with('status', 'Permissions assigned to role successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles')->with('error', 'An error occurred while assigning permissions to the role');
        }
    }
}
