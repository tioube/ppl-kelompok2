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
                <div class="h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 1114 0H5z" clip-rule="evenodd" />
                    </svg>
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
                    <button type="button" onclick="showTab('user-permissions')" id="tab-user-permissions" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>User Permissions</span>
                        </div>
                    </button>
                    @endsuperadmin
                </nav>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" id="user-form">
                @csrf
                @method('PUT')

                @superadmin
                <!-- Hidden inputs to ensure field handling is always triggered -->
                <input type="hidden" name="permissions_submitted" value="1">
                <input type="hidden" name="revoked_permissions_submitted" value="1">
                @endsuperadmin

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
                        'Assessment & Grading' => ['manage-nilai', 'view-nilai', 'view-own-nilai'],
                        'Attendance Management' => ['manage-attendance', 'view-attendance'],
                        'Jurnal Mengajar Management' => ['manage-jurnal-mengajar', 'view-jurnal-mengajar', 'create-jurnal-mengajar', 'edit-jurnal-mengajar', 'delete-jurnal-mengajar'],
                        'Kenaikan Kelas Management' => ['manage-kenaikan-kelas', 'view-kenaikan-kelas', 'process-kenaikan-kelas', 'manage-kelulusan'],
                        'Mata Pelajaran Tahun Ajaran Mapping' => ['manage-mapel-tahun-ajaran', 'view-mapel-tahun-ajaran'],
                    ];
                @endphp

                <!-- User Permissions Tab (Roles + Effective Permissions) -->
                <div id="content-user-permissions" class="tab-content hidden">

                    <!-- ── Section 1: Roles ──────────────────────────────────────── -->
                    <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 bg-white dark:bg-gray-800">
                        <button type="button" onclick="toggleMainBox('box-roles')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors text-left focus:outline-none">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/40">
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Roles</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Assign roles to control access levels and default permissions.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="roles-selected-summary" class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/40 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-400">{{ $user->roles->count() }} assigned</span>
                                <svg id="box-roles-icon" class="h-5 w-5 text-gray-400 transition-transform duration-200 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </button>

                        <div id="box-roles" class="px-6 pb-6 pt-2">
                            <div class="flex flex-wrap gap-2">
                                @foreach($roles as $role)
                                    @php
                                        $badgeColor = match($role->slug) {
                                            'super-admin' => ['border' => 'border-red-300 dark:border-red-700', 'checked' => 'peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white dark:peer-checked:bg-red-600', 'text' => 'text-red-700 dark:text-red-300', 'hover' => 'hover:border-red-400'],
                                            'admin'       => ['border' => 'border-orange-300 dark:border-orange-700', 'checked' => 'peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-checked:text-white dark:peer-checked:bg-orange-600', 'text' => 'text-orange-700 dark:text-orange-300', 'hover' => 'hover:border-orange-400'],
                                            'akademik'    => ['border' => 'border-blue-300 dark:border-blue-700', 'checked' => 'peer-checked:bg-blue-500 peer-checked:border-blue-500 peer-checked:text-white dark:peer-checked:bg-blue-600', 'text' => 'text-blue-700 dark:text-blue-300', 'hover' => 'hover:border-blue-400'],
                                            'guru'        => ['border' => 'border-green-300 dark:border-green-700', 'checked' => 'peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white dark:peer-checked:bg-green-600', 'text' => 'text-green-700 dark:text-green-300', 'hover' => 'hover:border-green-400'],
                                            'siswa'       => ['border' => 'border-purple-300 dark:border-purple-700', 'checked' => 'peer-checked:bg-purple-500 peer-checked:border-purple-500 peer-checked:text-white dark:peer-checked:bg-purple-600', 'text' => 'text-purple-700 dark:text-purple-300', 'hover' => 'hover:border-purple-400'],
                                            default       => ['border' => 'border-gray-300 dark:border-gray-600', 'checked' => 'peer-checked:bg-gray-600 peer-checked:border-gray-600 peer-checked:text-white dark:peer-checked:bg-gray-500', 'text' => 'text-gray-700 dark:text-gray-300', 'hover' => 'hover:border-gray-400'],
                                        };
                                    @endphp
                                    <div class="relative">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                            class="sr-only peer role-checkbox"
                                            data-permissions="{{ json_encode($role->permissions->pluck('id')->toArray()) }}">
                                        <label for="role_{{ $role->id }}"
                                            class="flex cursor-pointer items-center gap-2 rounded-full border-2 px-4 py-1.5 text-sm font-semibold transition-all select-none
                                                   {{ $badgeColor['border'] }} {{ $badgeColor['text'] }} {{ $badgeColor['hover'] }} {{ $badgeColor['checked'] }}">
                                            <svg class="h-3.5 w-3.5 opacity-0 peer-checked:opacity-100 flex-shrink-0 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $role->name }}
                                            <span class="opacity-60 text-xs font-normal">({{ $role->permissions->count() }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <p class="mt-3 text-xs text-blue-600 dark:text-blue-400">
                                <svg class="inline h-3.5 w-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                Users can have multiple roles. Permissions are cumulative.
                            </p>
                        </div>
                    </div>

                    <!-- ── Section 2: Effective Permissions ──────────────────────────── -->
                    <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 bg-white dark:bg-gray-800">
                        <button type="button" onclick="toggleMainBox('box-direct')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors text-left focus:outline-none">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40">
                                    <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Effective Permissions</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Choose the final access this user should have after roles and overrides.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="permission-counter-badge" class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/40 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:text-green-400">0 selected</span>
                                <svg id="box-direct-icon" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </button>

                        <div id="box-direct" class="hidden px-6 pb-6 pt-2 space-y-1.5">
                            @foreach($permissionCategories as $category => $slugs)
                                @php
                                    $categoryPermissions = $permissions->whereIn('slug', $slugs);
                                    $catSlug = Str::slug($category);
                                    $checkedCount = $categoryPermissions->filter(fn($p) => in_array($p->id, $userPermissions))->count();
                                @endphp

                                @if($categoryPermissions->count() > 0)
                                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50/30 dark:bg-gray-800" data-category-permissions="{{ $catSlug }}">
                                        <!-- Collapsible Header -->
                                        <button type="button"
                                            onclick="toggleAccordion('perm-{{ $catSlug }}')"
                                            class="w-full flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 px-4 py-2.5 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <div class="flex items-center gap-2">
                                                <svg id="perm-{{ $catSlug }}-icon" class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">{{ $category }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <span class="perm-cat-badge-{{ $catSlug }} hidden inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/40 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-400">0 on</span>
                                                <span class="text-xs text-gray-400">{{ $categoryPermissions->count() }}</span>
                                            </div>
                                        </button>
                                        <!-- Collapsible Body -->
                                        <div id="perm-{{ $catSlug }}" class="hidden border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                                            <div class="px-4 pt-2 pb-1 flex gap-3 text-xs border-b border-gray-50 dark:border-gray-700/50">
                                                <button type="button" onclick="selectAllInCategory('{{ $catSlug }}')" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium py-1">Select All</button>
                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                <button type="button" onclick="selectNoneInCategory('{{ $catSlug }}')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 font-medium py-1">None</button>
                                            </div>
                                            <div class="p-3 flex flex-wrap gap-2">
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
                                                            data-category="{{ $catSlug }}"
                                                        >
                                                        <label for="permission_{{ $permission->id }}"
                                                            class="flex cursor-pointer items-center gap-1.5 rounded-full border border-gray-200 dark:border-gray-600 px-3 py-1 text-xs font-medium text-gray-700 dark:text-gray-300
                                                                   hover:border-green-400 dark:hover:border-green-500
                                                                   peer-checked:border-green-500 peer-checked:bg-green-500 peer-checked:text-white
                                                                   dark:peer-checked:bg-green-600 dark:peer-checked:border-green-600
                                                                   transition-all select-none whitespace-nowrap">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-start gap-2 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 px-4 py-3 text-sm text-yellow-700 dark:text-yellow-400">
                            <svg class="h-4 w-4 mt-0.5 flex-shrink-0 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Unchecked role permissions are saved as explicit revokes, so they stay disabled while the role remains assigned.
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
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });

    document.getElementById(`content-${tabName}`).classList.remove('hidden');

    const activeTab = document.getElementById(`tab-${tabName}`);
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
}

