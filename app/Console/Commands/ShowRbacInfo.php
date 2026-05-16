<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class ShowRbacInfo extends Command
{
    protected $signature = 'rbac:info';

    protected $description = 'Display RBAC setup information';

    public function handle()
    {
        $this->info('=== RBAC System Information ===');
        $this->newLine();

        $this->info('Roles:');
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            $this->line("  - {$role->name} ({$role->slug})");
            $this->line('    Permissions: '.$role->permissions->count());
        }
        $this->newLine();

        $this->info('Permissions:');
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $this->line("  - {$permission->name} ({$permission->slug})");
        }
        $this->newLine();

        $this->info('Users:');
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            $roleNames = $user->roles->pluck('name')->join(', ');
            $this->line("  - {$user->name} ({$user->email})");
            $this->line("    Roles: {$roleNames}");
        }

        return 0;
    }
}
