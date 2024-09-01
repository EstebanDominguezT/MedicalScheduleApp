<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:administrator']);
    }

    public function index(): \Illuminate\View\View
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('permissions.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required|string|unique:permissions,name|max:255',
            ]);

            Permission::create($validatedData);

            DB::commit();

            return redirect()->route('permissions')->with('status', 'Permission created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('permissions')->with('error', 'An error occurred while creating the permission');
        }
    }

    public function show($permissionId): \Illuminate\View\View
    {
        $permission = Permission::findOrFail($permissionId);
        return view('permissions.show', compact('permission'));
    }

    public function edit($permissionId): \Illuminate\View\View
    {
        $permission = Permission::findOrFail($permissionId);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $permissionId): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $permission = Permission::findOrFail($permissionId);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            ]);

            $permission->update($validatedData);

            DB::commit();

            return redirect()->route('permissions')->with('status', 'Permission updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('permissions')->with('error', 'An error occurred while updating the permission');
        }
    }

    public function destroy($permissionId): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            $permission = Permission::findOrFail($permissionId);
            $permission->delete();

            DB::commit();

            return redirect()->route('permissions')->with('status', 'Permission deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('permissions')->with('error', 'An error occurred while deleting the permission');
        }
    }
}