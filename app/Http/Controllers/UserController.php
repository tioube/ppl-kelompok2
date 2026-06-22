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
        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

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

        // Eager-load roles (with their permissions) and direct permissions
        $user->load('roles.permissions', 'permissions', 'revokedPermissions');

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        // Collect all permission IDs the user effectively has:
        // direct permissions + permissions from all assigned roles, minus explicit revokes
        $directPermissionIds = $user->permissions->pluck('id')->toArray();
        $rolePermissionIds = $user->roles->flatMap(fn ($role) => $role->permissions->pluck('id'))->unique()->toArray();
        $parentImpliedPermissionSlugs = $permissions
            ->whereIn('id', array_unique(array_merge($directPermissionIds, $rolePermissionIds)))
            ->flatMap(fn ($permission) => $user->getChildPermissions($permission->slug))
            ->unique()
            ->values()
            ->all();
        $parentImpliedPermissionIds = $permissions
            ->whereIn('slug', $parentImpliedPermissionSlugs)
            ->pluck('id')
            ->toArray();
        $revokedPermissionIds = $user->revokedPermissions->pluck('id')->toArray();
        $userPermissions = array_values(array_diff(array_unique(array_merge($directPermissionIds, $rolePermissionIds, $parentImpliedPermissionIds)), $revokedPermissionIds));

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
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        if (auth()->user()->isSuperAdmin()) {
            $roleIds = collect($request->input('roles', []))->map(fn ($id) => (int) $id)->all();
            $user->roles()->sync($roleIds);

            if ($request->has('permissions_submitted')) {
                $selectedPermissionIds = collect($request->input('permissions', []))
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                $rolePermissionIds = Role::with('permissions')
                    ->whereIn('id', $roleIds)
                    ->get()
                    ->flatMap(fn ($role) => $role->permissions->pluck('id'))
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                $parentImpliedPermissionIds = Permission::whereIn('id', $selectedPermissionIds->all())
                    ->get()
                    ->flatMap(fn ($permission) => $user->getChildPermissions($permission->slug))
                    ->unique()
                    ->pipe(fn ($slugs) => Permission::whereIn('slug', $slugs)->pluck('id'))
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                $inheritedPermissionIds = $rolePermissionIds
                    ->merge($parentImpliedPermissionIds)
                    ->unique()
                    ->values();

                $directPermissionIds = $selectedPermissionIds
                    ->diff($inheritedPermissionIds)
                    ->values()
                    ->all();

                $revokedPermissionIds = $inheritedPermissionIds
                    ->diff($selectedPermissionIds)
                    ->values()
                    ->all();

                \Log::info('Updating user permissions', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'selected_permission_ids' => $selectedPermissionIds->all(),
                    'direct_permission_ids' => $directPermissionIds,
                    'revoked_permission_ids' => $revokedPermissionIds,
                    'previous_permission_count' => $user->permissions()->count(),
                    'previous_revoked_count' => $user->revokedPermissions()->count(),
                ]);

                $user->permissions()->sync($directPermissionIds);
                $user->revokedPermissions()->sync($revokedPermissionIds);
                $user->load('permissions', 'revokedPermissions');

                \Log::info('User permissions updated', [
                    'user_id' => $user->id,
                    'direct_permission_slugs' => $user->permissions->pluck('slug')->toArray(),
                    'revoked_permission_slugs' => $user->revokedPermissions->pluck('slug')->toArray(),
                ]);
            } elseif ($request->has('revoked_permissions_submitted')) {
                $revokedPermissionIds = collect($request->input('revoked_permissions', []))
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values()
                    ->all();

                $user->revokedPermissions()->sync($revokedPermissionIds);
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
