# User Story 1
Sebagai pengguna, saya ingin login dengan kredensial valid, sehingga saya bisa masuk ke sistem.

## Task
- BE: Implement endpoint POST /auth/login sesuai kontrak (identitas + kata_sandi) dan kembalikan data sesi
- BE: Validasi kredensial terhadap tabel pengguna (email/username, kata_sandi_hash) dan buat sesi di tabel sesi_pengguna
- BE: Set status_aktif dan waktu_masuk, pastikan id_sesi/token_sesi unik
- FE: Buat form login dan kirim request JSON ke /auth/login
- FE: Tampilkan error 401 saat kredensial tidak valid
- QA: Uji login sukses, password salah, dan request tidak lengkap

## Acceptance Criteria
- Given pengguna di halaman login, When input identitas dan kata_sandi benar, Then sistem mengembalikan 200 dan data sesi sesuai kontrak
- Given kredensial salah, When login dikirim, Then sistem mengembalikan 401 dengan error "Kredensial tidak valid" dan tidak membuat sesi
- Given request tanpa identitas atau kata_sandi, When login dikirim, Then sistem menolak request dengan error yang jelas

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 2
Sebagai pengguna, saya ingin logout dari sistem, sehingga sesi saya berakhir dengan aman.

## Task
- BE: Implement endpoint POST /auth/logout sesuai kontrak dengan input id_sesi
- BE: Update tabel sesi_pengguna (status_aktif=false, waktu_keluar)
- FE: Tambahkan aksi logout dan redirect ke halaman login
- QA: Uji logout sukses dan akses halaman internal setelah logout

## Acceptance Criteria
- Given pengguna sudah login, When klik logout, Then sistem mengembalikan 200 dengan status "logout_berhasil"
- Given id_sesi tidak ditemukan, When logout dikirim, Then sistem mengembalikan 404
- Given logout sukses, When akses halaman internal via URL, Then diredireksi ke login

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----


# User Story 3
Sebagai Super Admin, saya ingin melihat daftar seluruh pengguna, sehingga saya bisa memantau user yang ada.

## Task
- BE: Implement endpoint GET /pengguna sesuai kontrak dengan query cari
- BE: Query tabel pengguna berdasarkan nama/email/username
- FE: Halaman daftar pengguna dan input pencarian
- QA: Uji list pengguna, pencarian, dan akses tanpa izin

## Acceptance Criteria
- Given Super Admin membuka menu User, When daftar dimuat, Then sistem mengembalikan 200 dengan data pengguna
- Given input pencarian, When cari nama/email/username, Then hasil relevan tampil
- Given role tidak berizin, When akses /pengguna, Then sistem mengembalikan 403

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----


# User Story 4
Sebagai Super Admin, saya ingin reset password pengguna, untuk membantu user yang lupa akses.

## Task
- BE: Implement endpoint POST /pengguna/{id_pengguna}/reset-kata-sandi sesuai kontrak
- BE: Update kata_sandi_hash di tabel pengguna dan simpan log_reset_kata_sandi
- FE: Aksi reset password dengan input alasan
- QA: Uji reset sukses dan login dengan password lama ditolak

## Acceptance Criteria
- Given admin memilih user, When reset dikirim, Then sistem mengembalikan 200 dengan status "reset_berhasil"
- Given id_pengguna tidak ditemukan, When reset dikirim, Then sistem mengembalikan 404
- Given reset sukses, When user login dengan password lama, Then login ditolak

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----


# User Story 5
Sebagai Akademik, saya ingin mengelola data guru aktif, untuk memastikan data staf pengajar lengkap.

## Task
- BE: Implement endpoint GET /guru, POST /guru, PATCH /guru/{id_guru} sesuai kontrak
- BE: Simpan data ke tabel guru dan validasi keunikan nip
- FE: Halaman list guru, form tambah, dan aksi ubah status
- QA: Uji tambah guru, NIP duplikat, dan ubah status non-aktif

## Acceptance Criteria
- Given Akademik menambah guru valid, When simpan, Then sistem mengembalikan 201 dan id_guru
- Given NIP sudah terdaftar, When simpan, Then sistem mengembalikan 409
- Given status guru diubah ke non-aktif, Then guru tidak muncul di jadwal

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 6
Sebagai Akademik, saya ingin mengelola data siswa, untuk memelihara database peserta didik.

