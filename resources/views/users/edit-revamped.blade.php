@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb
        pageTitle="Edit User"
        :breadcrumbs="[
            ['name' => 'Users', 'url' => route('users.index')],
            ['name' => 'Edit User', 'url' => null]
        ]"
    />

    <div class="space-y-6">
        <!-- User Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center space-x-4">
                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    <div class="flex items-center mt-2 space-x-2">
                        @foreach($user->roles as $role)
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
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $badgeColor }}">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Member since</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button type="button" onclick="showTab('basic-info')" id="tab-basic-info" class="tab-button active border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600 dark:text-blue-400">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Basic Info</span>
                        </div>
                    </button>

                    @superadmin
                    <button type="button" onclick="showTab('roles')" id="tab-roles" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a2.25 2.25 0 01-2.25 2.25 2.25 2.25 0 01-2.25-2.25 2.25 2.25 0 012.25-2.25 2.25 2.25 0 012.25 2.25zm-7.5-4.5a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                            <span>Roles</span>
                        </div>
                    </button>

                    <button type="button" onclick="showTab('permissions')" id="tab-permissions" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Permissions</span>
                        </div>
                    </button>

                    <button type="button" onclick="showTab('revoked')" id="tab-revoked" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            <span>Revoked Access</span>
                        </div>
                    </button>
                    @endsuperadmin
                </nav>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" id="user-form">
                @csrf
                @method('PUT')

                <!-- Basic Information Tab -->
                <div id="content-basic-info" class="tab-content p-6">
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Basic Information</h3>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-forms.input
                                        label="Full Name"
                                        name="name"
                                        :value="$user->name"
                                        required
                                        placeholder="Enter full name"
                                    />
                                </div>
                                <div>
                                    <x-forms.input
                                        label="Email Address"
                                        name="email"
                                        type="email"
                                        :value="$user->email"
                                        required
                                        placeholder="Enter email address"
                                    />
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Password Settings</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-forms.input
                                            label="New Password"
                                            name="password"
                                            type="password"
                                            placeholder="Leave blank to keep current password"
                                        />
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Minimum 8 characters. Leave blank if you don't want to change the password.
                                        </p>
                                    </div>
                                    <div>
                                        <x-forms.input
                                            label="Confirm Password"
                                            name="password_confirmation"
                                            type="password"
                                            placeholder="Confirm new password"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">Account Status</h4>
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Account Created</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Last Updated</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @superadmin
                <!-- Roles Tab -->
                <div id="content-roles" class="tab-content hidden p-6">
                    <div class="max-w-4xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Role Assignment</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Assign roles to control user access levels and default permissions.</p>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Current roles: <span class="font-medium">{{ $user->roles->count() }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($roles as $role)
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    id="role_{{ $role->id }}"
                                    {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                    class="sr-only peer"
                                >
                                <label for="role_{{ $role->id }}" class="block cursor-pointer rounded-lg border-2 border-gray-200 dark:border-gray-700 p-4 hover:border-gray-300 dark:hover:border-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $role->name }}</h4>
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
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                <span class="font-medium">{{ $role->permissions->count() }} permissions</span>
                                                @if($role->permissions->count() > 0)
                                                    <div class="mt-1">{{ $role->permissions->pluck('name')->take(2)->implode(', ') }}
                                                    @if($role->permissions->count() > 2)
                                                        <span class="text-gray-400">... +{{ $role->permissions->count() - 2 }} more</span>
                                                    @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-2">
                                            <div class="peer-checked:block hidden">
                                                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Role Information</h4>
                                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                                        <p>Roles provide a set of default permissions. Users can have multiple roles, and permissions are cumulative.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Tab -->
                <div id="content-permissions" class="tab-content hidden p-6">
                    <div class="max-w-6xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Direct Permissions</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Grant specific permissions that override role-based permissions.</p>
                            </div>
                            <div id="permission-counter" class="text-sm text-gray-500 dark:text-gray-400">
                                Selected: <span class="font-medium">0</span> permissions
                            </div>
                        </div>

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

                        <div class="space-y-4">
                            @foreach($permissionCategories as $category => $slugs)
                                @php
                                    $categoryPermissions = $permissions->whereIn('slug', $slugs);
                                @endphp

                                @if($categoryPermissions->count() > 0)
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4" data-category-permissions="{{ Str::slug($category) }}">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $category }}</h4>
                                            <div class="flex gap-2">
                                                <button type="button" onclick="selectAllInCategory('{{ Str::slug($category) }}')" class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                                    Select All
                                                </button>
                                                <span class="text-gray-400">|</span>
                                                <button type="button" onclick="selectNoneInCategory('{{ Str::slug($category) }}')" class="text-xs text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 font-medium">
                                                    Select None
                                                </button>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($categoryPermissions as $permission)
                                                <div class="relative">
                                                    <input
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission_{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                                        class="sr-only peer permission-checkbox"
                                                        data-slug="{{ $permission->slug }}"
                                                        data-category="{{ Str::slug($category) }}"
                                                    >
                                                    <label for="permission_{{ $permission->id }}" class="block cursor-pointer rounded-lg border border-gray-200 dark:border-gray-600 p-3 hover:border-gray-300 dark:hover:border-gray-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permission->name }}</p>
                                                                @if($permission->description)
                                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($permission->description, 50) }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="ml-2">
                                                                <div class="peer-checked:block hidden">
                                                                    <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Important</h4>
                                    <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                                        <p>Direct permissions override role-based permissions and will take priority. Use carefully to avoid security issues.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revoked Permissions Tab -->
                <div id="content-revoked" class="tab-content hidden p-6">
                    <div class="max-w-6xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Revoked Permissions</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Block specific permissions even if granted through roles.</p>
                            </div>
                            <div id="revoked-counter" class="text-sm text-gray-500 dark:text-gray-400">
                                Revoked: <span class="font-medium">0</span> permissions
                            </div>
                        </div>

                        @php
                            $userRevokedPermissions = $user->revokedPermissions->pluck('id')->toArray();
                        @endphp

                        <div class="space-y-4">
                            @foreach($permissionCategories as $category => $slugs)
                                @php
                                    $categoryPermissions = $permissions->whereIn('slug', $slugs);
                                @endphp

                                @if($categoryPermissions->count() > 0)
                                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-lg p-4" data-category-revoked="{{ Str::slug($category) }}">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-semibold text-red-800 dark:text-red-300">{{ $category }}</h4>
                                            <div class="flex gap-2">
                                                <button type="button" onclick="selectAllRevoked('{{ Str::slug($category) }}')" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                    Revoke All
                                                </button>
                                                <span class="text-red-400">|</span>
                                                <button type="button" onclick="selectNoneRevoked('{{ Str::slug($category) }}')" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                    Restore All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($categoryPermissions as $permission)
                                                <div class="relative">
                                                    <input
                                                        type="checkbox"
                                                        name="revoked_permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="revoked_permission_{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userRevokedPermissions) ? 'checked' : '' }}
                                                        class="sr-only peer revoked-checkbox"
                                                        data-slug="{{ $permission->slug }}"
                                                        data-category="{{ Str::slug($category) }}"
                                                    >
                                                    <label for="revoked_permission_{{ $permission->id }}" class="block cursor-pointer rounded-lg border border-red-200 dark:border-red-700 p-3 hover:border-red-300 dark:hover:border-red-600 peer-checked:border-red-500 peer-checked:bg-red-100 dark:peer-checked:bg-red-900/30 transition-all">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-red-900 dark:text-red-200">{{ $permission->name }}</p>
                                                                @if($permission->description)
                                                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ Str::limit($permission->description, 50) }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="ml-2">
                                                                <div class="peer-checked:block hidden">
                                                                    <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-red-800 dark:text-red-300">Warning</h4>
                                    <div class="mt-1 text-sm text-red-700 dark:text-red-400">
                                        <p>Revoked permissions will deny access even if the user has the permission through their role. This overrides all other permission grants.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endsuperadmin

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('users.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="resetForm()"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2 bg-blue-600 dark:bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update User
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
// Tab Management
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });

    // Show selected tab content
    document.getElementById(`content-${tabName}`).classList.remove('hidden');

    // Add active class to selected tab button
    const activeTab = document.getElementById(`tab-${tabName}`);
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
}

