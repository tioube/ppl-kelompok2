# Skema Basis Data (PostgreSQL)

## 1) pengguna
- kolom:
	- id_pengguna (uuid, pk)
	- nama_lengkap (varchar(150))
	- email (varchar(150), unik)
	- username (varchar(60), unik)
	- kata_sandi_hash (text)
	- nomor_telepon (varchar(30))
	- foto_profil_url (text)
	- status_aktif (boolean)
	- dibuat_pada (timestamptz)
	- diperbarui_pada (timestamptz)
- relasi:
	- pengguna.id_pengguna -> sesi_pengguna.id_pengguna
	- pengguna.id_pengguna -> pengguna_peran.id_pengguna
	- pengguna.id_pengguna -> guru.id_pengguna (opsional)
	- pengguna.id_pengguna -> siswa.id_pengguna (opsional)

## 2) peran
- kolom:
	- id_peran (serial, pk)
	- nama_peran (varchar(50), unik) -- contoh: super_admin, akademik, guru, siswa, pimpinan
	- deskripsi (text)
- relasi:
	- peran.id_peran -> pengguna_peran.id_peran
	- peran.id_peran -> peran_izin.id_peran

## 3) izin
- kolom:
	- id_izin (serial, pk)
	- kode_izin (varchar(80), unik)
	- nama_izin (varchar(120))
	- deskripsi (text)
- relasi:
	- izin.id_izin -> peran_izin.id_izin

## 4) pengguna_peran
- kolom:
	- id_pengguna_peran (bigserial, pk)
	- id_pengguna (uuid, fk)
	- id_peran (int, fk)
	- dibuat_pada (timestamptz)
- relasi:
	- pengguna_peran.id_pengguna -> pengguna.id_pengguna
	- pengguna_peran.id_peran -> peran.id_peran

## 5) peran_izin
- kolom:
	- id_peran_izin (bigserial, pk)
	- id_peran (int, fk)
	- id_izin (int, fk)
	- dibuat_pada (timestamptz)
- relasi:
	- peran_izin.id_peran -> peran.id_peran
	- peran_izin.id_izin -> izin.id_izin

## 6) sesi_pengguna
- kolom:
	- id_sesi (uuid, pk)
	- id_pengguna (uuid, fk)
	- token_sesi (text, unik)
	- ip_masuk (varchar(45))
	- agen_pengguna (text)
	- waktu_masuk (timestamptz)
	- waktu_keluar (timestamptz)
	- status_aktif (boolean)
- relasi:
	- sesi_pengguna.id_pengguna -> pengguna.id_pengguna

## 7) guru
- kolom:
	- id_guru (uuid, pk)
	- id_pengguna (uuid, fk)
	- nip (varchar(30), unik)
	- nama_guru (varchar(150))
	- status_aktif (boolean)
	- dibuat_pada (timestamptz)
	- diperbarui_pada (timestamptz)
- relasi:
	- guru.id_pengguna -> pengguna.id_pengguna
	- guru.id_guru -> penugasan_guru.id_guru
	- guru.id_guru -> materi_pembelajaran.id_guru
	- guru.id_guru -> tugas.id_guru
	- guru.id_guru -> ujian.id_guru
	- guru.id_guru -> absensi_kelas.id_guru

## 8) siswa
- kolom:
	- id_siswa (uuid, pk)
	- id_pengguna (uuid, fk)
	- nisn (varchar(30), unik)
	- nama_siswa (varchar(150))
	- tahun_masuk (int)
	- dibuat_pada (timestamptz)
	- diperbarui_pada (timestamptz)
- relasi:
	- siswa.id_pengguna -> pengguna.id_pengguna
	- siswa.id_siswa -> keanggotaan_kelas.id_siswa
	- siswa.id_siswa -> absensi_siswa.id_siswa
	- siswa.id_siswa -> pengumpulan_tugas.id_siswa
	- siswa.id_siswa -> nilai_tugas.id_siswa
	- siswa.id_siswa -> peserta_ujian.id_siswa
	- siswa.id_siswa -> jawaban_ujian.id_siswa

## 9) tahun_ajaran
- kolom:
	- id_tahun_ajaran (serial, pk)
	- nama_tahun (varchar(20)) -- contoh: 2025/2026
	- tanggal_mulai (date)
	- tanggal_selesai (date)
	- status_aktif (boolean)

## 10) kelas
- kolom:
	- id_kelas (serial, pk)
	- nama_kelas (varchar(50)) -- contoh: XI-B
	- tingkat (int)
	- id_tahun_ajaran (int, fk)
- relasi:
	- kelas.id_tahun_ajaran -> tahun_ajaran.id_tahun_ajaran
	- kelas.id_kelas -> keanggotaan_kelas.id_kelas
	- kelas.id_kelas -> penugasan_guru.id_kelas
	- kelas.id_kelas -> jadwal_pelajaran.id_kelas
	- kelas.id_kelas -> absensi_kelas.id_kelas
	- kelas.id_kelas -> tugas.id_kelas
	- kelas.id_kelas -> ujian.id_kelas