## Task
- BE: Implement endpoint GET /siswa dan POST /siswa sesuai kontrak
- BE: Simpan data ke tabel siswa dan validasi keunikan nisn
- FE: Halaman list siswa, filter tahun_masuk, dan form tambah
- QA: Uji tambah siswa, filter tahun angkatan, dan NISN duplikat

## Acceptance Criteria
- Given Akademik menambah siswa valid, When simpan, Then sistem mengembalikan 201 dan id_siswa
- Given NISN sudah terdaftar, When simpan, Then sistem mengembalikan 409
- Given filter tahun_masuk, When query dikirim, Then hanya siswa angkatan tersebut yang tampil

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 7
Sebagai Guru, saya ingin mencatat absensi siswa per jadwal, untuk mendata kehadiran di kelas.

## Task
- BE: Implement endpoint POST /absensi sesuai kontrak
- BE: Simpan data ke tabel absensi_siswa dan referensi id_absensi_kelas
- FE: Form absensi per jadwal dengan daftar siswa
- QA: Uji simpan absensi dan validasi status_kehadiran wajib

## Acceptance Criteria
- Given guru membuka sesi absen, When tandai siswa "Hadir", Then data absensi tersimpan
- Given status_kehadiran kosong, When simpan, Then sistem mengembalikan 422
- Given id_absensi_kelas tidak valid, When simpan, Then sistem menolak request

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 8
Sebagai Guru, saya ingin membuat tugas dengan instruksi, agar siswa paham cara pengerjaan tugas.

## Task
- BE: Implement endpoint POST /tugas sesuai kontrak
- BE: Simpan data ke tabel tugas (judul, instruksi, lampiran_url, batas_waktu)
- FE: Form pembuatan tugas dengan instruksi dan lampiran
- QA: Uji pembuatan tugas dan validasi data wajib

## Acceptance Criteria
- Given guru membuat tugas dengan instruksi, When simpan, Then instruksi tersimpan
- Given edit tugas dengan instruksi kosong, When simpan, Then instruksi tersimpan sebagai kosong
- Given data wajib kosong, When simpan, Then sistem mengembalikan 422

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 9
Sebagai Guru, saya ingin menentukan deadline tugas, agar siswa disiplin mengumpulkan.

## Task
- BE: Simpan batas_waktu pada tabel tugas dan validasi format waktunya
- BE: Validasi batas_waktu pada endpoint POST /tugas/{id_tugas}/pengumpulan
- FE: Tampilkan deadline dan non-aktifkan tombol submit setelah deadline
- QA: Uji upload sebelum dan sesudah deadline

## Acceptance Criteria
- Given guru set deadline valid, When tugas dibuat, Then batas_waktu tersimpan
- Given deadline lewat, When siswa coba upload, Then submit non-aktif atau ditolak
- Given deadline belum lewat, When siswa upload, Then pengumpulan diterima

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 10
Sebagai Guru, saya ingin memberikan nilai terhadap tugas, untuk memberikan apresiasi hasil kerja.

## Task
- BE: Implement endpoint POST /nilai-tugas sesuai kontrak
- BE: Simpan ke tabel nilai_tugas dan validasi skor maksimum (<= 100)
- FE: Form input skor dan catatan
- QA: Uji skor valid dan skor > 100

## Acceptance Criteria
- Given guru input skor 85, When simpan, Then sistem mengembalikan 201 dan id_nilai_tugas
- Given skor > 100, When simpan, Then sistem mengembalikan 422
- Given catatan diisi, Then catatan tersimpan di nilai_tugas

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 11
Sebagai Siswa, saya ingin melihat jadwal harian, agar saya tahu pelajaran apa yang diikuti.

## Task
- BE: Implement endpoint GET /jadwal-harian sesuai kontrak
- BE: Ambil jadwal dari jadwal_pelajaran berdasarkan id_siswa, tanggal, dan keanggotaan_kelas aktif
- FE: Halaman jadwal harian siswa
- QA: Uji jadwal hari ini dan hari libur

## Acceptance Criteria
- Given siswa membuka menu Jadwal, When jadwal ada, Then sistem mengembalikan 200 dan data jadwal
- Given hari libur, When cek jadwal, Then sistem mengembalikan 404 dengan error "Tidak ada jadwal"

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 12
Sebagai Siswa, saya ingin akses & unduh materi, untuk mendukung proses belajar.