// Collapsible Box & Accordion Management
function toggleMainBox(boxId) {
    const box = document.getElementById(boxId);
    const icon = document.getElementById(`${boxId}-icon`);
    if (box) {
        box.classList.toggle('hidden');
    }
    if (icon) {
        icon.classList.toggle('rotate-90');
    }
}

function toggleAccordion(id) {
    const content = document.getElementById(id);
    const icon = document.getElementById(`${id}-icon`);
    if (content) {
        content.classList.toggle('hidden');
    }
    if (icon) {
        icon.classList.toggle('rotate-90');
    }
}

// Permission Management
function selectAllInCategory(categorySlug) {
    const container = document.querySelector(`[data-category-permissions="${categorySlug}"]`);
    if (container) {
        container.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        updatePermissionCounter();
    }
}

function selectNoneInCategory(categorySlug) {
    const container = document.querySelector(`[data-category-permissions="${categorySlug}"]`);
    if (container) {
        container.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        updatePermissionCounter();
    }
}

function selectAllRevoked(categorySlug) {
    const container = document.querySelector(`[data-category-revoked="${categorySlug}"]`);
    if (container) {
        container.querySelectorAll('.revoked-checkbox').forEach(cb => cb.checked = true);
        updateRevokedCounter();
    }
}

function selectNoneRevoked(categorySlug) {
    const container = document.querySelector(`[data-category-revoked="${categorySlug}"]`);
    if (container) {
        container.querySelectorAll('.revoked-checkbox').forEach(cb => cb.checked = false);
        updateRevokedCounter();
    }
}

