<!-- Personal Information Card Component -->
<div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Informasi Personal
        </h3>
        <button type="button" class="inline-flex items-center rounded-lg bg-brand-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Full Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Nama Lengkap
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                {{ auth()->user()->name ?? '-' }}
            </div>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                {{ auth()->user()->email ?? '-' }}
            </div>
        </div>

        <!-- Phone -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Nomor Telepon
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                {{ auth()->user()->phone ?? '-' }}
            </div>
        </div>

        <!-- Birth Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Tanggal Lahir
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                @if(auth()->user()->birth_date)
                    {{ \Carbon\Carbon::parse(auth()->user()->birth_date)->format('d F Y') }}
                @else
                    -
                @endif
            </div>
        </div>

        <!-- Gender -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Jenis Kelamin
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                @if(auth()->user()->gender)
                    {{ auth()->user()->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                @else
                    -
                @endif
            </div>
        </div>

        <!-- NISN (for students) -->
        @if(auth()->user()->hasRole('siswa') && auth()->user()->nisn)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                NISN
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                {{ auth()->user()->nisn }}
            </div>
        </div>
        @endif

        <!-- Academic Information -->
        @if(auth()->user()->hasRole('siswa'))
            <!-- Kelas -->
            @if(auth()->user()->kelas)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kelas
                </label>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                    {{ auth()->user()->kelas->nama }}
                    @if(auth()->user()->kelas->jurusan)
                        - {{ auth()->user()->kelas->jurusan->nama }}
                    @endif
                </div>
            </div>
            @endif

            <!-- Jurusan -->
            @if(auth()->user()->jurusan)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jurusan
                </label>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                    {{ auth()->user()->jurusan->nama }}
                </div>
            </div>
            @endif
        @endif

        @if(auth()->user()->hasRole('guru'))
            <!-- Mata Pelajaran -->
            @if(auth()->user()->mataPelajaran)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mata Pelajaran
                </label>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                    {{ auth()->user()->mataPelajaran->nama }}
                </div>
            </div>
            @endif
        @endif

        <!-- Tahun Ajaran -->
        @if(auth()->user()->tahunAjaran)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Tahun Ajaran
            </label>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                {{ auth()->user()->tahunAjaran->tahun }}
            </div>
        </div>
        @endif
    </div>

    <!-- Account Status -->
    <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-600">
        <h4 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">
            Status Akun
        </h4>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <!-- Email Verification -->
            <div class="flex items-center">
                @if(auth()->user()->email_verified_at)
                    <svg class="mr-2 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-green-600 dark:text-green-400">Email Terverifikasi</span>
                @else
                    <svg class="mr-2 h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-yellow-600 dark:text-yellow-400">Email Belum Terverifikasi</span>
                @endif
            </div>

            <!-- Account Created -->
            <div class="flex items-center">
                <svg class="mr-2 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Bergabung {{ auth()->user()->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Last Login (if available) -->
            <div class="flex items-center">
                <svg class="mr-2 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Online sekarang
                </span>
            </div>
        </div>
    </div>
</div>
