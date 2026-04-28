<!-- Profile Card Component -->
<div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
    <div class="flex flex-col items-center space-y-4 text-center sm:flex-row sm:space-x-6 sm:space-y-0 sm:text-left">
        <!-- Profile Image -->
        <div class="relative">
            @if(auth()->user()->photo_profile)
                <img class="h-24 w-24 rounded-full object-cover ring-4 ring-white dark:ring-gray-700"
                     src="{{ asset('storage/' . auth()->user()->photo_profile) }}"
                     alt="{{ auth()->user()->name }}">
            @else
                <div class="h-24 w-24 rounded-full bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center ring-4 ring-white dark:ring-gray-700">
                    <span class="text-2xl font-bold text-brand-600 dark:text-brand-400">
                        {{ auth()->user()->initials() }}
                    </span>
                </div>
            @endif

            <!-- Online Status Indicator -->
            <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full border-2 border-white bg-green-500 dark:border-gray-700"></div>
        </div>

        <!-- Profile Info -->
        <div class="flex-1">
            <div class="mb-3">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ auth()->user()->name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <!-- Role Badges -->
            <div class="mb-4 flex flex-wrap gap-2 justify-center sm:justify-start">
                @foreach(auth()->user()->roles as $role)
                    <span class="inline-flex items-center rounded-full
                        @switch($role->slug)
                            @case('super-admin')
                                bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400
                                @break
                            @case('admin')
                                bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400
                                @break
                            @case('akademik')
                                bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400
                                @break
                            @case('guru')
                                bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400
                                @break
                            @case('siswa')
                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400
                                @break
                            @default
                                bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-400
                        @endswitch
                        px-3 py-1 text-xs font-medium">

                        <!-- Role Icon -->
                        @switch($role->slug)
                            @case('super-admin')
                                <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                </svg>
                                @break
                            @case('admin')
                                <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                @break
                            @case('akademik')
                                <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @break
                            @case('guru')
                                <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                                @break
                            @case('siswa')
                                <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                @break
                        @endswitch

                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                    </span>
                @endforeach
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                @if(auth()->user()->phone)
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ auth()->user()->phone }}
                    </div>
                @endif

                @if(auth()->user()->birth_date)
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse(auth()->user()->birth_date)->format('d M Y') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col space-y-2">
            <a href="#" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </a>

            <button type="button" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </button>
        </div>
    </div>
</div>