function updateRolesCounter() {
    const count = document.querySelectorAll('.role-checkbox:checked').length;
    const summary = document.getElementById('roles-selected-summary');
    if (summary) {
        summary.textContent = `${count} assigned`;
    }
}

function updatePermissionCounter() {
    const count = document.querySelectorAll('.permission-checkbox:checked').length;
    const badge = document.getElementById('permission-counter-badge');
    if (badge) badge.textContent = `${count} selected`;

    // Update category-specific badges
    document.querySelectorAll('[data-category-permissions]').forEach(container => {
        const catSlug = container.getAttribute('data-category-permissions');
        const catCheckedCount = container.querySelectorAll('.permission-checkbox:checked').length;
        const catBadge = container.querySelector(`.perm-cat-badge-${catSlug}`);
        if (catBadge) {
            if (catCheckedCount > 0) {
                catBadge.textContent = `${catCheckedCount} on`;
                catBadge.classList.remove('hidden');
                catBadge.classList.add('inline-flex');
            } else {
                catBadge.classList.add('hidden');
                catBadge.classList.remove('inline-flex');
            }
        }
    });
}

function updateRevokedCounter() {
    const count = document.querySelectorAll('.revoked-checkbox:checked').length;
    const badge = document.getElementById('revoked-counter-badge');
    if (badge) badge.textContent = `${count} revoked`;

    // Update category-specific badges
    document.querySelectorAll('[data-category-revoked]').forEach(container => {
        const catSlug = container.getAttribute('data-category-revoked');
        const catCheckedCount = container.querySelectorAll('.revoked-checkbox:checked').length;
        const catBadge = container.querySelector(`.revoked-cat-badge-${catSlug}`);
        if (catBadge) {
            if (catCheckedCount > 0) {
                catBadge.textContent = `${catCheckedCount} off`;
                catBadge.classList.remove('hidden');
                catBadge.classList.add('inline-flex');
            } else {
                catBadge.classList.add('hidden');
                catBadge.classList.remove('inline-flex');
            }
        }
    });
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.getElementById('user-form').reset();
        updateRolesCounter();
        updatePermissionCounter();
        updateRevokedCounter();
    }
}

// Sync role-implied permissions to direct permissions checkboxes
function syncRolePermissionsToDirect(roleInput) {
    if (!roleInput) return;
    
    const rolePerms = JSON.parse(roleInput.getAttribute('data-permissions') || '[]');
    
    if (roleInput.checked) {
        rolePerms.forEach(permId => {
            const directCheckbox = document.querySelector(`input[name="permissions[]"][value="${permId}"]`);
            if (directCheckbox && !directCheckbox.checked) {
                directCheckbox.checked = true;
                directCheckbox.dispatchEvent(new Event('change'));
            }
        });
    } else {
        const remainingCheckedRoles = Array.from(document.querySelectorAll('.role-checkbox:checked'));
        const activeRolePerms = new Set();
        remainingCheckedRoles.forEach(rInput => {
            const perms = JSON.parse(rInput.getAttribute('data-permissions') || '[]');
            perms.forEach(id => activeRolePerms.add(Number(id)));
        });
        
        rolePerms.forEach(permId => {
            if (!activeRolePerms.has(Number(permId))) {
                const directCheckbox = document.querySelector(`input[name="permissions[]"][value="${permId}"]`);
                if (directCheckbox && directCheckbox.checked) {
                    directCheckbox.checked = false;
                    directCheckbox.dispatchEvent(new Event('change'));
                }
            }
        });
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateRolesCounter();
            syncRolePermissionsToDirect(this);
        });
    });

    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updatePermissionCounter();
            const slug = this.getAttribute('data-slug');
            const revokedCheckbox = document.querySelector(`input[name="revoked_permissions[]"][data-slug="${slug}"]`);
            if (this.checked && revokedCheckbox && revokedCheckbox.checked) {
                revokedCheckbox.checked = false;
                updateRevokedCounter();
            }
        });
    });

    document.querySelectorAll('.revoked-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateRevokedCounter();
            const slug = this.getAttribute('data-slug');
            const directCheckbox = document.querySelector(`input[name="permissions[]"][data-slug="${slug}"]`);
            if (this.checked && directCheckbox && directCheckbox.checked) {
                directCheckbox.checked = false;
                updatePermissionCounter();
            }
        });
    });

    // Initialize counters
    updateRolesCounter();
    updatePermissionCounter();
    updateRevokedCounter();
});
</script>
@endpush

@endsection