## Task
- BE: Gunakan endpoint GET /materi, /materi/{id_materi}/unduh, /materi/{id_materi}/stream
- BE: Pastikan akses materi sesuai mapel/kelas siswa
- FE: List materi, tombol unduh, dan pemutar video
- QA: Uji unduh materi dan stream video

## Acceptance Criteria
- Given list materi, When klik unduh, Then file terunduh
- Given materi video, When klik play, Then video terputar di browser
- Given materi tidak ditemukan, When akses, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 13
Sebagai Siswa, saya ingin melihat detail tugas & deadline, agar saya tidak terlambat mengumpulkan.

## Task
- BE: Implement endpoint GET /tugas/{id_tugas} dan sertakan status pengerjaan siswa
- BE: Ambil status dari pengumpulan_tugas dan hitung sisa waktu
- FE: Halaman detail tugas dan status pengerjaan
- QA: Uji status "Belum Dikerjakan" dan "Sudah Dikerjakan"

## Acceptance Criteria
- Given siswa klik satu tugas, When detail diminta, Then detail dan deadline tampil
- Given tugas sudah dikerjakan, When cek detail, Then status "Sudah Dikerjakan"
- Given tugas belum dikerjakan, When cek detail, Then status "Belum Dikerjakan"

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 14
Sebagai Siswa, saya ingin melihat nilai tugas & ujian, agar saya tahu pencapaian saya.

## Task
- BE: Implement endpoint GET /nilai sesuai kontrak dengan query id_siswa
- BE: Ambil nilai dari nilai_tugas dan hasil ujian, beri status "Menunggu Penilaian" jika belum ada
- FE: Halaman nilai siswa
- QA: Uji nilai tersedia dan status menunggu

## Acceptance Criteria
- Given tugas dinilai, When buka menu Nilai, Then angka nilai tampil
- Given belum dinilai, When cek nilai, Then status "Menunggu Penilaian" tampil
- Given id_siswa tidak valid, When request dikirim, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 15
Sebagai Super Admin, saya ingin membuat akun untuk Pimpinan/Guru/Siswa, agar mereka bisa mengakses sistem.

## Task
- BE: Implement endpoint POST /pengguna sesuai kontrak
- BE: Simpan ke tabel pengguna, validasi email/username unik, dan buat relasi pengguna_peran
- FE: Form pembuatan user dan pemilihan peran
- QA: Uji pembuatan akun sukses dan email sudah terdaftar

## Acceptance Criteria
- Given admin input data valid, When simpan, Then sistem mengembalikan 201 dan status "akun_aktif"
- Given email sudah terdaftar, When simpan, Then sistem mengembalikan 409
- Given data wajib kosong, When simpan, Then sistem menolak request

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 16
Sebagai Super Admin, saya ingin memperbarui data pengguna, agar informasi user tetap valid.

## Task
- BE: Implement endpoint PATCH /pengguna/{id_pengguna} sesuai kontrak
- BE: Validasi id_pengguna dan keunikan email/username saat diubah
- FE: Form edit user dengan aksi simpan/batal
- QA: Uji update sukses, batal edit, dan id tidak ditemukan

## Acceptance Criteria
- Given admin mengubah data user, When simpan, Then sistem mengembalikan 200 dengan status "terbarui"
- Given admin klik batal, Then data tidak berubah
- Given id_pengguna tidak ditemukan, When update dikirim, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 17
Sebagai Super Admin, saya ingin menghapus akun pengguna, untuk membersihkan user yang tidak aktif.

## Task
- BE: Implement endpoint DELETE /pengguna/{id_pengguna} sesuai kontrak
- BE: Tangani relasi FK (pengguna_peran, guru, siswa, sesi_pengguna)
- FE: Aksi hapus dengan konfirmasi
- QA: Uji hapus sukses dan batal hapus

## Acceptance Criteria
- Given admin konfirmasi hapus, When delete dikirim, Then sistem mengembalikan 200 dan status "terhapus"
- Given admin membatalkan, Then user tetap ada
- Given id_pengguna tidak ditemukan, When delete dikirim, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 18
Sebagai Super Admin, saya ingin mengelola role dan permissions, untuk mengatur batasan akses fitur.

## Task
- BE: Implement endpoint GET /peran dan POST /peran/{id_peran}/izin
- BE: Update tabel peran_izin dan validasi id_peran/id_izin
- FE: UI manajemen role dan izin
- QA: Uji tambah/hapus izin dan peran tidak ditemukan

