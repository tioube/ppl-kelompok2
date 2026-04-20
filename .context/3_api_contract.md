# API Contract

## 1. API Overview
- Purpose of the API: Mengelola sistem akademik sekolah (akun, peran, guru, siswa, jadwal, absensi, materi, tugas, ujian, nilai, rapor, dan laporan).
- High-level description of system/domain: Sistem informasi sekolah dengan peran Super Admin, Akademik, Guru, Siswa, dan Pimpinan untuk operasional akademik dan pelaporan.

## 2. Authentication
- Type: 
	> ⚠️ Not specified
- How to obtain and use it:
	> ⚠️ Not specified
- Example header:
	> ⚠️ Not specified

## 3. Base URL
```
⚠️ Not specified
```

## 4. Global Rules
- Content-Type: application/json (kecuali unggah/unduh file menggunakan multipart/form-data atau binary)
- Timezone handling: 
	> ⚠️ Not specified
- Pagination standard:
	> ⚠️ Not specified
- Error handling standard:
	> ⚠️ Not specified

## 5. Data Models / Schemas

### Model: Pengguna
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_pengguna | uuid | yes | ID pengguna |
| nama_lengkap | string | yes | Nama lengkap |
| email | string | yes | Email unik |
| username | string | yes | Username unik |
| kata_sandi_hash | string | yes | Hash kata sandi |
| nomor_telepon | string | no | Nomor telepon |
| foto_profil_url | string | no | URL foto profil |
| status_aktif | boolean | yes | Status aktif |
| dibuat_pada | datetime | yes | Waktu dibuat |
| diperbarui_pada | datetime | yes | Waktu diperbarui |

### Model: Peran
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_peran | int | yes | ID peran |
| nama_peran | string | yes | Nama peran |
| deskripsi | string | no | Deskripsi peran |

### Model: Izin
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_izin | int | yes | ID izin |
| kode_izin | string | yes | Kode izin unik |
| nama_izin | string | yes | Nama izin |
| deskripsi | string | no | Deskripsi izin |

### Model: Guru
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_guru | uuid | yes | ID guru |
| id_pengguna | uuid | yes | Relasi ke pengguna |
| nip | string | yes | NIP unik |
| nama_guru | string | yes | Nama guru |
| status_aktif | boolean | yes | Status aktif |
| dibuat_pada | datetime | yes | Waktu dibuat |
| diperbarui_pada | datetime | yes | Waktu diperbarui |

### Model: Siswa
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_siswa | uuid | yes | ID siswa |
| id_pengguna | uuid | yes | Relasi ke pengguna |
| nisn | string | yes | NISN unik |
| nama_siswa | string | yes | Nama siswa |
| tahun_masuk | int | yes | Tahun masuk |
| dibuat_pada | datetime | yes | Waktu dibuat |
| diperbarui_pada | datetime | yes | Waktu diperbarui |

### Model: Kelas
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_kelas | int | yes | ID kelas |
| nama_kelas | string | yes | Nama kelas |
| tingkat | int | yes | Tingkat |
| id_tahun_ajaran | int | yes | Relasi ke tahun ajaran |

### Model: TahunAjaran
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_tahun_ajaran | int | yes | ID tahun ajaran |
| nama_tahun | string | yes | Nama tahun ajaran |
| tanggal_mulai | date | yes | Tanggal mulai |
| tanggal_selesai | date | yes | Tanggal selesai |
| status_aktif | boolean | yes | Status aktif |

### Model: Kurikulum
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_kurikulum | int | yes | ID kurikulum |
| nama_kurikulum | string | yes | Nama kurikulum |
| tahun_berlaku | int | yes | Tahun berlaku |
| deskripsi | string | no | Deskripsi |
| status_aktif | boolean | yes | Status aktif |

### Model: Mapel
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_mapel | int | yes | ID mata pelajaran |
| id_kurikulum | int | yes | Relasi ke kurikulum |
| nama_mapel | string | yes | Nama mapel |
| kode_mapel | string | no | Kode mapel |
| deskripsi | string | no | Deskripsi |

### Model: PenugasanGuru
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_penugasan | int | yes | ID penugasan |
| id_guru | uuid | yes | Relasi ke guru |
| id_mapel | int | yes | Relasi ke mapel |
| id_kelas | int | yes | Relasi ke kelas |
| id_tahun_ajaran | int | yes | Relasi ke tahun ajaran |
| status_aktif | boolean | yes | Status aktif |

