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
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($roles as $role)
                            <div class="flex items-center rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    id="role_{{ $role->id }}"
                                    {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-700"
                                >
                                <label for="role_{{ $role->id }}" class="ml-3 flex-1">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $role->description }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Direct Permissions (Override)</label>
                        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($permissions as $permission)
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="permission_{{ $permission->id }}"
                                    {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-700"
                                >
                                <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Direct permissions override role permissions</p>
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