## Acceptance Criteria
- Given admin menambah akses fitur, When simpan, Then sistem mengembalikan 200 dengan status "izin_terbarui"
- Given admin menghapus akses, When simpan, Then role kehilangan akses tersebut
- Given peran tidak ditemukan, When update izin, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 19
Sebagai Akademik, saya ingin membuat data kurikulum baru, agar standar pembelajaran tersedia.

## Task
- BE: Implement endpoint POST /kurikulum sesuai kontrak
- BE: Simpan ke tabel kurikulum dan validasi field wajib
- FE: Form input kurikulum
- QA: Uji data kosong dan sukses

## Acceptance Criteria
- Given Akademik input data valid, When simpan, Then sistem mengembalikan 201 dan id_kurikulum
- Given data wajib kosong, When simpan, Then sistem mengembalikan 422

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 20
Sebagai Akademik, saya ingin memperbarui data kurikulum, agar kurikulum tetap relevan.

## Task
- BE: Implement endpoint PATCH /kurikulum/{id_kurikulum} sesuai kontrak
- BE: Validasi id_kurikulum ada
- FE: Form edit kurikulum dengan aksi Back
- QA: Uji update sukses dan id tidak ditemukan

## Acceptance Criteria
- Given Akademik mengubah kurikulum, When simpan, Then sistem mengembalikan 200 dengan status "terbarui"
- Given klik Back, Then perubahan tidak disimpan
- Given id_kurikulum tidak ditemukan, When update dikirim, Then sistem mengembalikan 404

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 21
Sebagai Akademik, saya ingin mengatur jadwal pelajaran per kelas, agar KBM terorganisir.

## Task
- BE: Implement endpoint POST /jadwal sesuai kontrak
- BE: Simpan ke tabel jadwal_pelajaran dan validasi konflik jadwal
- FE: Form penjadwalan mapel per kelas
- QA: Uji jadwal sukses dan jadwal bentrok

## Acceptance Criteria
- Given jadwal valid, When simpan, Then sistem mengembalikan 201 dan id_jadwal
- Given jadwal bentrok, When simpan, Then sistem mengembalikan 409 dengan error "Jadwal bentrok"

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 22
Sebagai Akademik, saya ingin penugasan guru ke mapel & kelas, agar tanggung jawab mengajar jelas.

## Task
- BE: Implement endpoint POST /penugasan-guru dan DELETE /penugasan-guru/{id_penugasan}
- BE: Simpan ke tabel penugasan_guru dan validasi duplikasi
- FE: UI penugasan guru ke mapel/kelas
- QA: Uji penugasan baru dan duplikasi

## Acceptance Criteria
- Given penugasan valid, When simpan, Then sistem mengembalikan 201 dan id_penugasan
- Given penugasan sudah ada, When simpan, Then sistem mengembalikan 409
- Given hapus penugasan, When delete dikirim, Then sistem mengembalikan 200

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 23
Sebagai Akademik, saya ingin penempatan siswa ke kelas per tahun ajaran, agar pembagian rombel rapi.

## Task
- BE: Implement endpoint POST /keanggotaan-kelas dan PATCH /keanggotaan-kelas/{id_keanggotaan_kelas}
- BE: Simpan ke tabel keanggotaan_kelas dan validasi konflik siswa aktif di kelas lain
- FE: UI penempatan dan pemindahan siswa
- QA: Uji penempatan baru dan pindah kelas

## Acceptance Criteria
- Given penempatan valid, When simpan, Then sistem mengembalikan 201 dan id_keanggotaan_kelas
- Given siswa sudah di kelas lain, When simpan, Then sistem mengembalikan 409
- Given pindah kelas, When update dikirim, Then sistem mengembalikan 200

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 24
Sebagai Guru, saya ingin unggah materi belajar (dok/video), agar siswa bisa belajar mandiri.

## Task
- BE: Implement endpoint POST /materi, GET /materi, /materi/{id_materi}/unduh, /materi/{id_materi}/stream
- BE: Simpan metadata ke tabel materi_pembelajaran dan validasi ukuran file 20MB
- FE: Form upload dan list materi
- QA: Uji upload sukses dan file terlalu besar