### Model: JadwalPelajaran
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_jadwal | int | yes | ID jadwal |
| id_kelas | int | yes | Relasi ke kelas |
| id_mapel | int | yes | Relasi ke mapel |
| id_guru | uuid | yes | Relasi ke guru |
| hari | string | yes | Hari jadwal |
| jam_mulai | time | yes | Jam mulai |
| jam_selesai | time | yes | Jam selesai |
| ruang | string | no | Ruang |
| id_tahun_ajaran | int | yes | Relasi ke tahun ajaran |

### Model: AbsensiKelas
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_absensi_kelas | int | yes | ID absensi kelas |
| id_kelas | int | yes | Relasi ke kelas |
| id_mapel | int | yes | Relasi ke mapel |
| id_guru | uuid | yes | Relasi ke guru |
| tanggal | date | yes | Tanggal absensi |
| id_jadwal | int | yes | Relasi ke jadwal |
| catatan | string | no | Catatan |

### Model: AbsensiSiswa
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_absensi_siswa | int | yes | ID absensi siswa |
| id_absensi_kelas | int | yes | Relasi ke absensi kelas |
| id_siswa | uuid | yes | Relasi ke siswa |
| status_kehadiran | string | yes | hadir/izin/sakit/alpa |
| waktu_input | datetime | yes | Waktu input |

### Model: MateriPembelajaran
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_materi | int | yes | ID materi |
| id_guru | uuid | yes | Relasi ke guru |
| id_mapel | int | yes | Relasi ke mapel |
| judul | string | yes | Judul materi |
| deskripsi | string | no | Deskripsi |
| jenis | string | yes | dokumen/video |
| url_file | string | yes | Lokasi file |
| ukuran_byte | int | yes | Ukuran file |
| dibuat_pada | datetime | yes | Waktu dibuat |

### Model: Tugas
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_tugas | int | yes | ID tugas |
| id_guru | uuid | yes | Relasi ke guru |
| id_mapel | int | yes | Relasi ke mapel |
| id_kelas | int | yes | Relasi ke kelas |
| judul | string | yes | Judul tugas |
| instruksi | string | no | Instruksi |
| lampiran_url | string | no | Lampiran |
| batas_waktu | datetime | yes | Deadline |
| dibuat_pada | datetime | yes | Waktu dibuat |

### Model: PengumpulanTugas
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_pengumpulan | int | yes | ID pengumpulan |
| id_tugas | int | yes | Relasi ke tugas |
| id_siswa | uuid | yes | Relasi ke siswa |
| url_file | string | yes | Lokasi file |
| waktu_kirim | datetime | yes | Waktu kirim |
| status | string | yes | terkirim/revisi/terlambat |

### Model: NilaiTugas
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_nilai_tugas | int | yes | ID nilai |
| id_tugas | int | yes | Relasi ke tugas |
| id_siswa | uuid | yes | Relasi ke siswa |
| skor | number | yes | Skor nilai |
| catatan | string | no | Catatan/feedback |
| dinilai_pada | datetime | yes | Waktu dinilai |

### Model: Ujian
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_ujian | int | yes | ID ujian |
| id_guru | uuid | yes | Relasi ke guru |
| id_mapel | int | yes | Relasi ke mapel |
| id_kelas | int | yes | Relasi ke kelas |
| judul | string | yes | Judul ujian |
| waktu_mulai | datetime | yes | Waktu mulai |
| durasi_menit | int | yes | Durasi |
| status_aktif | boolean | yes | Status aktif |

### Model: SoalUjian
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_soal | int | yes | ID soal |
| id_ujian | int | yes | Relasi ke ujian |
| tipe | string | yes | pilihan_ganda/esai |
| pertanyaan | string | yes | Pertanyaan |
| opsi_a | string | no | Opsi A |
| opsi_b | string | no | Opsi B |
| opsi_c | string | no | Opsi C |
| opsi_d | string | no | Opsi D |
| jawaban_benar | string | no | Kunci jawaban |
| bobot | number | yes | Bobot |

