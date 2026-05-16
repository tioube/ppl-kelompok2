@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white dark:bg-gray-900 min-h-screen">
        <div class="relative flex h-screen w-full flex-col justify-center lg:flex-row dark:bg-gray-900">
            <!-- Left Side - Login Form -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2 bg-white dark:bg-gray-900">
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-6 lg:px-8">
                    <!-- Logo & Header -->
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center space-x-3 mb-6">
                            <img src="/images/logo/al-azhar.svg" alt="StudentDesk Logo" class="h-12 w-12">
                            <div class="text-left">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">StudentDesk</h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Sistem Akademik</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                Selamat Datang Kembali
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400">
                                Masuk ke akun StudentDesk Anda untuk melanjutkan
                            </p>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <div class="space-y-6">
                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email Address
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="nama@sekolah.com"
                                        autofocus
                                        required
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-brand-400 transition-all duration-200 @error('email') border-red-500 focus:ring-red-500 @enderror"
                                    />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Password
                                    <span class="text-red-500">*</span>
                                </label>
                                <div x-data="{ showPassword: false }" class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        placeholder="Masukkan password Anda"
                                        required
                                        class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-brand-400 transition-all duration-200 @error('password') border-red-500 focus:ring-red-500 @enderror"
                                    />
                                    <button
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    >
                                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded dark:border-gray-600 dark:bg-gray-800"
                                    />
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                                </label>

                                <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300 font-medium">
                                    Lupa password?
                                </a>
                            </div>

                            <!-- Login Button -->
                            <button
                                type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 dark:focus:ring-offset-gray-900 transition-all duration-200 transform hover:scale-[1.02]"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk ke StudentDesk
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">Belum punya akun?</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-brand-600 text-sm font-medium rounded-xl text-brand-600 bg-transparent hover:bg-brand-50 dark:hover:bg-brand-900/20 dark:text-brand-400 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Daftar Akun Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-brand-600 to-blue-light-600 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,rgba(255,255,255,0.6))]"></div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center text-white p-12 text-center">
                    <!-- Floating Elements -->
                    <div class="absolute top-20 left-20 w-16 h-16 bg-white/10 rounded-full animate-pulse"></div>
                    <div class="absolute top-40 right-16 w-12 h-12 bg-white/20 rounded-full animate-pulse delay-1000"></div>
                    <div class="absolute bottom-32 left-16 w-20 h-20 bg-white/10 rounded-full animate-pulse delay-2000"></div>

                    <div class="max-w-md">
                        <!-- Main Logo/Illustration -->
                        <div class="mb-8">
                            <div class="relative">
                                <div class="bg-white/20 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                                    <div class="space-y-4">
                                        <!-- Mock Dashboard -->
                                        <div class="bg-white/90 text-brand-600 p-4 rounded-lg">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="font-semibold">StudentDesk Dashboard</span>
                                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 text-xs">
                                                <div class="bg-brand-50 p-2 rounded">
                                                    <div class="font-bold">250</div>
                                                    <div>Siswa</div>
                                                </div>
                                                <div class="bg-blue-light-50 p-2 rounded">
                                                    <div class="font-bold">25</div>
                                                    <div>Guru</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Activity Indicators -->
                                        <div class="flex justify-between">
                                            <div class="w-2 h-2 bg-green-400 rounded-full animate-ping"></div>
                                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-ping delay-300"></div>
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-ping delay-700"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Welcome Text -->
                        <h2 class="text-3xl font-bold mb-4">
                            Selamat Datang di StudentDesk
                        </h2>
                        <p class="text-lg text-white/90 mb-6">
                            Platform manajemen akademik modern untuk sekolah digital. Kelola siswa, guru, jadwal, dan data akademik dengan mudah.
                        </p>

                        <!-- Features List -->
                        <div class="space-y-3 text-left">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Manajemen pengguna dengan 5 role berbeda</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Generator jadwal pelajaran otomatis</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Dashboard analytics real-time</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Keamanan data berlapis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for grid pattern -->
    <style>
        .bg-grid-white\/10 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='m0 .5h32m-32 32v-32'/%3e%3c/svg%3e");
        }
    </style>
@endsection
