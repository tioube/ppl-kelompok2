<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Format: role_or_permission:role1,role2|permission1,permission2
     * Example: role_or_permission:super-admin,admin|manage-users,view-users
     */
    public function handle(Request $request, Closure $next, string $roleOrPermission): Response
    {
        if (! auth()->check()) {
            abort(403, 'Unauthorized access.');
        }

        $user = auth()->user();

        // Parse the parameter to separate roles and permissions
        [$rolesPart, $permissionsPart] = explode('|', $roleOrPermission.'|');

        $roles = array_filter(explode(',', $rolesPart));
        $permissions = array_filter(explode(',', $permissionsPart));

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($user->hasRole(trim($role))) {
                return $next($request);
            }
        }

        // Check if user has any of the required permissions
        foreach ($permissions as $permission) {
            if ($user->hasPermission(trim($permission))) {
                return $next($request);
            }
        }

        abort(403, 'You do not have the required role or permission to access this resource.');
    }
}