### Model: PesertaUjian
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_peserta | int | yes | ID peserta |
| id_ujian | int | yes | Relasi ke ujian |
| id_siswa | uuid | yes | Relasi ke siswa |
| waktu_mulai | datetime | no | Waktu mulai |
| waktu_selesai | datetime | no | Waktu selesai |
| status | string | yes | mulai/selesai/otomatis |

### Model: JawabanUjian
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_jawaban | int | yes | ID jawaban |
| id_ujian | int | yes | Relasi ke ujian |
| id_soal | int | yes | Relasi ke soal |
| id_siswa | uuid | yes | Relasi ke siswa |
| jawaban | string | yes | Jawaban |
| skor | number | no | Skor per soal |
| dibuat_pada | datetime | yes | Waktu dibuat |

### Model: Rapor
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_rapor | int | yes | ID rapor |
| id_siswa | uuid | yes | Relasi ke siswa |
| id_tahun_ajaran | int | yes | Relasi ke tahun ajaran |
| semester | int | yes | Semester |
| nilai_rata_rata | number | yes | Nilai rata-rata |
| catatan | string | no | Catatan |
| dibuat_pada | datetime | yes | Waktu dibuat |

### Model: RaporDetail
| Field | Type | Required | Description |
|------|------|----------|-------------|
| id_rapor_detail | int | yes | ID detail rapor |
| id_rapor | int | yes | Relasi ke rapor |
| id_mapel | int | yes | Relasi ke mapel |
| nilai_mapel | number | yes | Nilai mapel |
| predikat | string | no | Predikat |

## 6. Endpoints

### POST /auth/login