## Acceptance Criteria
- Given guru upload file <= 20MB, When simpan, Then sistem mengembalikan 201
- Given upload > 20MB, When simpan, Then sistem mengembalikan 413
- Given siswa akses materi video, When play, Then video terputar

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 25
Sebagai Guru, saya ingin membuat & menjadwalkan ujian, untuk mengevaluasi hasil belajar.

## Task
- BE: Implement endpoint POST /ujian dan DELETE /ujian/{id_ujian} sesuai kontrak
- BE: Simpan ke tabel ujian dan validasi waktu_mulai/durasi
- FE: Form pembuatan ujian dan daftar jadwal
- QA: Uji buat ujian dan hapus jadwal

## Acceptance Criteria
- Given jadwal valid, When simpan ujian, Then sistem mengembalikan 201
- Given jadwal tidak valid, When simpan, Then sistem mengembalikan 422
- Given hapus ujian, When delete dikirim, Then sistem mengembalikan 200

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 26
Sebagai Siswa, saya ingin mengunggah hasil tugas, untuk memenuhi kewajiban belajar.

## Task
- BE: Implement endpoint POST /tugas/{id_tugas}/pengumpulan (multipart)
- BE: Simpan ke tabel pengumpulan_tugas dan set status terkirim/revisi/terlambat
- FE: Form upload tugas dan tombol retry
- QA: Uji upload sukses dan retry saat gagal

## Acceptance Criteria
- Given siswa upload file valid, When submit, Then status "Terkirim"
- Given submit gagal, When klik retry, Then file mencoba terunggah kembali
- Given deadline lewat, When submit, Then ditolak atau status "terlambat" sesuai aturan

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 27
Sebagai Siswa, saya ingin mengikuti ujian daring, untuk mengerjakan tes secara fleksibel.

## Task
- BE: Implement endpoint POST /ujian/{id_ujian}/mulai dan /ujian/{id_ujian}/jawaban
- BE: Simpan ke tabel peserta_ujian dan jawaban_ujian
- FE: Halaman ujian dengan timer dan autosave
- QA: Uji mulai ujian sesuai jadwal dan simpan otomatis saat waktu habis

## Acceptance Criteria
- Given jam ujian tiba, When klik "Mulai", Then soal tampil dan timer berjalan
- Given ujian belum aktif, When mulai ujian, Then sistem mengembalikan 409
- Given waktu habis, When mengerjakan, Then jawaban otomatis tersimpan

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 28
Sebagai Siswa, saya ingin melihat laporan raport, untuk melihat rangkuman hasil belajar.

## Task
- BE: Implement endpoint GET /rapor (jika belum ada di kontrak) untuk rapor dan rapor_detail
- BE: Ambil data dari tabel rapor dan rapor_detail
- FE: Halaman rapor dan tombol cetak PDF
- QA: Uji rapor tersedia dan unduh PDF

## Acceptance Criteria
- Given akhir semester, When buka menu Raport, Then nilai semua mapel tampil
- Given rapor tersedia, When klik cetak PDF, Then file rapor terunduh
- Given rapor belum tersedia, When buka menu Raport, Then tampil pesan yang sesuai

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 29
Sebagai pengguna, saya ingin memperbarui profil pribadi, sehingga data kontak saya tetap akurat.

## Task
- BE: Implement endpoint PATCH /profil sesuai kontrak
- BE: Update tabel pengguna dan validasi format email
- FE: Form profil pribadi
- QA: Uji update profil dan format email tidak valid

## Acceptance Criteria
- Given update valid, When simpan, Then sistem mengembalikan 200 dengan status "terbarui"
- Given format email tidak valid, When simpan, Then sistem mengembalikan 422

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 30
Sebagai Super Admin, saya ingin akses ke seluruh dashboard pelaporan, agar bisa memantau aktivitas sistem & akademik.

## Task
- BE: Definisikan endpoint ringkasan dashboard (belum ada di kontrak)
- BE: Agregasi data dari tabel pengguna, guru, siswa, absensi, tugas, ujian, rapor
- FE: Halaman dashboard admin dengan ringkasan dan detail
- QA: Uji akses admin dan data ringkasan

## Acceptance Criteria
- Given login sebagai Admin, When buka dashboard, Then ringkasan data tampil
- Given klik detail laporan, When detail diminta, Then data mendalam tampil

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 31
Sebagai Guru, saya ingin memberikan feedback pada hasil siswa, agar siswa tahu bagian mana yang harus diperbaiki.

