@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Super Admin Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">Complete system control and management</p>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_users'] }}</h4>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0ZM11 5.5C12.5188 5.5 13.75 6.73122 13.75 8.25C13.75 9.76878 12.5188 11 11 11C9.48122 11 8.25 9.76878 8.25 8.25C8.25 6.73122 9.48122 5.5 11 5.5ZM11 19.25C8.73984 19.25 6.70703 18.1844 5.5 16.5C5.53125 14.75 9.25 13.8125 11 13.8125C12.75 13.8125 16.4688 14.75 16.5 16.5C15.293 18.1844 13.2602 19.25 11 19.25Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_roles'] }}</h4>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Roles</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-3 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.5 10.9219C21.5 11.2969 21.1875 11.6094 20.8125 11.6094H11.6094V20.8125C11.6094 21.1875 11.2969 21.5 10.9219 21.5C10.5469 21.5 10.2344 21.1875 10.2344 20.8125V11.6094H1.03125C0.65625 11.6094 0.34375 11.2969 0.34375 10.9219C0.34375 10.5469 0.65625 10.2344 1.03125 10.2344H10.2344V1.03125C10.2344 0.65625 10.5469 0.34375 10.9219 0.34375C11.2969 0.34375 11.6094 0.65625 11.6094 1.03125V10.2344H20.8125C21.1875 10.2344 21.5 10.5469 21.5 10.9219Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_permissions'] }}</h4>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Permissions</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-5 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 0.6875C5.25781 0.6875 0.6875 5.25781 0.6875 11C0.6875 16.7422 5.25781 21.3125 11 21.3125C16.7422 21.3125 21.3125 16.7422 21.3125 11C21.3125 5.25781 16.7422 0.6875 11 0.6875ZM15.125 9.625L10.3125 14.4375C10.1094 14.6406 9.84375 14.75 9.5625 14.75C9.28125 14.75 9.01562 14.6406 8.8125 14.4375L6.875 12.5C6.45312 12.0781 6.45312 11.4219 6.875 11C7.29688 10.5781 7.95312 10.5781 8.375 11L9.5625 12.1875L13.625 8.125C14.0469 7.70312 14.7031 7.70312 15.125 8.125C15.5469 8.54688 15.5469 9.20312 15.125 9.625Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">100%</h4>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">System Access</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-9 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0ZM16.5 9.625L9.625 16.5C9.35714 16.7679 8.92857 16.7679 8.66071 16.5L5.5 13.3393C5.23214 13.0714 5.23214 12.6429 5.5 12.375C5.76786 12.1071 6.19643 12.1071 6.46429 12.375L9.14286 15.0536L15.5357 8.66071C15.8036 8.39286 16.2321 8.39286 16.5 8.66071C16.7679 8.92857 16.7679 9.35714 16.5 9.625Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Manage Users</h4>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Add, edit, or remove users</span>
                </div>
            </a>


        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Recent Users</h3>
        <div class="space-y-3">
            @forelse($stats['recent_users'] as $user)
            <div class="flex items-center justify-between border-b border-stroke pb-3 last:border-0 dark:border-strokedark">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-2 dark:bg-meta-4">
                        <span class="font-medium text-black dark:text-white">{{ $user->initials() }}</span>
                    </div>
                    <div>
                        <h5 class="font-medium text-black dark:text-white">{{ $user->name }}</h5>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium {{ $user->roles->first() ? 'bg-success text-success' : 'bg-warning text-warning' }}">
                        {{ $user->roles->first()?->name ?? 'No Role' }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-600 dark:text-gray-400">No users found</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

