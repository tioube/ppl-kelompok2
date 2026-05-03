<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (! auth()->user()->hasPermission('manage-users') && ! auth()->user()->hasPermission('create-users')) {
            abort(403, 'You do not have permission to create users.');
        }

        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-users') && ! auth()->user()->hasPermission('create-users')) {
            abort(403, 'You do not have permission to create users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        if (! empty($validated['permissions'])) {
            $user->permissions()->sync($validated['permissions']);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        if (! auth()->user()->hasPermission('manage-users') && ! auth()->user()->hasPermission('edit-users')) {
            abort(403, 'You do not have permission to edit users.');
        }

        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'permissions', 'userRoles', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        if (! auth()->user()->hasPermission('manage-users') && ! auth()->user()->hasPermission('edit-users')) {
            abort(403, 'You do not have permission to edit users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        if (auth()->user()->isSuperAdmin()) {
            if ($request->has('roles')) {
                $user->roles()->sync($request->roles ?? []);
            }

            if ($request->has('permissions')) {
                $user->permissions()->sync($request->permissions ?? []);
            }

            // Handle revoked permissions - check for the indicator field instead of the array itself
            if ($request->has('revoked_permissions_submitted')) {
                $revokedPermissionIds = $request->revoked_permissions ?? [];

                // Debug logging
                \Log::info('Updating revoked permissions', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'revoked_permission_ids' => $revokedPermissionIds,
                    'previous_revoked_count' => $user->revokedPermissions()->count()
                ]);

                $user->revokedPermissions()->sync($revokedPermissionIds);

                // Force refresh the relationship
                $user->load('revokedPermissions');

                // Debug logging after sync
                \Log::info('Revoked permissions updated', [
                    'user_id' => $user->id,
                    'new_revoked_count' => $user->revokedPermissions()->count(),
                    'revoked_permission_slugs' => $user->revokedPermissions->pluck('slug')->toArray()
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if (! auth()->user()->hasPermission('manage-users') && ! auth()->user()->hasPermission('delete-users')) {
            abort(403, 'You do not have permission to delete users.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