// Permission Management Functions
function selectAllInCategory(categorySlug) {
    const container = document.querySelector(`[data-category-permissions="${categorySlug}"]`);
    if (container) {
        const checkboxes = container.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(cb => cb.checked = true);
        updatePermissionCounter();
    }
}

function selectNoneInCategory(categorySlug) {
    const container = document.querySelector(`[data-category-permissions="${categorySlug}"]`);
    if (container) {
        const checkboxes = container.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updatePermissionCounter();
    }
}

function selectAllRevoked(categorySlug) {
    const container = document.querySelector(`[data-category-revoked="${categorySlug}"]`);
    if (container) {
        const checkboxes = container.querySelectorAll('.revoked-checkbox');
        checkboxes.forEach(cb => cb.checked = true);
        updateRevokedCounter();
    }
}

function selectNoneRevoked(categorySlug) {
    const container = document.querySelector(`[data-category-revoked="${categorySlug}"]`);
    if (container) {
        const checkboxes = container.querySelectorAll('.revoked-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        updateRevokedCounter();
    }
}

function updatePermissionCounter() {
    const checkedPermissions = document.querySelectorAll('.permission-checkbox:checked').length;
    const counter = document.querySelector('#permission-counter span');
    if (counter) {
        counter.textContent = checkedPermissions;
    }
}

function updateRevokedCounter() {
    const checkedRevoked = document.querySelectorAll('.revoked-checkbox:checked').length;
    const counter = document.querySelector('#revoked-counter span');
    if (counter) {
        counter.textContent = checkedRevoked;
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.getElementById('user-form').reset();
        updatePermissionCounter();
        updateRevokedCounter();
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to permission checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updatePermissionCounter();

            // Handle conflicts with revoked permissions
            const permissionSlug = this.getAttribute('data-slug');
            const revokedCheckbox = document.querySelector(`input[name="revoked_permissions[]"][data-slug="${permissionSlug}"]`);

            if (this.checked && revokedCheckbox && revokedCheckbox.checked) {
                revokedCheckbox.checked = false;
                updateRevokedCounter();
            }
        });
    });

    // Add event listeners to revoked permission checkboxes
    document.querySelectorAll('.revoked-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateRevokedCounter();

            // Handle conflicts with direct permissions
            const permissionSlug = this.getAttribute('data-slug');
            const directCheckbox = document.querySelector(`input[name="permissions[]"][data-slug="${permissionSlug}"]`);

            if (this.checked && directCheckbox && directCheckbox.checked) {
                directCheckbox.checked = false;
                updatePermissionCounter();
            }
        });
    });

    // Initialize counters
    updatePermissionCounter();
    updateRevokedCounter();
});
</script>
@endpush

@endsection
