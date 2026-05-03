@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit User" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Edit: {{ $user->name }}
                </h3>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div>
                    <x-forms.input label="Name" name="name" :value="$user->name" required />
                </div>

                <div class="mt-4">
                    <x-forms.input label="Email" name="email" :value="$user->email" required />
                </div>

                <div class="mt-4">
                    <x-forms.input label="Password" name="password" type="password" placeholder="Leave blank to keep current password" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave blank if you don't want to change the password</p>
                </div>

                <div class="mt-4">
                    <x-forms.input label="Confirm Password" name="password_confirmation" type="password" placeholder="Confirm new password" />
                </div>

                @superadmin
                <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Role & Permission Management</h4>

                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Assign Roles</label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($roles as $role)
                            <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input
                                            type="checkbox"
                                            name="roles[]"
                                            value="{{ $role->id }}"
                                            id="role_{{ $role->id }}"
                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                        >
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <label for="role_{{ $role->id }}" class="cursor-pointer">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                                                @php
                                                    $badgeColor = match($role->slug) {
                                                        'super-admin' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                        'admin' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                                        'akademik' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                        'guru' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                        'siswa' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $badgeColor }}">
                                                    {{ ucfirst($role->slug) }}
                                                </span>
                                            </div>
                                            @if($role->description)
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">{{ $role->description }}</p>
                                            @endif
                                            @if($role->permissions->count() > 0)
                                                <div class="text-xs text-gray-500 dark:text-gray-500">
                                                    <span class="font-medium">{{ $role->permissions->count() }} permissions:</span>
                                                    {{ $role->permissions->pluck('name')->take(3)->implode(', ') }}
                                                    @if($role->permissions->count() > 3)
                                                        <span class="text-gray-400">... +{{ $role->permissions->count() - 3 }} more</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-xs text-gray-400 dark:text-gray-500">No permissions assigned</div>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Direct Permissions (Override)</label>

                        @php
                            $permissionCategories = [
                                'System & Dashboard' => ['view-dashboard', 'view-settings', 'manage-settings'],
                                'User Management' => ['manage-users', 'view-users', 'create-users', 'edit-users', 'delete-users', 'manage-roles', 'manage-permissions'],
                                'Academic Data Management' => ['manage-academic', 'view-academic'],
                                'Subject Management' => ['manage-mata-pelajaran', 'view-mata-pelajaran', 'create-mata-pelajaran', 'edit-mata-pelajaran', 'delete-mata-pelajaran'],
                                'Silabus Management' => ['manage-silabus', 'view-silabus', 'create-silabus', 'edit-silabus', 'delete-silabus', 'approve-silabus'],
                                'Student Management' => ['manage-siswa', 'view-siswa', 'create-siswa', 'edit-siswa', 'delete-siswa'],
                                'Academic Year Management' => ['manage-tahun-ajaran', 'view-tahun-ajaran', 'create-tahun-ajaran', 'edit-tahun-ajaran', 'delete-tahun-ajaran'],
                                'Department Management' => ['manage-jurusan', 'view-jurusan', 'create-jurusan', 'edit-jurusan', 'delete-jurusan'],
                                'Class Management' => ['manage-classes', 'view-classes', 'manage-kelas', 'view-kelas', 'create-kelas', 'edit-kelas', 'delete-kelas'],
                                'Teacher Management' => ['manage-guru', 'view-guru', 'create-guru', 'edit-guru', 'delete-guru'],
                                'Teacher-Subject-Class Management' => ['manage-guru-mapel-kelas', 'view-guru-mapel-kelas', 'create-guru-mapel-kelas', 'edit-guru-mapel-kelas', 'delete-guru-mapel-kelas', 'generate-guru-mapel-kelas', 'clear-guru-mapel-kelas'],
                                'Schedule Management' => ['manage-jadwal-pelajaran', 'view-jadwal-pelajaran', 'create-jadwal-pelajaran', 'edit-jadwal-pelajaran', 'delete-jadwal-pelajaran', 'manage-schedules', 'view-schedules', 'create-schedules', 'generate-schedules', 'swap-schedules', 'move-schedules'],
                                'Assessment & Grading' => ['manage-grades', 'view-grades', 'view-own-grades'],
                                'Attendance Management' => ['manage-attendance', 'view-attendance'],
                            ];
                        @endphp

                        <div class="space-y-6">
                            @foreach($permissionCategories as $category => $slugs)
                                @php
                                    $categoryPermissions = $permissions->whereIn('slug', $slugs);
                                @endphp

                                @if($categoryPermissions->count() > 0)
                                    <div class="rounded-lg border border-gray-200 bg-gray-50/50 p-4 dark:border-gray-700 dark:bg-gray-800/30" data-category-permissions="{{ $category }}">
                                        <h5 class="mb-3 text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $category }}</h5>
                                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                            @foreach($categoryPermissions as $permission)
                                                <div class="flex items-start">
                                                    <div class="flex h-5 items-center">
                                                        <input
                                                            type="checkbox"
                                                            name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            id="permission_{{ $permission->id }}"
                                                            {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                                            data-slug="{{ $permission->slug }}"
                                                        >
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="permission_{{ $permission->id }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                                            {{ $permission->name }}
                                                        </label>
                                                        @if($permission->description)
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-4 rounded-lg border-l-4 border-blue-400 bg-blue-50 p-4 dark:bg-blue-900/20 dark:border-blue-600">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Permission Summary</h4>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                        <div id="permission-summary" class="space-y-1">
                                            <!-- Will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 rounded-lg border-l-4 border-yellow-400 bg-yellow-50 p-4 dark:bg-yellow-900/20 dark:border-yellow-600">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                        <strong>Important:</strong> Direct permissions override role-based permissions. These will take priority over any permissions granted through roles. Use carefully to avoid security issues.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endsuperadmin

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Update User
                    </button>

                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role permissions data
    const rolePermissions = @json($roles->load('permissions')->mapWithKeys(function($role) {
        return [$role->id => $role->permissions->pluck('slug')->toArray()];
    }));

    // Permission names mapping
    const permissionNames = @json($permissions->pluck('name', 'slug'));

    // Get all role checkboxes
    const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
    const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
    const summaryContainer = document.getElementById('permission-summary');

    // Function to update permission summary
    function updatePermissionSummary() {
        const checkedRoles = Array.from(roleCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));

        const checkedDirectPermissions = Array.from(permissionCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.getAttribute('data-slug'));

        // Get all permissions from checked roles
        let allRolePermissions = [];
        checkedRoles.forEach(roleId => {
            if (rolePermissions[roleId]) {
                allRolePermissions = [...allRolePermissions, ...rolePermissions[roleId]];
            }
        });

        // Remove duplicates and combine with direct permissions
        allRolePermissions = [...new Set(allRolePermissions)];
        const allPermissions = [...new Set([...allRolePermissions, ...checkedDirectPermissions])];

        // Update summary
        if (summaryContainer) {
            summaryContainer.innerHTML = `
                <p><strong>Total Permissions:</strong> ${allPermissions.length}</p>
                <p><strong>Via Roles:</strong> ${allRolePermissions.length}</p>
                <p><strong>Direct Override:</strong> ${checkedDirectPermissions.length}</p>
                ${allPermissions.length > 0 ?
                    `<details class="mt-2">
                        <summary class="cursor-pointer text-xs text-blue-600 dark:text-blue-400">View all permissions</summary>
                        <ul class="mt-1 text-xs space-y-0.5 ml-4">
                            ${allPermissions.map(slug => `<li>• ${permissionNames[slug] || slug}</li>`).join('')}
                        </ul>
                    </details>` :
                    '<p class="text-xs text-gray-500">No permissions assigned</p>'
                }
            `;
        }
    }

    // Function to update permission preview
    function updatePermissionPreview() {
        const checkedRoles = Array.from(roleCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));

        // Get all permissions from checked roles
        let allRolePermissions = [];
        checkedRoles.forEach(roleId => {
            if (rolePermissions[roleId]) {
                allRolePermissions = [...allRolePermissions, ...rolePermissions[roleId]];
            }
        });

        // Remove duplicates
        allRolePermissions = [...new Set(allRolePermissions)];

        // Update visual indicators for permissions that would be granted by roles
        permissionCheckboxes.forEach(cb => {
            const permissionSlug = cb.getAttribute('data-slug');
            const label = cb.closest('.flex').querySelector('label');
            const container = cb.closest('.flex');

            if (allRolePermissions.includes(permissionSlug)) {
                // This permission would be granted by role
                container.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'border-l-2', 'border-blue-400', 'pl-2');
                if (!label.querySelector('.role-granted-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'role-granted-badge inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 ml-2';
                    badge.textContent = 'Via Role';
                    label.appendChild(badge);
                }
            } else {
                // Remove role granted styling
                container.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-l-2', 'border-blue-400', 'pl-2');
                const existingBadge = label.querySelector('.role-granted-badge');
                if (existingBadge) {
                    existingBadge.remove();
                }
            }
        });

        // Update summary
        updatePermissionSummary();
    }

    // Add data-slug attribute to permission checkboxes
    @foreach($permissions as $permission)
        document.getElementById('permission_{{ $permission->id }}')?.setAttribute('data-slug', '{{ $permission->slug }}');
    @endforeach

    // Add event listeners to role checkboxes
    roleCheckboxes.forEach(cb => {
        cb.addEventListener('change', updatePermissionPreview);
    });

    // Add event listeners to permission checkboxes for summary update
    permissionCheckboxes.forEach(cb => {
        cb.addEventListener('change', updatePermissionSummary);
    });

    // Initial preview update
    updatePermissionPreview();

    // Add select all/none functionality for permissions in each category
    document.querySelectorAll('[data-category-permissions]').forEach(container => {
        const categoryName = container.getAttribute('data-category-permissions');
        const checkboxes = container.querySelectorAll('input[name="permissions[]"]');

        // Create select all/none buttons
        const buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'flex gap-2 mb-2';
        buttonsContainer.innerHTML = `
            <button type="button" class="select-all-btn text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline" data-category="${categoryName}">
                Select All
            </button>
            <span class="text-gray-400">|</span>
            <button type="button" class="select-none-btn text-xs text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 underline" data-category="${categoryName}">
                Select None
            </button>
        `;

        const categoryHeader = container.querySelector('h5');
        categoryHeader.parentNode.insertBefore(buttonsContainer, categoryHeader.nextSibling);

        // Add event listeners
        buttonsContainer.querySelector('.select-all-btn').addEventListener('click', () => {
            checkboxes.forEach(cb => cb.checked = true);
            updatePermissionSummary();
        });

        buttonsContainer.querySelector('.select-none-btn').addEventListener('click', () => {
            checkboxes.forEach(cb => cb.checked = false);
            updatePermissionSummary();
        });
    });
});
</script>
@endpush

