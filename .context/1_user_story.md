 # User Stories

 ## Rank 1

 ### Req 001 - Semua Role
 - Requirement: Sistem harus menyediakan fitur login menggunakan kredensial yang valid (email/username dan password).
 - User story: Sebagai pengguna, saya ingin login dengan kredensial valid, sehingga saya bisa masuk ke sistem.
 - Acceptance criteria:
	 - S1: Given di hal. login, When input email & pass benar, Then masuk dashboard.
	 - S2: Given di hal. login, When input pass salah, Then muncul pesan error.

 ### Req 002 - Semua Role
 - Requirement: Sistem harus menyediakan fitur logout untuk mengakhiri sesi pengguna.
 - User story: Sebagai pengguna, saya ingin logout dari sistem, sehingga sesi saya berakhir dengan aman.
 - Acceptance criteria:
	 - S1: Given sudah login, When klik logout, Then sesi berakhir & ke hal. login.
	 - S2: Given sesi berakhir, When akses hal. internal via URL, Then diredireksi ke login.

 ### Req 005 - Super Administrator
 - Requirement: Sistem harus memungkinkan melihat daftar seluruh pengguna.
 - User story: Sebagai Super Admin, saya ingin melihat daftar seluruh pengguna, sehingga saya bisa memantau user yang ada.
 - Acceptance criteria:
	 - S1: Given di menu User, When buka halaman daftar, Then muncul list semua user.
	 - S2: Given daftar user, When cari nama tertentu, Then muncul hasil yang relevan.

 ### Req 008 - Super Administrator
 - Requirement: Sistem harus memungkinkan reset password pengguna.
 - User story: Sebagai Super Admin, saya ingin reset password pengguna, untuk membantu user yang lupa akses.
 - Acceptance criteria:
	 - S1: Given pilih user, When klik reset password, Then password kembali ke default.
	 - S2: Given reset sukses, When user login dengan pass lama, Then login ditolak.

 ### Req 014 - Akademik
 - Requirement: Sistem harus memungkinkan pengelolaan data guru aktif.
 - User story: Sebagai Akademik, saya ingin mengelola data guru aktif, untuk memastikan data staf pengajar lengkap.
 - Acceptance criteria:
	 - S1: Given menu Guru, When tambah data NIP & Nama, Then guru masuk daftar aktif.
	 - S2: Given data guru, When ubah status jadi non-aktif, Then guru tidak muncul di jadwal.

 ### Req 015 - Akademik
 - Requirement: Sistem harus memungkinkan pengelolaan data siswa.
 - User story: Sebagai Akademik, saya ingin mengelola data siswa, untuk memelihara database peserta didik.
 - Acceptance criteria:
	 - S1: Given menu Siswa, When input NISN & biodata, Then siswa tersimpan.
	 - S2: Given list siswa, When filter per tahun angkatan, Then muncul siswa angkatan tsb.

 ### Req 018 - Guru
 - Requirement: Sistem harus memungkinkan pencatatan absensi siswa per jadwal pelajaran.
 - User story: Sebagai Guru, saya ingin mencatat absensi siswa per jadwal, untuk mendata kehadiran di kelas.
 - Acceptance criteria:
	 - S1: Given buka sesi absen, When tandai siswa "Hadir", Then catatan kehadiran tersimpan.
	 - S2: Given sudah absen, When simpan data tanpa pilih status, Then muncul validasi.

 ### Req 020 - Guru
 - Requirement: Sistem harus memungkinkan pembuatan tugas beserta instruksi dan lampiran.
 - User story: Sebagai Guru, saya ingin membuat tugas dengan instruksi, agar siswa paham cara pengerjaan tugas.
 - Acceptance criteria:
	 - S1: Given buat tugas, When tulis instruksi & simpan, Then instruksi terbaca oleh siswa.
	 - S2: Given edit tugas, When hapus instruksi lama, Then instruksi terupdate jadi kosong.

 ### Req 021 - Guru
 - Requirement: Sistem harus memungkinkan penentuan batas waktu pengumpulan tugas.
 - User story: Sebagai Guru, saya ingin menentukan deadline tugas, agar siswa disiplin mengumpulkan.
 - Acceptance criteria:
	 - S1: Given buat tugas, When set tanggal/jam deadline, Then sistem kunci upload setelah waktu tsb.
	 - S2: Given deadline lewat, When siswa coba upload, Then tombol submit non-aktif.

 ### Req 023 - Guru
 - Requirement: Sistem harus memungkinkan pemberian nilai terhadap tugas siswa.
 - User story: Sebagai Guru, saya ingin memberikan nilai terhadap tugas, untuk memberikan apresiasi hasil kerja.
 - Acceptance criteria:
	 - S1: Given submission siswa, When input skor 85 & simpan, Then nilai muncul di siswa.
	 - S2: Given input skor > 100, When simpan, Then sistem menolak input.

 ### Req 025 - Siswa
 - Requirement: Sistem harus memungkinkan siswa melihat jadwal pembelajaran harian.
 - User story: Sebagai Siswa, saya ingin melihat jadwal harian, agar saya tahu pelajaran apa yang diikuti.
 - Acceptance criteria:
	 - S1: Given di dashboard siswa, When buka menu Jadwal, Then muncul jadwal hari ini.
	 - S2: Given hari libur, When cek jadwal, Then muncul keterangan "Tidak ada jadwal".

 ### Req 026 - Siswa
 - Requirement: Sistem harus memungkinkan siswa mengakses dan mengunduh materi pembelajaran.
 - User story: Sebagai Siswa, saya ingin akses & unduh materi, untuk mendukung proses belajar.
 - Acceptance criteria:
	 - S1: Given list materi, When klik tombol unduh, Then file terdownload ke perangkat.
	 - S2: Given materi video, When klik play, Then video terputar di browser.

 ### Req 027 - Siswa
 - Requirement: Sistem harus memungkinkan siswa melihat detail tugas dan deadline.
 - User story: Sebagai Siswa, saya ingin melihat detail tugas & deadline, agar saya tidak terlambat mengumpulkan.
 - Acceptance criteria:
	 - S1: Given list tugas, When klik satu tugas, Then muncul sisa waktu pengerjaan.
	 - S2: Given tugas selesai, When cek detail, Then status tertulis "Sudah Dikerjakan".

 ### Req 030 - Siswa
 - Requirement: Sistem harus memungkinkan siswa melihat nilai tugas dan ujian.
 - User story: Sebagai Siswa, saya ingin melihat nilai tugas & ujian, agar saya tahu pencapaian saya.
 - Acceptance criteria:
	 - S1: Given tugas dinilai, When buka menu Nilai, Then muncul angka nilai tugas tsb.
	 - S2: Given belum dinilai, When cek nilai, Then status muncul "Menunggu Penilaian".

 ## Rank 2

 ### Req 004 - Super Administrator
 - Requirement: Sistem harus memungkinkan pembuatan akun untuk Pimpinan, Akademik, Guru, dan Siswa.
 - User story: Sebagai Super Admin, saya ingin membuat akun untuk Pimpinan/Guru/Siswa, agar mereka bisa mengakses sistem.
 - Acceptance criteria:
	 - S1: Given di menu User, When simpan data user baru, Then akun aktif.
	 - S2: Given form user, When email sudah terdaftar, Then sistem menolak pendaftaran.

 ### Req 006 - Super Administrator
 - Requirement: Sistem harus memungkinkan memperbarui data pengguna.
 - User story: Sebagai Super Admin, saya ingin memperbarui data pengguna, agar informasi user tetap valid.
 - Acceptance criteria:
	 - S1: Given pilih satu user, When ubah nama/role & simpan, Then data terupdate.
	 - S2: Given edit user, When klik batal, Then data tidak berubah.

 ### Req 007 - Super Administrator
 - Requirement: Sistem harus memungkinkan menghapus akun pengguna.
 - User story: Sebagai Super Admin, saya ingin menghapus akun pengguna, untuk membersihkan user yang tidak aktif.
 - Acceptance criteria:
	 - S1: Given pilih satu user, When klik hapus & konfirmasi, Then user terhapus.
	 - S2: Given konfirmasi hapus, When klik batal, Then user tetap ada.

 ### Req 009 - Super Administrator
 - Requirement: Sistem harus memungkinkan pengelolaan role dan permissions pengguna.
 - User story: Sebagai Super Admin, saya ingin mengelola role dan permissions, untuk mengatur batasan akses fitur.
 - Acceptance criteria:
	 - S1: Given menu Role, When tambah akses fitur ke role Guru, Then Guru bisa akses fitur itu.
	 - S2: Given edit role, When hapus akses, Then role tersebut kehilangan akses fitur.

 ### Req 011 - Akademik
 - Requirement: Sistem harus memungkinkan pembuatan data kurikulum baru.
 - User story: Sebagai Akademik, saya ingin membuat data kurikulum baru, agar standar pembelajaran tersedia.
 - Acceptance criteria:
	 - S1: Given menu Kurikulum, When input nama kurikulum baru, Then data tersimpan.
	 - S2: Given form kurikulum, When data kosong disimpan, Then muncul validasi wajib isi.

 ### Req 012 - Akademik
 - Requirement: Sistem harus memungkinkan pembaruan data kurikulum.
 - User story: Sebagai Akademik, saya ingin memperbarui data kurikulum, agar kurikulum tetap relevan.
 - Acceptance criteria:
	 - S1: Given list kurikulum, When edit tahun/isi kurikulum, Then data berubah.
	 - S2: Given edit kurikulum, When klik "Back", Then sistem tidak menyimpan perubahan.

 ### Req 013 - Akademik
 - Requirement: Sistem harus memungkinkan pengaturan jadwal pelajaran per kelas.
 - User story: Sebagai Akademik, saya ingin mengatur jadwal pelajaran per kelas, agar KBM terorganisir.
 - Acceptance criteria:
	 - S1: Given menu Jadwal, When plot Mapel ke hari/jam, Then jadwal tampil di kelas.
	 - S2: Given input jadwal bentrok, When disimpan, Then sistem beri peringatan konflik.

 ### Req 016 - Akademik
 - Requirement: Sistem harus memungkinkan penugasan guru ke mata pelajaran dan kelas.
 - User story: Sebagai Akademik, saya ingin penugasan guru ke mapel & kelas, agar tanggung jawab mengajar jelas.
 - Acceptance criteria:
	 - S1: Given menu Penugasan, When pilih Guru ke Kelas X-A, Then Guru tsb punya akses kelas X-A.
	 - S2: Given Guru sudah ditugaskan, When hapus penugasan, Then hak akses guru di kelas tsb hilang.

 ### Req 017 - Akademik
 - Requirement: Sistem harus memungkinkan penempatan siswa ke kelas berdasarkan tahun ajaran.
 - User story: Sebagai Akademik, saya ingin penempatan siswa ke kelas per tahun ajaran, agar pembagian rombel rapi.
 - Acceptance criteria:
	 - S1: Given daftar siswa, When masukkan ke Kelas XI-B, Then siswa tsb muncul di absen XI-B.
	 - S2: Given siswa sudah di kelas A, When pindah ke kelas B, Then data kelas siswa terupdate.

 ### Req 019 - Guru
 - Requirement: Sistem harus memungkinkan unggah materi pembelajaran (dokumen/video).
 - User story: Sebagai Guru, saya ingin unggah materi belajar (dok/video), agar siswa bisa belajar mandiri.
 - Acceptance criteria:
	 - S1: Given menu Materi, When upload PDF & simpan, Then materi tampil di sisi siswa.
	 - S2: Given upload file > 20MB, When simpan, Then muncul error "File terlalu besar".

 ### Req 022 - Guru
 - Requirement: Sistem harus memungkinkan pembuatan dan penjadwalan ujian/tes.
 - User story: Sebagai Guru, saya ingin membuat & menjadwalkan ujian, untuk mengevaluasi hasil belajar.
 - Acceptance criteria:
	 - S1: Given menu Ujian, When set waktu mulai & durasi, Then ujian hanya aktif di jam tsb.
	 - S2: Given ujian terjadwal, When hapus jadwal, Then ujian tidak akan muncul di siswa.

 ### Req 028 - Siswa
 - Requirement: Sistem harus memungkinkan siswa mengunggah hasil tugas.
 - User story: Sebagai Siswa, saya ingin mengunggah hasil tugas, untuk memenuhi kewajiban belajar.
 - Acceptance criteria:
	 - S1: Given hal. tugas, When upload file & submit, Then status tugas jadi "Terkirim".
	 - S2: Given submit gagal (koneksi), When klik retry, Then file mencoba terunggah kembali.

 ### Req 029 - Siswa
 - Requirement: Sistem harus memungkinkan siswa mengikuti ujian daring.
 - User story: Sebagai Siswa, saya ingin mengikuti ujian daring, untuk mengerjakan tes secara fleksibel.
 - Acceptance criteria:
	 - S1: Given jam ujian tiba, When klik "Mulai", Then soal muncul & timer berjalan.
	 - S2: Given waktu habis, When sedang mengerjakan, Then jawaban otomatis tersimpan.

 ### Req 031 - Siswa
 - Requirement: Sistem harus memungkinkan siswa melihat laporan hasil belajar (raport).
 - User story: Sebagai Siswa, saya ingin melihat laporan raport, untuk melihat rangkuman hasil belajar.
 - Acceptance criteria:
	 - S1: Given akhir semester, When buka menu Raport, Then muncul nilai semua mapel.
	 - S2: Given raport tersedia, When klik cetak PDF, Then file raport terunduh.

 ## Rank 3

 ### Req 003 - Semua Role
 - Requirement: Sistem harus memungkinkan pengguna memperbarui profil pribadi (nomor telepon, email, foto profil).
 - User story: Sebagai pengguna, saya ingin memperbarui profil pribadi, sehingga data kontak saya tetap akurat.
 - Acceptance criteria:
	 - S1: Given di hal. profil, When ubah foto & simpan, Then foto terupdate.
	 - S2: Given di hal. profil, When input format email salah, Then muncul peringatan.

 ### Req 010 - Super Administrator
 - Requirement: Sistem harus menyediakan akses ke seluruh dashboard pelaporan sistem dan akademik.
 - User story: Sebagai Super Admin, saya ingin akses ke seluruh dashboard pelaporan, agar bisa memantau aktivitas sistem & akademik.
 - Acceptance criteria:
	 - S1: Given login sebagai Admin, When buka dashboard, Then muncul ringkasan data.
	 - S2: Given dashboard, When klik detail laporan, Then muncul data mendalam.

 ### Req 024 - Guru
 - Requirement: Sistem harus memungkinkan pemberian feedback/catatan pada hasil siswa.
 - User story: Sebagai Guru, saya ingin memberikan feedback pada hasil siswa, agar siswa tahu bagian mana yang harus diperbaiki.
 - Acceptance criteria:
	 - S1: Given hal. nilai, When tulis komentar evaluasi, Then siswa bisa lihat feedback tsb.
	 - S2: Given feedback lama, When edit komentar, Then feedback terbaru tersimpan.

 ### Req 032 - Pimpinan
 - Requirement: Sistem harus menyediakan laporan agregat kehadiran siswa.
 - User story: Sebagai Pimpinan, saya ingin laporan agregat kehadiran siswa, untuk memantau kedisiplinan sekolah.
 - Acceptance criteria:
	 - S1: Given menu Laporan, When pilih filter per kelas, Then muncul % kehadiran kelas tsb.
	 - S2: Given data absen kosong, When buka laporan, Then grafik menampilkan angka nol.

 ### Req 033 - Pimpinan
 - Requirement: Sistem harus menyediakan laporan nilai siswa per kelas atau mata pelajaran.
 - User story: Sebagai Pimpinan, saya ingin laporan nilai per kelas/mapel, untuk evaluasi mutu akademik.
 - Acceptance criteria:
	 - S1: Given menu Laporan Nilai, When pilih Mapel Matematika, Then muncul rata-rata nilai.
	 - S2: Given filter kelas, When klik export excel, Then file laporan terunduh.

 ### Req 034 - Pimpinan
 - Requirement: Sistem harus memungkinkan filter laporan berdasarkan rentang tanggal.
 - User story: Sebagai Pimpinan, saya ingin filter laporan berdasar rentang tanggal, untuk laporan periodik.
 - Acceptance criteria:
	 - S1: Given filter tanggal, When set Jan - Juni, Then data yang muncul hanya periode tsb.
	 - S2: Given rentang tanggal salah, When klik filter, Then muncul pesan "Tanggal tidak valid".

 ### Req 035 - Pimpinan
 - Requirement: Sistem harus menyediakan dashboard monitoring kinerja sekolah.
 - User story: Sebagai Pimpinan, saya ingin dashboard monitoring kinerja sekolah, untuk melihat performa umum.
 - Acceptance criteria:
	 - S1: Given login pimpinan, When buka dashboard, Then muncul widget statistik utama.
	 - S2: Given data dashboard, When klik refresh, Then data terbaru ditarik dari server.

 ### Req 036 - Pimpinan
 - Requirement: Sistem harus menyediakan statistik nilai rata-rata siswa per kelas.
 - User story: Sebagai Pimpinan, saya ingin statistik nilai rata-rata per kelas, untuk membandingkan antar kelas.
 - Acceptance criteria:
	 - S1: Given menu Statistik, When bandingkan Kelas A & B, Then muncul grafik komparasi.
	 - S2: Given data nilai minim, When cek rata-rata, Then sistem tetap menghitung yang ada.

 ### Req 037 - Pimpinan
 - Requirement: Sistem harus menyediakan ranking nilai siswa.
 - User story: Sebagai Pimpinan, saya ingin melihat ranking nilai siswa, untuk mengetahui siswa berprestasi.
 - Acceptance criteria:
	 - S1: Given menu Ranking, When pilih angkatan, Then muncul list siswa dari nilai tertinggi.
	 - S2: Given nilai sama, When diurutkan, Then sistem mengurutkan berdasarkan nama (alfabet).
