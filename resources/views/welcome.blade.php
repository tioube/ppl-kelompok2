<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>StudentDesk - Sistem Manajemen Akademik Modern</title>
    <meta name="description" content="StudentDesk adalah platform manajemen akademik modern yang memudahkan sekolah dalam mengelola siswa, guru, jadwal, dan akademik secara digital.">
    <meta name="keywords" content="sistem akademik, manajemen sekolah, jadwal pelajaran, siswa, guru, digital school">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo/al-azhar.svg">
    <link rel="shortcut icon" type="image/png" href="/images/logo/al-azhar.svg">
    <link rel="apple-touch-icon" href="/images/logo/al-azhar.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="/images/logo/al-azhar.svg" alt="StudentDesk Logo" class="h-10 w-10">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">StudentDesk</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Sistem Akademik</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Fitur</a>
                    <a href="#about" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Tentang</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700 transition-colors">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300" x-data @click="$refs.mobileMenu.classList.toggle('hidden')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-ref="mobileMenu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="#features" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Fitur</a>
                    <a href="#about" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Tentang</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700 transition-colors text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700 transition-colors text-center">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-50 to-blue-light-50 dark:from-gray-900 dark:to-gray-800 min-h-[90vh] flex items-center">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        <span class="text-brand-600">StudentDesk</span><br>
                        Sistem Akademik<br>
                        <span class="text-brand-600">Modern</span>
                    </h1>

                    <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-2xl">
                        Platform digital terdepan untuk mengelola seluruh aspek akademik sekolah. Kelola siswa, guru, jadwal pelajaran, dan data akademik dengan mudah dan efisien.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-brand-600 text-white px-8 py-4 rounded-xl hover:bg-brand-700 transition-all transform hover:scale-105 font-semibold text-center">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-brand-600 text-white px-8 py-4 rounded-xl hover:bg-brand-700 transition-all transform hover:scale-105 font-semibold text-center">
                                Mulai Sekarang
                            </a>
                            <a href="#features" class="border-2 border-brand-600 text-brand-600 px-8 py-4 rounded-xl hover:bg-brand-600 hover:text-white transition-all font-semibold text-center">
                                Pelajari Lebih Lanjut
                            </a>
                        @endauth
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-4 text-center lg:text-left">
                        <div>
                            <div class="text-2xl font-bold text-brand-600">5+</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Role Pengguna</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-brand-600">100%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Digital</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-brand-600">24/7</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Akses</div>
                        </div>
                    </div>
                </div>

                <!-- Right Image/Illustration -->
                <div class="relative">
                    <div class="relative bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                        <!-- Mock Dashboard UI -->
                        <div class="space-y-4">
                            <!-- Header -->
                            <div class="flex items-center justify-between bg-brand-600 text-white p-4 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold">Dashboard</span>
                                </div>
                                <div class="text-sm opacity-90">Super Admin</div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                                    <div class="text-2xl font-bold text-green-600">250</div>
                                    <div class="text-xs text-green-700 dark:text-green-400">Total Siswa</div>
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="text-2xl font-bold text-blue-600">25</div>
                                    <div class="text-xs text-blue-700 dark:text-blue-400">Total Guru</div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Aktivitas Terbaru</div>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2 text-xs">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">Jadwal X IPA 1 telah diupdate</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-xs">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">5 siswa baru terdaftar</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-xs">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                        <span class="text-gray-600 dark:text-gray-400">Backup otomatis selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-brand-500 rounded-full opacity-80 animate-pulse"></div>
                        <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-blue-light-400 rounded-full opacity-60 animate-pulse delay-1000"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                    Fitur <span class="text-brand-600">Unggulan</span>
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Solusi lengkap untuk semua kebutuhan manajemen akademik sekolah modern
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Manajemen Pengguna</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kelola data siswa, guru, dan staff dengan sistem role-based yang aman dan terstruktur.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Jadwal Otomatis</h3>
                    <p class="text-gray-600 dark:text-gray-400">Generate jadwal pelajaran secara otomatis dengan algoritma cerdas yang menghindari konflik waktu.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Dashboard Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-400">Pantau performa akademik dengan dashboard interaktif dan laporan real-time yang komprehensif.</p>
                </div>

                <!-- Feature 4 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Keamanan Data</h3>
                    <p class="text-gray-600 dark:text-gray-400">Sistem keamanan berlapis dengan enkripsi data dan kontrol akses berbasis peran yang ketat.</p>
                </div>

                <!-- Feature 5 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Konfigurasi Fleksibel</h3>
                    <p class="text-gray-600 dark:text-gray-400">Sesuaikan sistem dengan kebutuhan sekolah Anda melalui pengaturan yang mudah dan intuitif.</p>
                </div>

                <!-- Feature 6 -->
                <div class="group p-8 bg-gray-50 dark:bg-gray-800 rounded-2xl hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all duration-300 hover:shadow-lg">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-brand-200 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Backup Otomatis</h3>
                    <p class="text-gray-600 dark:text-gray-400">Data selalu aman dengan sistem backup otomatis dan recovery yang cepat untuk kontinuitas operasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Tentang <span class="text-brand-600">StudentDesk</span>
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">
                        StudentDesk adalah solusi manajemen akademik terdepan yang dirancang khusus untuk memenuhi kebutuhan sekolah modern. Dengan teknologi terkini dan antarmuka yang intuitif, kami membantu institusi pendidikan mengelola operasional mereka dengan lebih efisien.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                        Platform kami mendukung berbagai peran pengguna dari Super Admin hingga Siswa, memastikan setiap stakeholder memiliki akses yang tepat ke informasi yang mereka butuhkan.
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-brand-600">99%</div>
                            <div class="text-gray-600 dark:text-gray-400">Uptime</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-brand-600">5</div>
                            <div class="text-gray-600 dark:text-gray-400">Role Pengguna</div>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="bg-gradient-to-br from-brand-500 to-blue-light-600 rounded-3xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-6">Role Pengguna</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 bg-white/10 rounded-lg p-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Super Admin - Kontrol penuh sistem</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/10 rounded-lg p-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Admin - Manajemen pengguna</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/10 rounded-lg p-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span>Akademik - Kelola akademik</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/10 rounded-lg p-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                    </svg>
                                </div>
                                <span>Guru - Akses mengajar</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/10 rounded-lg p-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span>Siswa - Portal pembelajaran</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                Siap untuk Memulai?
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan revolusi digital dalam manajemen akademik. StudentDesk siap membantu sekolah Anda berkembang ke era digital.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-brand-600 text-white px-8 py-4 rounded-xl hover:bg-brand-700 transition-all transform hover:scale-105 font-semibold">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-brand-600 text-white px-8 py-4 rounded-xl hover:bg-brand-700 transition-all transform hover:scale-105 font-semibold">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-brand-600 text-brand-600 px-8 py-4 rounded-xl hover:bg-brand-600 hover:text-white transition-all font-semibold">
                        Masuk ke Akun
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="/images/logo/al-azhar.svg" alt="StudentDesk Logo" class="h-10 w-10">
                        <div>
                            <h3 class="text-xl font-bold">StudentDesk</h3>
                            <p class="text-sm text-gray-400">Sistem Akademik</p>
                        </div>
                    </div>
                    <p class="text-gray-400 max-w-md">
                        Platform manajemen akademik modern yang memudahkan sekolah dalam mengelola seluruh aspek pendidikan secara digital dan efisien.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Tentang</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">Daftar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@studentdesk.id</li>
                        <li>Phone: +62 123 456 789</li>
                        <li>Support 24/7</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} StudentDesk. All rights reserved. Powered by Laravel & TailAdmin.</p>
            </div>
        </div>
    </footer>

    <!-- Grid CSS for background pattern -->
    <style>
        .bg-grid-slate-100 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(148 163 184 / 0.05)'%3e%3cpath d='m0 .5h32m-32 32v-32'/%3e%3c/svg%3e");
        }
        .bg-grid-slate-700\/25 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(51 65 85 / 0.25)'%3e%3cpath d='m0 .5h32m-32 32v-32'/%3e%3c/svg%3e");
        }
    </style>
</body>

</html>