## Task
- BE: Gunakan field catatan di nilai_tugas untuk feedback
- BE: Tambahkan endpoint update nilai_tugas jika belum ada
- FE: Form input/edit catatan dan tampilkan ke siswa
- QA: Uji tambah dan edit catatan

## Acceptance Criteria
- Given guru menulis komentar evaluasi, When simpan, Then catatan tersimpan
- Given guru mengedit komentar, When simpan, Then catatan terbaru tersimpan

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 32
Sebagai Pimpinan, saya ingin laporan agregat kehadiran siswa, untuk memantau kedisiplinan sekolah.

## Task
- BE: Buat endpoint laporan kehadiran (belum ada di kontrak)
- BE: Hitung persentase kehadiran dari absensi_siswa per kelas
- FE: Halaman laporan kehadiran dengan filter kelas
- QA: Uji laporan dengan data kosong dan data tersedia

## Acceptance Criteria
- Given pilih filter kelas, When laporan diminta, Then persentase kehadiran tampil
- Given data absen kosong, When laporan diminta, Then grafik menampilkan angka nol

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 33
Sebagai Pimpinan, saya ingin laporan nilai per kelas/mapel, untuk evaluasi mutu akademik.

## Task
- BE: Buat endpoint laporan nilai per kelas/mapel (belum ada di kontrak)
- BE: Agregasi dari nilai_tugas dan rapor_detail
- FE: Halaman laporan nilai dengan filter kelas/mapel dan export excel
- QA: Uji filter dan export excel

## Acceptance Criteria
- Given pilih Mapel, When laporan diminta, Then rata-rata nilai tampil
- Given filter kelas, When laporan diminta, Then data sesuai kelas
- Given klik export excel, Then file laporan terunduh

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 34
Sebagai Pimpinan, saya ingin filter laporan berdasar rentang tanggal, untuk laporan periodik.

## Task
- BE: Tambahkan filter tanggal pada endpoint laporan (kehadiran/nilai/dashboard)
- BE: Validasi rentang tanggal
- FE: Input rentang tanggal pada halaman laporan
- QA: Uji rentang tanggal valid dan tidak valid

## Acceptance Criteria
- Given set rentang tanggal valid, When filter diterapkan, Then data sesuai periode
- Given rentang tanggal salah, When filter diterapkan, Then pesan "Tanggal tidak valid" tampil

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 35
Sebagai Pimpinan, saya ingin dashboard monitoring kinerja sekolah, untuk melihat performa umum.

## Task
- BE: Buat endpoint dashboard kinerja (belum ada di kontrak)
- BE: Agregasi metrik dari absensi, nilai, ujian, dan tugas
- FE: Halaman dashboard pimpinan dengan widget statistik
- QA: Uji refresh data dan kondisi data kosong

## Acceptance Criteria
- Given login pimpinan, When buka dashboard, Then widget statistik utama tampil
- Given klik refresh, When data diambil ulang, Then data terbaru tampil

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 36
Sebagai Pimpinan, saya ingin statistik nilai rata-rata per kelas, untuk membandingkan antar kelas.

## Task
- BE: Buat endpoint statistik rata-rata per kelas (belum ada di kontrak)
- BE: Hitung rata-rata dari rapor_detail atau nilai_tugas per kelas
- FE: Halaman statistik dengan grafik komparasi
- QA: Uji komparasi kelas dan data minim

## Acceptance Criteria
- Given bandingkan Kelas A & B, When statistik diminta, Then grafik komparasi tampil
- Given data nilai minim, When cek rata-rata, Then sistem tetap menghitung yang ada

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA

-----
-----

# User Story 37
Sebagai Pimpinan, saya ingin melihat ranking nilai siswa, untuk mengetahui siswa berprestasi.

## Task
- BE: Buat endpoint ranking nilai siswa (belum ada di kontrak)
- BE: Urutkan berdasarkan nilai rata-rata, tie-breaker nama
- FE: Halaman ranking dengan filter angkatan
- QA: Uji ranking dan nilai sama

## Acceptance Criteria
- Given pilih angkatan, When ranking diminta, Then list siswa dari nilai tertinggi tampil
- Given nilai sama, When diurutkan, Then urut berdasarkan nama (alfabet)

## Estimation
5 story points

## Definition of Done
deployed to staging, tested by QA