## 11) keanggotaan_kelas
- kolom:
	- id_keanggotaan_kelas (bigserial, pk)
	- id_siswa (uuid, fk)
	- id_kelas (int, fk)
	- id_tahun_ajaran (int, fk)
	- tanggal_masuk (date)
	- tanggal_keluar (date)
	- status_aktif (boolean)
- relasi:
	- keanggotaan_kelas.id_siswa -> siswa.id_siswa
	- keanggotaan_kelas.id_kelas -> kelas.id_kelas
	- keanggotaan_kelas.id_tahun_ajaran -> tahun_ajaran.id_tahun_ajaran

## 12) kurikulum
- kolom:
	- id_kurikulum (serial, pk)
	- nama_kurikulum (varchar(120))
	- tahun_berlaku (int)
	- deskripsi (text)
	- status_aktif (boolean)
- relasi:
	- kurikulum.id_kurikulum -> mapel.id_kurikulum

## 13) mapel
- kolom:
	- id_mapel (serial, pk)
	- id_kurikulum (int, fk)
	- nama_mapel (varchar(120))
	- kode_mapel (varchar(30))
	- deskripsi (text)
- relasi:
	- mapel.id_kurikulum -> kurikulum.id_kurikulum
	- mapel.id_mapel -> penugasan_guru.id_mapel
	- mapel.id_mapel -> jadwal_pelajaran.id_mapel
	- mapel.id_mapel -> materi_pembelajaran.id_mapel
	- mapel.id_mapel -> tugas.id_mapel
	- mapel.id_mapel -> ujian.id_mapel
	- mapel.id_mapel -> rapor.nilai_mapel (referensi logis)

## 14) penugasan_guru
- kolom:
	- id_penugasan (bigserial, pk)
	- id_guru (uuid, fk)
	- id_mapel (int, fk)
	- id_kelas (int, fk)
	- id_tahun_ajaran (int, fk)
	- status_aktif (boolean)
- relasi:
	- penugasan_guru.id_guru -> guru.id_guru
	- penugasan_guru.id_mapel -> mapel.id_mapel
	- penugasan_guru.id_kelas -> kelas.id_kelas
	- penugasan_guru.id_tahun_ajaran -> tahun_ajaran.id_tahun_ajaran

## 15) jadwal_pelajaran
- kolom:
	- id_jadwal (bigserial, pk)
	- id_kelas (int, fk)
	- id_mapel (int, fk)
	- id_guru (uuid, fk)
	- hari (varchar(10)) -- senin, selasa, dst
	- jam_mulai (time)
	- jam_selesai (time)
	- ruang (varchar(30))
	- id_tahun_ajaran (int, fk)
- relasi:
	- jadwal_pelajaran.id_kelas -> kelas.id_kelas
	- jadwal_pelajaran.id_mapel -> mapel.id_mapel
	- jadwal_pelajaran.id_guru -> guru.id_guru
	- jadwal_pelajaran.id_tahun_ajaran -> tahun_ajaran.id_tahun_ajaran

## 16) absensi_kelas
- kolom:
	- id_absensi_kelas (bigserial, pk)
	- id_kelas (int, fk)
	- id_mapel (int, fk)
	- id_guru (uuid, fk)
	- tanggal (date)
	- id_jadwal (bigserial, fk)
	- catatan (text)
- relasi:
	- absensi_kelas.id_kelas -> kelas.id_kelas
	- absensi_kelas.id_mapel -> mapel.id_mapel
	- absensi_kelas.id_guru -> guru.id_guru
	- absensi_kelas.id_jadwal -> jadwal_pelajaran.id_jadwal
	- absensi_kelas.id_absensi_kelas -> absensi_siswa.id_absensi_kelas

## 17) absensi_siswa
- kolom:
	- id_absensi_siswa (bigserial, pk)
	- id_absensi_kelas (bigserial, fk)
	- id_siswa (uuid, fk)
	- status_kehadiran (varchar(10)) -- hadir, izin, sakit, alpa
	- waktu_input (timestamptz)
- relasi:
	- absensi_siswa.id_absensi_kelas -> absensi_kelas.id_absensi_kelas
	- absensi_siswa.id_siswa -> siswa.id_siswa

## 18) materi_pembelajaran
- kolom:
	- id_materi (bigserial, pk)
	- id_guru (uuid, fk)
	- id_mapel (int, fk)
	- judul (varchar(200))
	- deskripsi (text)
	- jenis (varchar(20)) -- dokumen, video
	- url_file (text)
	- ukuran_byte (bigint)
	- dibuat_pada (timestamptz)
- relasi:
	- materi_pembelajaran.id_guru -> guru.id_guru
	- materi_pembelajaran.id_mapel -> mapel.id_mapel

## 19) tugas
- kolom:
	- id_tugas (bigserial, pk)
	- id_guru (uuid, fk)
	- id_mapel (int, fk)
	- id_kelas (int, fk)
	- judul (varchar(200))
	- instruksi (text)
	- lampiran_url (text)
	- batas_waktu (timestamptz)
	- dibuat_pada (timestamptz)