**Description**  
Login pengguna menggunakan email atau username dan kata sandi.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"identitas": "user@example.com",
	"kata_sandi": "Rahasia123"
}
```

**Response**

Success Response:
```json
{
	"id_sesi": "b7f4c7a8-9a31-4f8b-9d4e-3f2f8c8b4d41",
	"id_pengguna": "d0c4f4b3-2c31-4c8c-9a3a-111111111111",
	"status_aktif": true
}
```

Error Response:
```json
{
	"error": "Kredensial tidak valid"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 401 | Unauthorized |

---

### POST /auth/logout

**Description**  
Logout pengguna dan mengakhiri sesi aktif.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_sesi": "b7f4c7a8-9a31-4f8b-9d4e-3f2f8c8b4d41"
}
```

**Response**

Success Response:
```json
{
	"status": "logout_berhasil"
}
```

Error Response:
```json
{
	"error": "Sesi tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /pengguna

**Description**  
Melihat daftar seluruh pengguna.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| cari | string | no | Pencarian nama/email/username |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_pengguna": "d0c4f4b3-2c31-4c8c-9a3a-111111111111",
			"nama_lengkap": "Budi Santoso",
			"email": "budi@example.com",
			"username": "budi",
			"status_aktif": true
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### POST /pengguna

**Description**  
Membuat akun untuk Pimpinan, Akademik, Guru, dan Siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"nama_lengkap": "Siti Aminah",
	"email": "siti@example.com",
	"username": "siti",
	"kata_sandi": "Rahasia123",
	"peran": ["siswa"],
	"nomor_telepon": "08123456789"
}
```

**Response**

Success Response:
```json
{
	"id_pengguna": "e2e06b63-2c2e-4c0f-9e6b-222222222222",
	"status": "akun_aktif"
}
```

Error Response:
```json
{
	"error": "Email sudah terdaftar"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### PATCH /pengguna/{id_pengguna}

**Description**  
Memperbarui data pengguna.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_pengguna | uuid | yes | ID pengguna |

Body:
```json
{
	"nama_lengkap": "Siti A. Nur",
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"status": "terbarui"
}
```

Error Response:
```json
{
	"error": "Pengguna tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### DELETE /pengguna/{id_pengguna}

**Description**  
Menghapus akun pengguna.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_pengguna | uuid | yes | ID pengguna |

**Response**

Success Response:
```json
{
	"status": "terhapus"
}
```

Error Response:
```json
{
	"error": "Pengguna tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /pengguna/{id_pengguna}/reset-kata-sandi

**Description**  
Reset kata sandi pengguna ke default.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_pengguna | uuid | yes | ID pengguna |

Body:
```json
{
	"alasan": "Pengguna lupa kata sandi"
}
```

**Response**

Success Response:
```json
{
	"status": "reset_berhasil"
}
```

Error Response:
```json
{
	"error": "Pengguna tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /profil

**Description**  
Melihat profil pribadi pengguna.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_pengguna | uuid | yes | ID pengguna |

**Response**

Success Response:
```json
{
	"id_pengguna": "d0c4f4b3-2c31-4c8c-9a3a-111111111111",
	"nama_lengkap": "Budi Santoso",
	"email": "budi@example.com",
	"nomor_telepon": "08123456789",
	"foto_profil_url": "https://cdn.example.com/foto/budi.jpg"
}
```

Error Response:
```json
{
	"error": "Pengguna tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### PATCH /profil

**Description**  
Memperbarui profil pribadi (nomor telepon, email, foto profil).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"email": "budi.baru@example.com",
	"nomor_telepon": "08129876543",
	"foto_profil_url": "https://cdn.example.com/foto/budi-baru.jpg"
}
```

**Response**

Success Response:
```json
{
	"status": "terbarui"
}
```

Error Response:
```json
{
	"error": "Format email tidak valid"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 422 | Unprocessable Entity |

---

### GET /peran

**Description**  
Melihat daftar peran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_peran": 1,
			"nama_peran": "super_admin"
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### POST /peran/{id_peran}/izin

**Description**  
Mengelola izin pada peran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_peran | int | yes | ID peran |

Body:
```json
{
	"tambah": ["akses_absensi"],
	"hapus": ["akses_ujian"]
}
```

**Response**

Success Response:
```json
{
	"status": "izin_terbarui"
}
```

Error Response:
```json
{
	"error": "Peran tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /guru

**Description**  
Melihat daftar guru aktif.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| status_aktif | boolean | no | Filter status |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
			"nip": "19871234",
			"nama_guru": "Dewi Lestari",
			"status_aktif": true
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### POST /guru

**Description**  
Menambahkan data guru aktif.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_pengguna": "e2e06b63-2c2e-4c0f-9e6b-222222222222",
	"nip": "19871234",
	"nama_guru": "Dewi Lestari",
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333"
}
```

Error Response:
```json
{
	"error": "NIP sudah terdaftar"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### PATCH /guru/{id_guru}

**Description**  
Memperbarui status guru (aktif/non-aktif).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_guru | uuid | yes | ID guru |

Body:
```json
{
	"status_aktif": false
}
```

**Response**

Success Response:
```json
{
	"status": "terbarui"
}
```

Error Response:
```json
{
	"error": "Guru tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /siswa

**Description**  
Melihat daftar siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| tahun_masuk | int | no | Filter tahun angkatan |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444",
			"nisn": "1234567890",
			"nama_siswa": "Rian Putra",
			"tahun_masuk": 2024
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### POST /siswa

**Description**  
Menambahkan data siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_pengguna": "e2e06b63-2c2e-4c0f-9e6b-222222222222",
	"nisn": "1234567890",
	"nama_siswa": "Rian Putra",
	"tahun_masuk": 2024
}
```

**Response**

Success Response:
```json
{
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444"
}
```

Error Response:
```json
{
	"error": "NISN sudah terdaftar"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### GET /kurikulum

**Description**  
Melihat daftar kurikulum.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_kurikulum": 1,
			"nama_kurikulum": "Kurikulum Merdeka",
			"tahun_berlaku": 2024,
			"status_aktif": true
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### POST /kurikulum

**Description**  
Membuat data kurikulum baru.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"nama_kurikulum": "Kurikulum Merdeka",
	"tahun_berlaku": 2024,
	"deskripsi": "Kurikulum nasional",
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"id_kurikulum": 1
}
```

Error Response:
```json
{
	"error": "Data wajib diisi"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 422 | Unprocessable Entity |

---

### PATCH /kurikulum/{id_kurikulum}

**Description**  
Memperbarui data kurikulum.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_kurikulum | int | yes | ID kurikulum |

Body:
```json
{
	"tahun_berlaku": 2025,
	"deskripsi": "Pembaruan isi"
}
```

**Response**

Success Response:
```json
{
	"status": "terbarui"
}
```

Error Response:
```json
{
	"error": "Kurikulum tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /jadwal

**Description**  
Mengatur jadwal pelajaran per kelas.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_kelas": 10,
	"id_mapel": 3,
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
	"hari": "senin",
	"jam_mulai": "08:00",
	"jam_selesai": "09:30",
	"ruang": "R-101",
	"id_tahun_ajaran": 2
}
```

**Response**

Success Response:
```json
{
	"id_jadwal": 1001
}
```

Error Response:
```json
{
	"error": "Jadwal bentrok"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### POST /penugasan-guru

**Description**  
Menugaskan guru ke mapel dan kelas.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
	"id_mapel": 3,
	"id_kelas": 10,
	"id_tahun_ajaran": 2,
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"id_penugasan": 2001
}
```

Error Response:
```json
{
	"error": "Penugasan sudah ada"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### DELETE /penugasan-guru/{id_penugasan}

**Description**  
Menghapus penugasan guru.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_penugasan | int | yes | ID penugasan |

**Response**

Success Response:
```json
{
	"status": "terhapus"
}
```

Error Response:
```json
{
	"error": "Penugasan tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /keanggotaan-kelas

**Description**  
Menempatkan siswa ke kelas berdasarkan tahun ajaran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444",
	"id_kelas": 10,
	"id_tahun_ajaran": 2,
	"tanggal_masuk": "2025-07-10",
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"id_keanggotaan_kelas": 3001
}
```

Error Response:
```json
{
	"error": "Siswa sudah di kelas lain"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 409 | Conflict |

---

### PATCH /keanggotaan-kelas/{id_keanggotaan_kelas}

**Description**  
Memindahkan siswa ke kelas lain.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_keanggotaan_kelas | int | yes | ID keanggotaan |

Body:
```json
{
	"id_kelas": 11,
	"tanggal_pindah": "2026-01-10"
}
```

**Response**

Success Response:
```json
{
	"status": "terpindah"
}
```

Error Response:
```json
{
	"error": "Keanggotaan tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /jadwal-harian

**Description**  
Melihat jadwal pembelajaran harian siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_siswa | uuid | yes | ID siswa |
| tanggal | date | yes | Tanggal jadwal |

**Response**

Success Response:
```json
{
	"tanggal": "2026-01-15",
	"jadwal": [
		{
			"mapel": "Matematika",
			"jam_mulai": "08:00",
			"jam_selesai": "09:30",
			"guru": "Dewi Lestari"
		}
	]
}
```

Error Response:
```json
{
	"error": "Tidak ada jadwal"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /absensi

**Description**  
Mencatat absensi siswa per jadwal pelajaran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_absensi_kelas": 5001,
	"daftar": [
		{"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444", "status_kehadiran": "hadir"}
	]
}
```

**Response**

Success Response:
```json
{
	"status": "tersimpan"
}
```

Error Response:
```json
{
	"error": "Status kehadiran wajib diisi"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 422 | Unprocessable Entity |

---

### POST /materi

**Description**  
Unggah materi pembelajaran (dokumen/video).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | multipart/form-data | yes |

**Request Parameters**

Body (form-data):
```json
{
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
	"id_mapel": 3,
	"judul": "Materi Bab 1",
	"jenis": "dokumen",
	"file": "<binary>"
}
```

**Response**

Success Response:
```json
{
	"id_materi": 7001,
	"status": "tersimpan"
}
```

Error Response:
```json
{
	"error": "File terlalu besar"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 413 | Payload Too Large |

---

### GET /materi

**Description**  
Melihat daftar materi pembelajaran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_mapel | int | no | Filter mapel |

**Response**

Success Response:
```json
{
	"data": [
		{
			"id_materi": 7001,
			"judul": "Materi Bab 1",
			"jenis": "dokumen",
			"url_file": "https://cdn.example.com/materi/7001.pdf"
		}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### GET /materi/{id_materi}/unduh

**Description**  
Mengunduh materi pembelajaran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Accept | application/octet-stream | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_materi | int | yes | ID materi |

**Response**

Success Response:
```
<binary>
```

Error Response:
```json
{
	"error": "Materi tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /materi/{id_materi}/stream

**Description**  
Memutar materi video di browser.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Accept | video/* | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_materi | int | yes | ID materi |

**Response**

Success Response:
```
<binary>
```

Error Response:
```json
{
	"error": "Materi tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /tugas

**Description**  
Membuat tugas dengan instruksi dan lampiran.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
	"id_mapel": 3,
	"id_kelas": 10,
	"judul": "Tugas Aljabar",
	"instruksi": "Kerjakan soal 1-10",
	"lampiran_url": "https://cdn.example.com/tugas/1.pdf",
	"batas_waktu": "2026-02-01T23:59:00+07:00"
}
```

**Response**

Success Response:
```json
{
	"id_tugas": 8001
}
```

Error Response:
```json
{
	"error": "Data wajib diisi"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 422 | Unprocessable Entity |

---

### PATCH /tugas/{id_tugas}

**Description**  
Mengedit tugas, termasuk mengosongkan instruksi.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_tugas | int | yes | ID tugas |

Body:
```json
{
	"instruksi": ""
}
```

**Response**

Success Response:
```json
{
	"status": "terbarui"
}
```

Error Response:
```json
{
	"error": "Tugas tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /tugas/{id_tugas}

**Description**  
Melihat detail tugas dan deadline.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_tugas | int | yes | ID tugas |

**Response**

Success Response:
```json
{
	"id_tugas": 8001,
	"judul": "Tugas Aljabar",
	"batas_waktu": "2026-02-01T23:59:00+07:00",
	"sisa_waktu_menit": 120,
	"status": "Belum Dikerjakan"
}
```

Error Response:
```json
{
	"error": "Tugas tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /tugas/{id_tugas}/pengumpulan

**Description**  
Mengunggah hasil tugas siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | multipart/form-data | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_tugas | int | yes | ID tugas |

Body (form-data):
```json
{
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444",
	"file": "<binary>"
}
```

**Response**

Success Response:
```json
{
	"id_pengumpulan": 9001,
	"status": "Terkirim"
}
```

Error Response:
```json
{
	"error": "Koneksi gagal, coba lagi"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 503 | Service Unavailable |

---

### POST /nilai-tugas

**Description**  
Memberikan nilai terhadap tugas siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_tugas": 8001,
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444",
	"skor": 85,
	"catatan": "Bagus, perbaiki langkah 3"
}
```

**Response**

Success Response:
```json
{
	"id_nilai_tugas": 9101
}
```

Error Response:
```json
{
	"error": "Skor melebihi batas"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 422 | Unprocessable Entity |

---

### GET /nilai

**Description**  
Melihat nilai tugas dan ujian.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_siswa | uuid | yes | ID siswa |

**Response**

Success Response:
```json
{
	"tugas": [
		{"id_tugas": 8001, "skor": 85, "status": "Dinilai"}
	],
	"ujian": [
		{"id_ujian": 6001, "skor": 78, "status": "Menunggu Penilaian"}
	]
}
```

Error Response:
```json
{
	"error": "Data tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /ujian

**Description**  
Membuat dan menjadwalkan ujian/tes.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Body:
```json
{
	"id_guru": "c1c4f4b3-2c31-4c8c-9a3a-333333333333",
	"id_mapel": 3,
	"id_kelas": 10,
	"judul": "Ujian Tengah Semester",
	"waktu_mulai": "2026-03-10T08:00:00+07:00",
	"durasi_menit": 90,
	"status_aktif": true
}
```

**Response**

Success Response:
```json
{
	"id_ujian": 6001
}
```

Error Response:
```json
{
	"error": "Jadwal tidak valid"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 201 | Created |
| 422 | Unprocessable Entity |

---

### DELETE /ujian/{id_ujian}

**Description**  
Menghapus jadwal ujian.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_ujian | int | yes | ID ujian |

**Response**

Success Response:
```json
{
	"status": "terhapus"
}
```

Error Response:
```json
{
	"error": "Ujian tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### POST /ujian/{id_ujian}/mulai

**Description**  
Memulai ujian daring untuk siswa.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_ujian | int | yes | ID ujian |

Body:
```json
{
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444"
}
```

**Response**

Success Response:
```json
{
	"id_peserta": 6501,
	"status": "mulai",
	"waktu_mulai": "2026-03-10T08:00:00+07:00"
}
```

Error Response:
```json
{
	"error": "Ujian belum aktif"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 409 | Conflict |

---

### POST /ujian/{id_ujian}/jawaban

**Description**  
Menyimpan jawaban ujian siswa (otomatis saat waktu habis).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_ujian | int | yes | ID ujian |

Body:
```json
{
	"id_siswa": "f9c4f4b3-2c31-4c8c-9a3a-444444444444",
	"jawaban": [
		{"id_soal": 7101, "jawaban": "B"}
	]
}
```

**Response**

Success Response:
```json
{
	"status": "tersimpan"
}
```

Error Response:
```json
{
	"error": "Ujian tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /rapor

**Description**  
Melihat laporan hasil belajar (rapor).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_siswa | uuid | yes | ID siswa |
| semester | int | yes | Semester |
| id_tahun_ajaran | int | yes | Tahun ajaran |

**Response**

Success Response:
```json
{
	"id_rapor": 10001,
	"nilai_rata_rata": 83.5,
	"detail": [
		{"mapel": "Matematika", "nilai_mapel": 85, "predikat": "A"}
	]
}
```

Error Response:
```json
{
	"error": "Rapor tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /rapor/{id_rapor}/unduh

**Description**  
Mengunduh rapor dalam bentuk PDF.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Accept | application/pdf | yes |

**Request Parameters**

Path Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_rapor | int | yes | ID rapor |

**Response**

Success Response:
```
<binary>
```

Error Response:
```json
{
	"error": "Rapor tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /laporan/kehadiran

**Description**  
Laporan agregat kehadiran siswa (filter per kelas).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_kelas | int | yes | ID kelas |

**Response**

Success Response:
```json
{
	"id_kelas": 10,
	"persentase_kehadiran": 92.3
}
```

Error Response:
```json
{
	"error": "Data absen kosong"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /laporan/nilai

**Description**  
Laporan nilai siswa per kelas atau mapel (dapat diekspor).

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_kelas | int | no | ID kelas |
| id_mapel | int | no | ID mapel |
| format | string | no | json/excel |

**Response**

Success Response:
```json
{
	"rata_rata": 82.1,
	"data": [
		{"nama_siswa": "Rian Putra", "nilai": 85}
	]
}
```

Error Response:
```json
{
	"error": "Data tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /laporan/monitoring-kinerja

**Description**  
Dashboard monitoring kinerja sekolah.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Response**

Success Response:
```json
{
	"widget": [
		{"nama": "Jumlah Siswa", "nilai": 1200}
	]
}
```

Error Response:
```json
{
	"error": "Akses ditolak"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 403 | Forbidden |

---

### GET /laporan/statistik-nilai

**Description**  
Statistik nilai rata-rata siswa per kelas.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| id_kelas | int | no | ID kelas |

**Response**

Success Response:
```json
{
	"data": [
		{"kelas": "XI-A", "rata_rata": 81.2},
		{"kelas": "XI-B", "rata_rata": 83.4}
	]
}
```

Error Response:
```json
{
	"error": "Data nilai minim"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /laporan/ranking-nilai

**Description**  
Ranking nilai siswa berdasarkan angkatan.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| tahun_angkatan | int | yes | Tahun angkatan |

**Response**

Success Response:
```json
{
	"data": [
		{"nama_siswa": "Rian Putra", "nilai": 95, "peringkat": 1}
	]
}
```

Error Response:
```json
{
	"error": "Data tidak ditemukan"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 404 | Not Found |

---

### GET /laporan/filter-tanggal

**Description**  
Filter laporan berdasarkan rentang tanggal.

**Headers**
| Key | Value | Required |
|-----|------|----------|
| Content-Type | application/json | yes |

**Request Parameters**

Query Params (if any):
| Name | Type | Required | Description |
|------|------|----------|-------------|
| tanggal_mulai | date | yes | Tanggal mulai |
| tanggal_selesai | date | yes | Tanggal selesai |

**Response**

Success Response:
```json
{
	"status": "filter_berhasil"
}
```

Error Response:
```json
{
	"error": "Tanggal tidak valid"
}
```

**Status Codes**
| Code | Meaning |
|------|---------|
| 200 | OK |
| 422 | Unprocessable Entity |

---

## 7. Example Flow (Optional but Recommended)

1) POST /auth/login -> dapatkan sesi
2) GET /jadwal-harian?id_siswa=...&tanggal=...
3) GET /materi -> pilih materi
4) POST /tugas/{id_tugas}/pengumpulan -> unggah tugas
5) GET /nilai?id_siswa=... -> lihat nilai