- relasi:
	- tugas.id_guru -> guru.id_guru
	- tugas.id_mapel -> mapel.id_mapel
	- tugas.id_kelas -> kelas.id_kelas
	- tugas.id_tugas -> pengumpulan_tugas.id_tugas
	- tugas.id_tugas -> nilai_tugas.id_tugas

## 20) pengumpulan_tugas
- kolom:
	- id_pengumpulan (bigserial, pk)
	- id_tugas (bigserial, fk)
	- id_siswa (uuid, fk)
	- url_file (text)
	- waktu_kirim (timestamptz)
	- status (varchar(20)) -- terkirim, revisi, terlambat
- relasi:
	- pengumpulan_tugas.id_tugas -> tugas.id_tugas
	- pengumpulan_tugas.id_siswa -> siswa.id_siswa

## 21) nilai_tugas
- kolom:
	- id_nilai_tugas (bigserial, pk)
	- id_tugas (bigserial, fk)
	- id_siswa (uuid, fk)
	- skor (numeric(5,2))
	- catatan (text)
	- dinilai_pada (timestamptz)
- relasi:
	- nilai_tugas.id_tugas -> tugas.id_tugas
	- nilai_tugas.id_siswa -> siswa.id_siswa

## 22) ujian
- kolom:
	- id_ujian (bigserial, pk)
	- id_guru (uuid, fk)
	- id_mapel (int, fk)
	- id_kelas (int, fk)
	- judul (varchar(200))
	- waktu_mulai (timestamptz)
	- durasi_menit (int)
	- status_aktif (boolean)
- relasi:
	- ujian.id_guru -> guru.id_guru
	- ujian.id_mapel -> mapel.id_mapel
	- ujian.id_kelas -> kelas.id_kelas
	- ujian.id_ujian -> soal_ujian.id_ujian
	- ujian.id_ujian -> peserta_ujian.id_ujian
	- ujian.id_ujian -> jawaban_ujian.id_ujian

## 23) soal_ujian
- kolom:
	- id_soal (bigserial, pk)
	- id_ujian (bigserial, fk)
	- tipe (varchar(20)) -- pilihan_ganda, esai
	- pertanyaan (text)
	- opsi_a (text)
	- opsi_b (text)
	- opsi_c (text)
	- opsi_d (text)
	- jawaban_benar (varchar(1))
	- bobot (numeric(5,2))
- relasi:
	- soal_ujian.id_ujian -> ujian.id_ujian

## 24) peserta_ujian
- kolom:
	- id_peserta (bigserial, pk)
	- id_ujian (bigserial, fk)
	- id_siswa (uuid, fk)
	- waktu_mulai (timestamptz)
	- waktu_selesai (timestamptz)
	- status (varchar(20)) -- mulai, selesai, otomatis
- relasi:
	- peserta_ujian.id_ujian -> ujian.id_ujian
	- peserta_ujian.id_siswa -> siswa.id_siswa

## 25) jawaban_ujian
- kolom:
	- id_jawaban (bigserial, pk)
	- id_ujian (bigserial, fk)
	- id_soal (bigserial, fk)
	- id_siswa (uuid, fk)
	- jawaban (text)
	- skor (numeric(5,2))
	- dibuat_pada (timestamptz)
- relasi:
	- jawaban_ujian.id_ujian -> ujian.id_ujian
	- jawaban_ujian.id_soal -> soal_ujian.id_soal
	- jawaban_ujian.id_siswa -> siswa.id_siswa

## 26) rapor
- kolom:
	- id_rapor (bigserial, pk)
	- id_siswa (uuid, fk)
	- id_tahun_ajaran (int, fk)
	- semester (int)
	- nilai_rata_rata (numeric(5,2))
	- catatan (text)
	- dibuat_pada (timestamptz)
- relasi:
	- rapor.id_siswa -> siswa.id_siswa
	- rapor.id_tahun_ajaran -> tahun_ajaran.id_tahun_ajaran

## 27) rapor_detail
- kolom:
	- id_rapor_detail (bigserial, pk)
	- id_rapor (bigserial, fk)
	- id_mapel (int, fk)
	- nilai_mapel (numeric(5,2))
	- predikat (varchar(5))
- relasi:
	- rapor_detail.id_rapor -> rapor.id_rapor
	- rapor_detail.id_mapel -> mapel.id_mapel

## 28) log_reset_kata_sandi
- kolom:
	- id_log_reset (bigserial, pk)
	- id_pengguna (uuid, fk)
	- dilakukan_oleh (uuid, fk) -- super admin
	- waktu_reset (timestamptz)
	- alasan (text)
- relasi:
	- log_reset_kata_sandi.id_pengguna -> pengguna.id_pengguna
	- log_reset_kata_sandi.dilakukan_oleh -> pengguna.id_pengguna

## Catatan relasi utama
- Setiap pengguna bisa memiliki banyak peran melalui pengguna_peran.
- Guru dan siswa adalah profil khusus yang merujuk ke pengguna.
- Jadwal, absensi, materi, tugas, dan ujian terkait ke mapel, kelas, dan guru.
- Penilaian tugas dan ujian terkait langsung ke siswa.
- Rapor adalah rekap nilai per siswa per tahun ajaran.
