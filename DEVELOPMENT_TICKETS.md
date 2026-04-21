# Development Tickets - Sistem Informasi Akademik SMA

---

## 📋 Informasi Dokumen

**Versi:** 1.0  
**Tanggal:** 22 April 2026  
**Status:** Active  
**Project:** Sistem Informasi Akademik SMA  

---

## 🎯 Struktur Ticket

```
EPIC (Fitur Besar)
  └─ STORY (User Story)
      └─ SUBTASK (Task Teknis)
```

**Naming Convention:**
- EPIC: `EP-XXX` - Epic Number
- STORY: `ST-XXX` - Story Number
- SUBTASK: `SB-XXX` - Subtask Number

**Status:**
- ✅ DONE - Selesai
- 🚧 IN PROGRESS - Sedang Dikerjakan
- 📋 TODO - Belum Dikerjakan
- 🔄 IN REVIEW - Dalam Review
- ⏸️ BLOCKED - Terblokir

**Priority:**
- 🔴 CRITICAL - Harus selesai segera
- 🟠 HIGH - Prioritas tinggi
- 🟡 MEDIUM - Prioritas sedang
- 🟢 LOW - Prioritas rendah

---

# PHASE 1: FOUNDATION ✅

---

## EP-001: Authentication & Authorization System ✅

**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Sprint:** Sprint 1  
**Story Points:** 21  

### Deskripsi
Implementasi sistem autentikasi dan otorisasi berbasis role untuk mengamankan aplikasi dan mengatur akses pengguna berdasarkan peran mereka.

### Goals
- User dapat login dan logout dengan aman
- User memiliki role yang menentukan akses mereka
- Sistem dapat membedakan hak akses per role
- Email verification untuk keamanan

---

### ST-001: User Authentication ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai user, saya ingin login dengan email dan password agar dapat mengakses sistem sesuai role saya.

**Acceptance Criteria:**
- User dapat register dengan nama, email, dan password
- User dapat login dengan email dan password
- User dapat logout
- User dapat reset password melalui email
- User harus verify email sebelum full access
- Session timeout setelah 120 menit
- Password minimal 8 karakter

**Subtasks:**

#### SB-001-01: Setup Laravel Breeze ✅
- Install Laravel Breeze
- Configure auth routes
- Setup email configuration
- Test email sending locally

#### SB-001-02: Customize Auth Views ✅
- Update login page dengan TailAdmin design
- Update register page dengan TailAdmin design
- Update password reset page
- Update email verification page
- Add logo dan branding

#### SB-001-03: Email Verification ✅
- Enable email verification
- Configure email templates
- Test verification flow
- Add resend verification link

#### SB-001-04: Password Reset ✅
- Implement forgot password
- Configure reset email template
- Test reset flow
- Add validation

#### SB-001-05: Session Management ✅
- Configure session timeout (120 min)
- Add remember me functionality
- Test session expiration
- Add auto-logout on timeout

---

### ST-002: Role-Based Access Control (RBAC) ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Super Admin, saya ingin mengatur role dan permission untuk setiap user agar akses sistem dapat dikontrol dengan baik.

**Acceptance Criteria:**
- 5 Role: Super Admin, Admin, Akademik, Guru, Siswa
- 16 Permission yang dapat dikustomisasi
- User dapat memiliki multiple roles
- Role dapat memiliki multiple permissions
- Middleware untuk protect routes
- UI untuk assign role/permission

**Subtasks:**

#### SB-002-01: Create Database Schema ✅
- Create roles table migration
- Create permissions table migration
- Create role_user pivot table
- Create permission_role pivot table
- Run migrations

#### SB-002-02: Create Models ✅
- Create Role model dengan relationships
- Create Permission model dengan relationships
- Update User model dengan role relationships
- Add helper methods (hasRole, hasPermission)
- Test relationships

#### SB-002-03: Create Seeders ✅
- Create RoleSeeder (5 roles)
- Create PermissionSeeder (16 permissions)
- Assign permissions to roles
- Create super admin user
- Test seeding

#### SB-002-04: Create Middleware ✅
- Create RoleMiddleware
- Create PermissionMiddleware
- Register middleware in Kernel
- Test middleware functionality

#### SB-002-05: Role Assignment UI ✅
- Create user management page
- Add role assignment interface
- Add permission assignment interface
- Add validation
- Test UI functionality

---

## EP-002: User Management System ✅

**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Sprint:** Sprint 1-2  
**Story Points:** 13  

### Deskripsi
Sistem untuk mengelola semua user dalam aplikasi, termasuk CRUD operations, role assignment, dan user profile management.

---

### ST-003: User CRUD Operations ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Super Admin, saya ingin mengelola user (create, read, update, delete) agar dapat mengontrol siapa saja yang dapat mengakses sistem.

**Acceptance Criteria:**
- List semua users dengan pagination
- Create new user dengan role assignment
- Edit user information
- Delete user (tidak bisa delete diri sendiri)
- Search dan filter users
- Validation pada semua form

**Subtasks:**

#### SB-003-01: Create UserController ✅
- Generate controller
- Implement index method (list + pagination)
- Implement create method (form)
- Implement store method (save)
- Implement edit method (edit form)
- Implement update method (update)
- Implement destroy method (delete)

#### SB-003-02: Create Views ✅
- Create users/index.blade.php (list)
- Create users/create.blade.php (create form)
- Create users/edit.blade.php (edit form)
- Add search dan filter UI
- Add confirmation modal untuk delete

#### SB-003-03: Add Validation ✅
- Email validation (unique, format)
- Password validation (min 8 chars)
- Name validation (required)
- Role validation (exists)
- Update validation rules

#### SB-003-04: Add Routes ✅
- Define resource routes
- Add middleware protection
- Test all routes
- Document routes

---

### ST-004: User Profile Management ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai user, saya ingin mengedit profile saya sendiri agar informasi saya selalu up-to-date.

**Acceptance Criteria:**
- User dapat melihat profile sendiri
- User dapat edit nama dan email
- User dapat change password
- User dapat upload avatar (optional)
- Validation pada update profile

**Subtasks:**

#### SB-004-01: Profile View & Edit ✅
- Create profile view page
- Create profile edit form
- Add avatar upload (optional)
- Implement update logic
- Add validation

#### SB-004-02: Change Password ✅
- Create change password form
- Validate current password
- Validate new password (min 8, confirmation)
- Implement password change
- Add success notification

---

## EP-003: Data Akademik Master ✅

**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Sprint:** Sprint 2-3  
**Story Points:** 34  

### Deskripsi
Implementasi manajemen data master akademik yang menjadi fondasi sistem, termasuk tahun ajaran, jurusan, kelas, dan mata pelajaran.

---

### ST-005: Tahun Ajaran Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengelola tahun ajaran agar dapat mengatur periode akademik sekolah.

**Acceptance Criteria:**
- CRUD tahun ajaran
- Format: YYYY/YYYY (contoh: 2024/2025)
- Status aktif/non-aktif (toggle)
- Hanya 1 tahun ajaran aktif
- Validasi format tahun

**Subtasks:**

#### SB-005-01: Database & Model ✅
- Create migration tahun_ajaran table
- Create TahunAjaran model
- Define fillable fields
- Add validation rules
- Run migration

#### SB-005-02: Controller & Routes ✅
- Create TahunAjaranController
- Implement CRUD methods
- Add toggle active logic
- Define routes dengan middleware
- Test controller

#### SB-005-03: Views ✅
- Create index view (list)
- Create create view (form)
- Create edit view (form)
- Add toggle active button
- Add confirmation modals

#### SB-005-04: Validation & Testing ✅
- Validate tahun format
- Validate unique tahun
- Validate only one active
- Test all CRUD operations
- Test toggle active

---

### ST-006: Jurusan Management ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengelola jurusan agar siswa dapat diklasifikasikan berdasarkan program studi.

**Acceptance Criteria:**
- CRUD jurusan (IPA, IPS, Bahasa, dll)
- Nama dan deskripsi jurusan
- Validasi nama unique
- Relasi dengan kelas

**Subtasks:**

#### SB-006-01: Database & Model ✅
- Create migration jurusan table
- Create Jurusan model
- Define relationships (hasMany kelas)
- Add fillable fields
- Run migration

#### SB-006-02: Controller & Routes ✅
- Create JurusanController
- Implement CRUD methods
- Define resource routes
- Add middleware protection
- Test controller

#### SB-006-03: Views ✅
- Create index view
- Create create/edit forms
- Add validation errors display
- Add delete confirmation
- Style dengan TailAdmin

#### SB-006-04: Testing ✅
- Test CRUD operations
- Test unique name validation
- Test relationships
- Test soft delete (if applicable)

---

### ST-007: Kelas Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengelola kelas agar siswa dapat dikelompokkan berdasarkan tingkat dan jurusan.

**Acceptance Criteria:**
- CRUD kelas
- Nama kelas (X, XI IPA 1, XII IPS 2, dll)
- Relasi optional dengan jurusan
- List siswa per kelas
- Validasi nama unique

**Subtasks:**

#### SB-007-01: Database & Model ✅
- Create migration kelas table
- Create Kelas model
- Define relationships (belongsTo jurusan, hasMany siswa)
- Add fillable fields
- Run migration

#### SB-007-02: Controller & Routes ✅
- Create KelasController
- Implement CRUD methods
- Add method untuk list siswa
- Define routes
- Test controller

#### SB-007-03: Views ✅
- Create index view dengan jurusan info
- Create create/edit forms
- Add jurusan dropdown
- Show siswa count per kelas
- Add delete confirmation

#### SB-007-04: Advanced Features ✅
- Filter kelas by jurusan
- Search kelas by nama
- Pagination
- Export kelas list (future)

---

### ST-008: Mata Pelajaran Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengelola mata pelajaran beserta constraint penjadwalannya agar sistem dapat membuat jadwal yang optimal.

**Acceptance Criteria:**
- CRUD mata pelajaran
- Kode dan nama mata pelajaran
- SKS (Satuan Kredit Semester)
- Preferred block (1-3 slot berurutan)
- Max per day (maksimal slot per hari)
- Validasi kode unique

**Subtasks:**

#### SB-008-01: Database & Model ✅
- Create migration mata_pelajaran table
- Add scheduling fields (preferred_block, max_per_day)
- Create MataPelajaran model
- Define relationships
- Run migration

#### SB-008-02: Controller & Routes ✅
- Create MataPelajaranController
- Implement CRUD methods
- Add validation for scheduling constraints
- Define routes
- Test controller

#### SB-008-03: Views ✅
- Create index view
- Create create/edit forms dengan scheduling fields
- Add kode validation (unique, uppercase)
- Add SKS input
- Add preferred_block & max_per_day inputs

#### SB-008-04: Seeder ✅
- Create MataPelajaranSeeder
- Add common subjects (Matematika, Bahasa Indonesia, dll)
- Set realistic scheduling constraints
- Test seeding

---

### ST-009: Jadwal Pelajaran Legacy (Old System) ✅
**Priority:** 🟡 MEDIUM  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengelola jadwal pelajaran secara manual (sebelum ada auto-generate).

**Acceptance Criteria:**
- CRUD jadwal pelajaran
- Link: tahun ajaran, mata pelajaran, kelas, guru
- Input hari dan jam
- Validasi tidak ada bentrok
- View jadwal per kelas

**Subtasks:**

#### SB-009-01: Database & Model ✅
- Create migration jadwal_pelajaran table
- Create JadwalPelajaran model
- Define relationships (tahunAjaran, mataPelajaran, kelas, guru)
- Add fillable fields
- Run migration

#### SB-009-02: Controller & Routes ✅
- Create JadwalPelajaranController
- Implement CRUD methods
- Add conflict validation
- Define routes
- Test controller

#### SB-009-03: Views ✅
- Create index view (table/calendar)
- Create create/edit forms
- Add dropdowns (tahun ajaran, mapel, kelas, guru)
- Add time pickers
- Show conflict warnings

#### SB-009-04: Validation ✅
- Validate no teacher conflict
- Validate no kelas conflict
- Validate time range
- Validate required fields
- Test validation

---

## EP-004: Guru & Siswa Management ✅

**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Sprint:** Sprint 3-4  
**Story Points:** 21  

### Deskripsi
Sistem untuk mengelola data guru dan siswa sebagai user utama dalam sistem akademik.

---

### ST-010: Guru Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Super Admin, saya ingin mengelola data guru beserta mata pelajaran yang mereka ajar.

**Acceptance Criteria:**
- List semua guru
- Filter by mata pelajaran
- Assign mata pelajaran ke guru (many-to-many)
- View jadwal mengajar guru
- Integration dengan users table (role='guru')

**Subtasks:**

#### SB-010-01: Database Schema ✅
- Add mata_pelajaran field to users table (JSON/array)
- Or create guru_mata_pelajaran pivot table
- Add NIP field to users table
- Run migration
- Update User model

#### SB-010-02: Controller & Routes ✅
- Create GuruController
- Implement index (list guru)
- Implement assign mata pelajaran
- Add filter by mata pelajaran
- Test controller

#### SB-010-03: Views ✅
- Create guru index view
- Add mata pelajaran badges
- Add filter dropdown
- Add assign mata pelajaran modal
- Style dengan TailAdmin

#### SB-010-04: Integration ✅
- Link dengan users table
- Auto-create user saat create guru
- Assign role 'guru' automatically
- Test integration

---

### ST-011: Siswa Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 13  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Super Admin, saya ingin mengelola data siswa dengan informasi lengkap dan assign mereka ke kelas.

**Acceptance Criteria:**
- CRUD siswa dengan data lengkap
- NIS, nama lengkap, kelas, tahun masuk
- Data personal (tempat/tanggal lahir, jenis kelamin, alamat)
- Upload foto siswa (optional)
- Relasi dengan kelas
- Search dan filter
- Integration dengan users table (role='siswa')

**Subtasks:**

#### SB-011-01: Database Schema ✅
- Add student fields to users table
- Fields: NIS, kelas_id, tahun_masuk, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_telp, email_ortu
- Run migration
- Update User model

#### SB-011-02: Controller & Routes ✅
- Create SiswaController
- Implement CRUD methods
- Add search functionality
- Add filter by kelas
- Test controller

#### SB-011-03: Views ✅
- Create index view dengan search/filter
- Create create/edit forms (lengkap)
- Add kelas dropdown
- Add foto upload (optional)
- Add validation errors display

#### SB-011-04: Validation ✅
- Validate NIS unique
- Validate required fields
- Validate email format
- Validate tanggal lahir
- Test validation

#### SB-011-05: Integration ✅
- Auto-create user account saat create siswa
- Assign role 'siswa' automatically
- Send welcome email (optional)
- Test integration

---

## EP-005: Dashboard System ✅

**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Sprint:** Sprint 4  
**Story Points:** 21  

### Deskripsi
Implementasi dashboard spesifik untuk setiap role dengan statistik dan quick actions yang relevan.

---

### ST-012: Super Admin Dashboard ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Super Admin, saya ingin melihat overview lengkap sistem dengan statistik dan quick actions.

**Acceptance Criteria:**
- Total users, guru, siswa, kelas
- Recent activities (last 10)
- System statistics (charts)
- Quick actions (create user, assign role, dll)
- Beautiful layout dengan TailAdmin

**Subtasks:**

#### SB-012-01: Controller & Data ✅
- Create SuperAdminDashboardController
- Query statistics (count users, guru, siswa, kelas)
- Get recent activities
- Calculate charts data
- Test controller

#### SB-012-02: View & UI ✅
- Create super-admin dashboard view
- Add statistics cards
- Add charts (ApexCharts)
- Add recent activities table
- Add quick action buttons

---

### ST-013: Admin Dashboard ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 3  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Admin, saya ingin melihat statistik user management dan recent registrations.

**Subtasks:**

#### SB-013-01: Controller & View ✅
- Create AdminDashboardController
- Show user statistics
- Show recent registrations
- Add quick links to user management

---

### ST-014: Akademik Dashboard ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin melihat overview data akademik dan jadwal.

**Subtasks:**

#### SB-014-01: Controller & View ✅
- Create AkademikDashboardController
- Show academic statistics (tahun ajaran, kelas, mapel)
- Show schedule overview
- Add quick access to academic features

---

### ST-015: Guru Dashboard ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Guru, saya ingin melihat jadwal mengajar hari ini dan kelas saya.

**Subtasks:**

#### SB-015-01: Controller & View ✅
- Create GuruDashboardController
- Show today's schedule
- Show my classes
- Show total students
- Quick links (input nilai, lihat jadwal)

---

### ST-016: Siswa Dashboard ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 3  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Siswa, saya ingin melihat jadwal kelas saya dan nilai saya.

**Subtasks:**

#### SB-016-01: Controller & View ✅
- Create SiswaDashboardController
- Show my classes
- Show today's schedule
- Show my grades overview
- Show attendance percentage

---

## EP-006: Advanced Scheduling System ✅

**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Sprint:** Sprint 5-6  
**Story Points:** 34  

### Deskripsi
Sistem penjadwalan otomatis dengan algoritma constraint-based yang dapat menghasilkan jadwal optimal dengan mempertimbangkan berbagai constraint.

---

### ST-017: Time Slots Management ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 5  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mendefinisikan slot waktu dalam sehari agar jadwal terstruktur dengan baik.

**Acceptance Criteria:**
- Define slots per hari (Senin-Jumat)
- Tipe slot: teaching, break, ceremony
- Urutan slot (slot_index)
- Waktu mulai dan selesai
- Seeder untuk default data

**Subtasks:**

#### SB-017-01: Database & Model ✅
- Create migration time_slots table
- Fields: day, slot_index, type, start_time, end_time
- Create TimeSlot model
- Define helper methods (isTeachingSlot)
- Run migration

#### SB-017-02: Seeder ✅
- Create TimeSlotSeeder
- Add Senin (Upacara 07:00-07:45, teaching slots, break)
- Add Selasa-Kamis (teaching slots, break)
- Add Jumat (teaching slots, break, shorter)
- Test seeding

#### SB-017-03: Controller & Routes (Optional) ✅
- Create TimeSlotController (for admin manage slots)
- CRUD methods
- Define routes
- Test controller

---

### ST-018: Guru-Mapel-Kelas Assignment ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengassign guru ke mata pelajaran dan kelas sebelum generate jadwal.

**Acceptance Criteria:**
- CRUD guru-mapel-kelas assignment
- Validasi unique combination
- Auto-generate assignment berdasarkan kapasitas
- Bulk delete (clear all)
- View per guru, per kelas, per mapel

**Subtasks:**

#### SB-018-01: Database & Model ✅
- Create migration guru_mapel_kelas table
- Fields: guru_id, mata_pelajaran_id, kelas_id
- Unique constraint
- Create GuruMapelKelas model
- Define relationships
- Run migration

#### SB-018-02: Controller & Routes ✅
- Create GuruMapelKelasController
- Implement CRUD methods
- Add auto-generate method
- Add clear method
- Test controller

#### SB-018-03: Views ✅
- Create index view (table grouped)
- Create create/edit forms
- Add dropdowns (guru, mapel, kelas)
- Add generate button
- Add clear all button
- Add confirmation modals

#### SB-018-04: Auto-Generate Logic ✅
- Implement algorithm untuk assign
- Consider guru mata_pelajaran
- Distribute evenly across kelas
- Validate before save
- Test generation

---

### ST-019: Schedule Generation Algorithm ✅
**Priority:** 🔴 CRITICAL  
**Status:** ✅ DONE  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin generate jadwal otomatis agar tidak perlu mengatur manual dan menghindari konflik.

**Acceptance Criteria:**
- Auto-generate schedule untuk semua kelas
- Algorithm mempertimbangkan:
  - Time slot availability
  - Teacher conflict (no double booking)
  - Subject constraints (preferred_block, max_per_day)
  - Break/ceremony slots
- Validation sebelum save
- Progress feedback saat generate

**Subtasks:**

#### SB-019-01: Database & Model ✅
- Create migration schedules table
- Fields: kelas_id, time_slot_id, mata_pelajaran_id, guru_id
- Create Schedule model
- Define relationships
- Run migration

#### SB-019-02: Service Class ✅
- Create ScheduleGeneratorService
- Implement backtracking algorithm
- Implement constraint checking
- Implement validation
- Unit test service

#### SB-019-03: Controller Integration ✅
- Create ScheduleController
- Implement generate method
- Call service
- Handle errors
- Return response

#### SB-019-04: Algorithm Optimization ✅
- Optimize constraint checking
- Add randomization untuk variasi
- Handle edge cases
- Performance testing
- Fix bugs

---

### ST-020: Manual Schedule Management ✅
**Priority:** 🟠 HIGH  
**Status:** ✅ DONE  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin mengedit jadwal secara manual untuk optimasi atau penyesuaian.

**Acceptance Criteria:**
- View jadwal per kelas (weekly grid)
- Add schedule manually
- Edit schedule
- Delete schedule
- Swap two schedules
- Move schedule to different slot
- Validation untuk prevent conflicts

**Subtasks:**

#### SB-020-01: Schedule Views ✅
- Create index view (list all schedules)
- Create weekly grid view per kelas
- Add color coding per mata pelajaran
- Add teacher info
- Style dengan TailAdmin

#### SB-020-02: CRUD Operations ✅
- Implement create schedule
- Implement edit schedule
- Implement delete schedule
- Add validation
- Test operations

#### SB-020-03: Advanced Features ✅
- Implement swap schedules
- Implement move to slot
- Add drag & drop (optional)
- Validate conflicts
- Test features

#### SB-020-04: UI Enhancements ✅
- Add filters (kelas, hari, guru)
- Add search
- Add export to PDF (future)
- Add print view
- Responsive design

---

# PHASE 2: CORE FEATURES 📋

---

## EP-007: Nilai/Grades Management 📋

**Priority:** 🔴 CRITICAL  
**Status:** 📋 TODO  
**Sprint:** Sprint 7-8  
**Story Points:** 34  

### Deskripsi
Sistem untuk mengelola nilai siswa untuk berbagai jenis penilaian (tugas, UTS, UAS, praktek) dan menghasilkan rapor.

---

### ST-021: Nilai CRUD 📋
**Priority:** 🔴 CRITICAL  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Guru, saya ingin input dan mengelola nilai siswa untuk mata pelajaran yang saya ajar.

**Acceptance Criteria:**
- CRUD nilai siswa
- Jenis nilai: Tugas, UTS, UAS, Praktek
- Semester: Ganjil, Genap
- Nilai 0-100
- Relasi: siswa, mata_pelajaran, tahun_ajaran, guru
- Validasi no duplicate
- Filter by kelas, mapel, semester

**Subtasks:**

#### SB-021-01: Database & Model 📋
- Create migration nilai table
- Fields: siswa_id, mata_pelajaran_id, tahun_ajaran_id, guru_id, semester, jenis, nilai, catatan
- Create Nilai model
- Define relationships
- Run migration

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-021-02: Controller & Routes 📋
- Create NilaiController
- Implement CRUD methods
- Add duplicate checking
- Add filter methods
- Define routes dengan middleware

**Estimasi:** 4 hours  
**Dependencies:** SB-021-01

#### SB-021-03: Views 📋
- Create index view dengan filter
- Create create/edit forms
- Add dropdowns (siswa, mapel, semester, jenis)
- Add number input untuk nilai (0-100)
- Add catatan textarea

**Estimasi:** 6 hours  
**Dependencies:** SB-021-02

#### SB-021-04: Validation & Testing 📋
- Validate nilai range (0-100)
- Validate no duplicate (siswa, mapel, tahun, semester, jenis)
- Validate required fields
- Test CRUD operations
- Test filters

**Estimasi:** 3 hours  
**Dependencies:** SB-021-03

---

### ST-022: Input Nilai by Guru 📋
**Priority:** 🔴 CRITICAL  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Guru, saya ingin input nilai untuk kelas yang saya ajar dengan mudah dan cepat.

**Acceptance Criteria:**
- Guru hanya bisa input nilai untuk kelas/mapel yang diajar
- Batch input nilai (multiple siswa sekaligus)
- Template import Excel (optional)
- Auto-fill guru_id dari user login
- Validasi hak akses

**Subtasks:**

#### SB-022-01: Guru Input Interface 📋
- Create special input page untuk guru
- Filter only my classes
- Show siswa list per kelas
- Batch input form (table)
- Quick save

**Estimasi:** 4 hours  
**Dependencies:** ST-021

#### SB-022-02: Batch Operations 📋
- Implement batch save nilai
- Validate all before save
- Show success/error per row
- Add progress indicator

**Estimasi:** 3 hours  
**Dependencies:** SB-022-01

#### SB-022-03: Excel Import (Optional) 📋
- Create Excel template
- Implement import logic
- Validate Excel data
- Preview before save
- Handle errors

**Estimasi:** 4 hours  
**Dependencies:** SB-022-02

---

### ST-023: Rapor Calculation & Generation 📋
**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin generate rapor siswa otomatis berdasarkan nilai yang sudah diinput.

**Acceptance Criteria:**
- Calculate nilai akhir dengan formula:
  - 30% Rata-rata Tugas
  - 30% UTS
  - 40% UAS
  - (Praktek jika ada)
- Konversi ke huruf (A-E)
- Predikat (Sangat Baik, Baik, Cukup, Kurang)
- Generate rapor per siswa per semester
- Export to PDF

**Subtasks:**

#### SB-023-01: Calculation Service 📋
- Create RaporCalculationService
- Implement formula calculation
- Implement grade conversion (A-E)
- Implement predikat logic
- Unit test service

**Estimasi:** 4 hours  
**Dependencies:** ST-021

#### SB-023-02: Rapor Controller & Routes 📋
- Create RaporController
- Implement calculate method
- Implement view rapor
- Add filters (siswa, semester, tahun ajaran)
- Define routes

**Estimasi:** 3 hours  
**Dependencies:** SB-023-01

#### SB-023-03: Rapor View 📋
- Create rapor view (table format)
- Show all mata pelajaran
- Show nilai per jenis
- Show nilai akhir, grade, predikat
- Print-friendly layout

**Estimasi:** 4 hours  
**Dependencies:** SB-023-02

#### SB-023-04: PDF Export 📋
- Install PDF library (DomPDF/mPDF)
- Create PDF template
- Implement export logic
- Add school logo/header
- Test PDF generation

**Estimasi:** 4 hours  
**Dependencies:** SB-023-03

---

## EP-008: Absensi/Attendance System 📋

**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Sprint:** Sprint 9-10  
**Story Points:** 34  

### Deskripsi
Sistem untuk mencatat dan mengelola kehadiran siswa per mata pelajaran dan menghasilkan laporan absensi.

---

### ST-024: Absensi CRUD 📋
**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Guru, saya ingin mencatat kehadiran siswa setiap sesi pembelajaran.

**Acceptance Criteria:**
- CRUD absensi
- Status: Hadir (H), Sakit (S), Izin (I), Alpha (A)
- Relasi: siswa, jadwal/mata_pelajaran, tanggal
- Batch input per kelas
- View absensi per siswa, per kelas, per tanggal

**Subtasks:**

#### SB-024-01: Database & Model 📋
- Create migration absensi table
- Fields: siswa_id, jadwal_id/mata_pelajaran_id, tanggal, status, keterangan
- Create Absensi model
- Define relationships
- Run migration

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-024-02: Controller & Routes 📋
- Create AbsensiController
- Implement CRUD methods
- Add filter methods
- Define routes dengan middleware
- Test controller

**Estimasi:** 4 hours  
**Dependencies:** SB-024-01

#### SB-024-03: Batch Input Interface 📋
- Create batch input page
- Show siswa list per kelas
- Radio buttons untuk status (H, S, I, A)
- Quick save all
- Add keterangan field

**Estimasi:** 6 hours  
**Dependencies:** SB-024-02

#### SB-024-04: Validation & Testing 📋
- Validate status enum
- Validate no duplicate (siswa, tanggal, jadwal)
- Test batch save
- Test filters

**Estimasi:** 3 hours  
**Dependencies:** SB-024-03

---

### ST-025: Rekap Absensi 📋
**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin melihat rekap absensi siswa per bulan dan per semester.

**Acceptance Criteria:**
- Rekap per siswa (total H, S, I, A)
- Rekap per kelas
- Rekap per periode (harian, mingguan, bulanan)
- Persentase kehadiran
- Export to Excel

**Subtasks:**

#### SB-025-01: Rekap Calculation 📋
- Create AbsensiRekapService
- Calculate totals (H, S, I, A)
- Calculate percentage
- Group by periode
- Unit test

**Estimasi:** 3 hours  
**Dependencies:** ST-024

#### SB-025-02: Rekap Views 📋
- Create rekap per siswa view
- Create rekap per kelas view
- Add date range filter
- Add charts (attendance trends)
- Print view

**Estimasi:** 4 hours  
**Dependencies:** SB-025-01

#### SB-025-03: Excel Export 📋
- Install Excel library (Laravel Excel)
- Create export template
- Implement export logic
- Test export

**Estimasi:** 2 hours  
**Dependencies:** SB-025-02

---

### ST-026: Absensi for Siswa Dashboard 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 5  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai Siswa, saya ingin melihat rekap kehadiran saya sendiri.

**Acceptance Criteria:**
- Siswa hanya bisa lihat absensi sendiri
- Show total H, S, I, A
- Show percentage kehadiran
- Show recent absences
- Monthly calendar view

**Subtasks:**

#### SB-026-01: Siswa Absensi View 📋
- Create view di siswa dashboard
- Query absensi siswa login
- Display statistics
- Display calendar/timeline
- Style dengan TailAdmin

**Estimasi:** 3 hours  
**Dependencies:** ST-024

#### SB-026-02: Calendar Integration 📋
- Integrate FullCalendar
- Mark dates dengan status
- Color code (H=green, S=yellow, I=blue, A=red)
- Add tooltips

**Estimasi:** 2 hours  
**Dependencies:** SB-026-01

---

### ST-027: Notifikasi Absensi 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Orang Tua, saya ingin menerima notifikasi jika anak saya tidak hadir.

**Acceptance Criteria:**
- Email notification ke orang tua jika siswa Alpha
- Email notification rekap bulanan
- WhatsApp notification (optional, via API)
- Setting untuk enable/disable notifikasi

**Subtasks:**

#### SB-027-01: Email Notification 📋
- Create notification template
- Implement send email logic
- Trigger saat input absensi Alpha
- Add email queue
- Test email

**Estimasi:** 3 hours  
**Dependencies:** ST-024

#### SB-027-02: Monthly Report Email 📋
- Create monthly report template
- Schedule cron job (end of month)
- Send to all parents
- Include statistics
- Test scheduling

**Estimasi:** 3 hours  
**Dependencies:** SB-027-01

#### SB-027-03: WhatsApp Integration (Optional) 📋
- Research WhatsApp API (Twilio/Fonnte)
- Implement send message
- Test integration
- Add to settings

**Estimasi:** 4 hours  
**Dependencies:** SB-027-02

---

## EP-009: Pengumuman & Communication 📋

**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Sprint:** Sprint 11  
**Story Points:** 21  

### Deskripsi
Sistem pengumuman dan komunikasi internal untuk menyebarkan informasi kepada guru, siswa, dan orang tua.

---

### ST-028: Pengumuman Management 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Admin/Staff Akademik, saya ingin membuat dan mengelola pengumuman untuk seluruh warga sekolah.

**Acceptance Criteria:**
- CRUD pengumuman
- Judul, konten, tanggal publish
- Target audience (All, Guru, Siswa, Kelas tertentu)
- Status: Draft, Published
- Upload attachment (optional)
- Rich text editor

**Subtasks:**

#### SB-028-01: Database & Model 📋
- Create migration pengumuman table
- Fields: judul, konten, target_audience, status, publish_date, attachment
- Create Pengumuman model
- Define relationships (if any)
- Run migration

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-028-02: Controller & Routes 📋
- Create PengumumanController
- Implement CRUD methods
- Add publish/unpublish toggle
- Define routes dengan middleware
- Test controller

**Estimasi:** 3 hours  
**Dependencies:** SB-028-01

#### SB-028-03: Views 📋
- Create index view (list)
- Create create/edit form dengan rich text editor (TinyMCE/Quill)
- Add target audience selector
- Add file upload
- Add publish toggle

**Estimasi:** 5 hours  
**Dependencies:** SB-028-02

---

### ST-029: Pengumuman Display 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 5  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai User, saya ingin melihat pengumuman yang relevan untuk saya di dashboard.

**Acceptance Criteria:**
- Show pengumuman di dashboard sesuai target audience
- Show latest 5 pengumuman
- Click untuk detail
- Mark as read (optional)
- Responsive layout

**Subtasks:**

#### SB-029-01: Dashboard Widget 📋
- Create pengumuman widget component
- Query pengumuman by target audience
- Show di semua dashboard
- Add "Lihat Semua" link

**Estimasi:** 2 hours  
**Dependencies:** ST-028

#### SB-029-02: Detail Page 📋
- Create pengumuman detail view
- Show full content
- Show attachment download link
- Add back button
- Style dengan TailAdmin

**Estimasi:** 2 hours  
**Dependencies:** SB-029-01

---

### ST-030: Notification System 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai User, saya ingin mendapat notifikasi saat ada pengumuman baru yang relevan.

**Acceptance Criteria:**
- Email notification untuk pengumuman penting
- In-app notification badge
- Notification list
- Mark as read
- Push notification (future, via PWA)

**Subtasks:**

#### SB-030-01: Database Schema 📋
- Create notifications table
- Fields: user_id, pengumuman_id, is_read, created_at
- Create Notification model
- Define relationships

**Estimasi:** 2 hours  
**Dependencies:** ST-028

#### SB-030-02: Notification Logic 📋
- Create NotificationService
- Trigger saat publish pengumuman
- Send to target audience
- Queue for performance

**Estimasi:** 3 hours  
**Dependencies:** SB-030-01

#### SB-030-03: UI Integration 📋
- Add notification bell icon di navbar
- Show unread count badge
- Dropdown list notifications
- Mark as read on click
- Link to pengumuman detail

**Estimasi:** 3 hours  
**Dependencies:** SB-030-02

---

# PHASE 3: ADVANCED FEATURES 🚀

---

## EP-010: Reporting & Analytics 📋

**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Sprint:** Sprint 12-13  
**Story Points:** 34  

### Deskripsi
Sistem pelaporan dan analitik komprehensif untuk monitoring kinerja akademik sekolah.

---

### ST-031: Academic Reports 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik/Kepala Sekolah, saya ingin melihat laporan akademik yang komprehensif.

**Acceptance Criteria:**
- Laporan nilai per kelas (average, highest, lowest)
- Laporan absensi per kelas
- Laporan kinerja guru (completion rate)
- Comparison antar semester
- Export to PDF/Excel

**Subtasks:**

#### SB-031-01: Report Service 📋
- Create AcademicReportService
- Implement nilai aggregation
- Implement absensi aggregation
- Implement comparison logic
- Unit test

**Estimasi:** 5 hours  
**Dependencies:** ST-021, ST-024

#### SB-031-02: Report Views 📋
- Create report dashboard
- Create nilai report view
- Create absensi report view
- Add charts (ApexCharts)
- Add filters (periode, kelas)

**Estimasi:** 6 hours  
**Dependencies:** SB-031-01

#### SB-031-03: Export Functionality 📋
- PDF export untuk semua reports
- Excel export untuk raw data
- Add export buttons
- Test exports

**Estimasi:** 3 hours  
**Dependencies:** SB-031-02

---

### ST-032: Student Performance Analytics 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Guru/Wali Kelas, saya ingin analisis performa siswa untuk identifikasi yang perlu perhatian khusus.

**Acceptance Criteria:**
- Grafik trend nilai per siswa
- Identifikasi siswa berprestasi
- Identifikasi siswa perlu perhatian
- Attendance vs performance correlation
- Recommendation system

**Subtasks:**

#### SB-032-01: Analytics Service 📋
- Create StudentAnalyticsService
- Calculate trends
- Identify top performers
- Identify underperformers
- Calculate correlations

**Estimasi:** 5 hours  
**Dependencies:** ST-021, ST-024

#### SB-032-02: Analytics Dashboard 📋
- Create analytics view
- Add trend charts
- Add student lists (top/bottom)
- Add correlation charts
- Filters

**Estimasi:** 6 hours  
**Dependencies:** SB-032-01

#### SB-032-03: Recommendations 📋
- Implement recommendation algorithm
- Show actionable insights
- Generate intervention suggestions
- Test recommendations

**Estimasi:** 3 hours  
**Dependencies:** SB-032-02

---

### ST-033: Custom Reports 📋
**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Full Stack Developer  

**User Story:**  
Sebagai Super Admin, saya ingin membuat custom report dengan filter yang fleksibel.

**Acceptance Criteria:**
- Report builder interface
- Flexible filters (date range, kelas, mapel, dll)
- Select columns to display
- Save report templates
- Schedule auto-send email (optional)

**Subtasks:**

#### SB-033-01: Report Builder UI 📋
- Create report builder interface
- Add filter options
- Add column selector
- Preview results
- Save template

**Estimasi:** 4 hours  
**Dependencies:** ST-031

#### SB-033-02: Report Generator 📋
- Implement dynamic query builder
- Generate results based on filters
- Export functionality
- Test with various combinations

**Estimasi:** 4 hours  
**Dependencies:** SB-033-01

---

## EP-011: Mobile Optimization & PWA 📋

**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Sprint:** Sprint 14  
**Story Points:** 21  

### Deskripsi
Optimasi untuk mobile devices dan implementasi Progressive Web App (PWA) untuk pengalaman mirip native app.

---

### ST-034: Mobile Responsive Optimization 📋
**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai User, saya ingin akses sistem dari smartphone dengan lancar.

**Acceptance Criteria:**
- All pages responsive (mobile, tablet, desktop)
- Touch-friendly UI (button size, spacing)
- Mobile navigation (hamburger menu)
- Optimized images
- Fast load time on mobile

**Subtasks:**

#### SB-034-01: Audit Current Pages 📋
- Test all pages on mobile
- Identify responsive issues
- List fixes needed
- Prioritize fixes

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-034-02: Fix Responsive Issues 📋
- Fix table overflow issues
- Fix form layouts
- Fix navigation on mobile
- Adjust font sizes
- Test on various devices

**Estimasi:** 5 hours  
**Dependencies:** SB-034-01

#### SB-034-03: Performance Optimization 📋
- Optimize images (lazy load, compress)
- Minimize CSS/JS
- Test load times
- Fix performance issues

**Estimasi:** 2 hours  
**Dependencies:** SB-034-02

---

### ST-035: PWA Implementation 📋
**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Frontend Developer  

**User Story:**  
Sebagai User, saya ingin install aplikasi di home screen smartphone dan bisa akses offline.

**Acceptance Criteria:**
- PWA manifest.json
- Service worker untuk caching
- Install prompt
- Offline fallback page
- Push notification support (future)

**Subtasks:**

#### SB-035-01: PWA Setup 📋
- Create manifest.json
- Add app icons (various sizes)
- Configure theme colors
- Add to HTML head
- Test installability

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-035-02: Service Worker 📋
- Create service worker file
- Implement caching strategy
- Cache static assets
- Cache API responses (selectively)
- Test offline functionality

**Estimasi:** 5 hours  
**Dependencies:** SB-035-01

#### SB-035-03: Install Prompt 📋
- Implement install prompt UI
- Handle beforeinstallprompt event
- Show prompt at appropriate time
- Handle install success/fail
- Test on Android & iOS

**Estimasi:** 3 hours  
**Dependencies:** SB-035-02

#### SB-035-04: Push Notifications (Optional) 📋
- Setup push notification service
- Request notification permission
- Handle notification click
- Test notifications

**Estimasi:** 4 hours  
**Dependencies:** SB-035-03

---

## EP-012: Integration & API 📋

**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Sprint:** Sprint 15  
**Story Points:** 21  

### Deskripsi
Pengembangan REST API untuk integrasi dengan sistem eksternal dan mobile app native (future).

---

### ST-036: REST API Development 📋
**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Developer, saya ingin API yang terdokumentasi untuk integrasi dengan sistem lain.

**Acceptance Criteria:**
- RESTful API endpoints
- Token-based authentication (Sanctum)
- API versioning (v1)
- Rate limiting
- Error handling
- API documentation (Swagger/Postman)

**Subtasks:**

#### SB-036-01: API Setup 📋
- Install Laravel Sanctum
- Configure API routes
- Setup API authentication
- Setup rate limiting
- Test authentication

**Estimasi:** 3 hours  
**Dependencies:** None

#### SB-036-02: API Endpoints 📋
- Create API controllers
- Implement endpoints:
  - Auth (login, logout, profile)
  - Jadwal (list, detail)
  - Nilai (list, create, update)
  - Absensi (list, create, update)
- Add validation
- Test endpoints

**Estimasi:** 6 hours  
**Dependencies:** SB-036-01

#### SB-036-03: API Documentation 📋
- Install Swagger/L5-Swagger
- Document all endpoints
- Add request/response examples
- Generate documentation
- Publish documentation

**Estimasi:** 4 hours  
**Dependencies:** SB-036-02

---

### ST-037: DAPODIK Integration (Optional) 📋
**Priority:** 🟢 LOW  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai Staff Akademik, saya ingin sinkronisasi data dengan DAPODIK agar tidak perlu double entry.

**Acceptance Criteria:**
- Import siswa dari DAPODIK
- Import guru dari DAPODIK
- Sync data siswa/guru
- Mapping fields
- Error handling

**Subtasks:**

#### SB-037-01: Research DAPODIK API 📋
- Study DAPODIK documentation
- Understand data structure
- Plan mapping strategy
- Get API credentials

**Estimasi:** 2 hours  
**Dependencies:** None

#### SB-037-02: Import Implementation 📋
- Create import service
- Implement data mapping
- Handle data validation
- Implement error handling
- Test import

**Estimasi:** 5 hours  
**Dependencies:** SB-037-01

#### SB-037-03: Sync Functionality 📋
- Implement incremental sync
- Schedule sync (cron)
- Handle conflicts
- Log sync results
- Test sync

**Estimasi:** 3 hours  
**Dependencies:** SB-037-02

---

# MAINTENANCE & IMPROVEMENT 🔧

---

## EP-013: Testing & Quality Assurance 🚧

**Priority:** 🟠 HIGH  
**Status:** 🚧 IN PROGRESS  
**Ongoing**  
**Story Points:** ∞  

### Deskripsi
Continuous testing dan quality assurance untuk memastikan aplikasi berjalan dengan baik.

---

### ST-038: Automated Testing 🚧
**Priority:** 🟠 HIGH  
**Status:** 🚧 IN PROGRESS  
**Story Points:** 13  
**Assignee:** QA Engineer / Developer  

**User Story:**  
Sebagai Developer, saya ingin automated tests untuk detect regressions early.

**Acceptance Criteria:**
- Unit tests untuk services
- Feature tests untuk controllers
- Test coverage > 70%
- CI/CD integration
- Run tests before deploy

**Subtasks:**

#### SB-038-01: Unit Tests 📋
- Write unit tests untuk all services
- Test calculation logic
- Test validation logic
- Test helper methods
- Achieve 80%+ coverage

**Estimasi:** Ongoing  
**Dependencies:** All services

#### SB-038-02: Feature Tests 📋
- Write feature tests untuk all controllers
- Test CRUD operations
- Test authentication/authorization
- Test API endpoints
- Achieve 70%+ coverage

**Estimasi:** Ongoing  
**Dependencies:** All controllers

#### SB-038-03: CI/CD Setup 📋
- Setup GitHub Actions
- Configure test workflow
- Run tests on push/PR
- Add coverage reporting
- Block merge if tests fail

**Estimasi:** 4 hours  
**Dependencies:** SB-038-01, SB-038-02

---

### ST-039: Manual Testing & Bug Fixes 🚧
**Priority:** 🟠 HIGH  
**Status:** 🚧 IN PROGRESS  
**Story Points:** ∞  
**Assignee:** QA Team  

**User Story:**  
Sebagai QA, saya ingin test semua fitur secara manual dan report bugs.

**Acceptance Criteria:**
- Test all user flows
- Test edge cases
- Cross-browser testing
- Mobile device testing
- Document bugs
- Fix critical bugs

**Subtasks:**

#### SB-039-01: Create Test Cases 📋
- Write test cases untuk all features
- Include happy path & edge cases
- Assign to testers
- Track completion

**Estimasi:** Ongoing  
**Dependencies:** All features

#### SB-039-02: Execute Tests 📋
- Execute all test cases
- Document results
- Report bugs with steps to reproduce
- Retest after fixes

**Estimasi:** Ongoing  
**Dependencies:** SB-039-01

#### SB-039-03: Bug Fixes 🚧
- Prioritize bugs (Critical, High, Medium, Low)
- Fix critical bugs immediately
- Fix high priority bugs in current sprint
- Schedule medium/low bugs
- Verify fixes

**Estimasi:** Ongoing  
**Dependencies:** SB-039-02

---

## EP-014: Documentation & Training 📋

**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Ongoing**  
**Story Points:** 21  

### Deskripsi
Pembuatan dokumentasi lengkap dan training materials untuk users dan developers.

---

### ST-040: User Documentation 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Technical Writer  

**User Story:**  
Sebagai User, saya ingin dokumentasi yang jelas agar bisa menggunakan sistem dengan baik.

**Acceptance Criteria:**
- User manual per role
- Step-by-step guides dengan screenshots
- FAQ section
- Troubleshooting guide
- Video tutorials (optional)

**Subtasks:**

#### SB-040-01: User Manual 📋
- Write manual untuk Super Admin
- Write manual untuk Staff Akademik
- Write manual untuk Guru
- Write manual untuk Siswa
- Add screenshots
- Review dan revise

**Estimasi:** 8 hours  
**Dependencies:** All features

#### SB-040-02: FAQ & Troubleshooting 📋
- Collect common questions
- Write FAQ answers
- Create troubleshooting guide
- Add search functionality
- Publish documentation

**Estimasi:** 4 hours  
**Dependencies:** SB-040-01

#### SB-040-03: Video Tutorials (Optional) 📋
- Script video tutorials
- Record screencasts
- Edit videos
- Upload to YouTube/platform
- Embed in documentation

**Estimasi:** 8 hours  
**Dependencies:** SB-040-02

---

### ST-041: Developer Documentation 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Lead Developer  

**User Story:**  
Sebagai Developer, saya ingin dokumentasi teknis untuk onboarding dan maintenance.

**Acceptance Criteria:**
- Setup & installation guide
- Architecture documentation
- Database schema documentation
- API documentation
- Code standards & best practices
- Contributing guide

**Subtasks:**

#### SB-041-01: Technical Documentation 📋
- Document architecture
- Document database schema (ERD)
- Document folder structure
- Document naming conventions
- Document coding standards

**Estimasi:** 5 hours  
**Dependencies:** None

#### SB-041-02: API Documentation 📋
- Document all API endpoints
- Add request/response examples
- Add authentication guide
- Add error codes
- Publish on Postman/Swagger

**Estimasi:** 4 hours  
**Dependencies:** ST-036

#### SB-041-03: Contributing Guide 📋
- Write contributing guidelines
- Document git workflow
- Document PR process
- Document code review standards
- Add issue templates

**Estimasi:** 2 hours  
**Dependencies:** SB-041-01

---

### ST-042: Training Materials 📋
**Priority:** 🟡 MEDIUM  
**Status:** 📋 TODO  
**Story Points:** 5  
**Assignee:** Trainer  

**User Story:**  
Sebagai Admin, saya ingin training untuk staff agar mereka bisa menggunakan sistem dengan optimal.

**Acceptance Criteria:**
- Training slides per role
- Hands-on exercises
- Training schedule
- Certificate (optional)
- Post-training survey

**Subtasks:**

#### SB-042-01: Training Materials 📋
- Create training slides
- Create exercise scenarios
- Create cheat sheets
- Print materials
- Prepare demo environment

**Estimasi:** 4 hours  
**Dependencies:** ST-040

#### SB-042-02: Conduct Training 📋
- Schedule training sessions
- Train Super Admin & Staff
- Train Guru
- Train Siswa (if needed)
- Collect feedback

**Estimasi:** Varies  
**Dependencies:** SB-042-01

---

## EP-015: Performance & Security Optimization 📋

**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Ongoing**  
**Story Points:** 21  

### Deskripsi
Continuous optimization untuk performa dan keamanan aplikasi.

---

### ST-043: Performance Optimization 📋
**Priority:** 🟠 HIGH  
**Status:** 📋 TODO  
**Story Points:** 13  
**Assignee:** Backend Developer  

**User Story:**  
Sebagai User, saya ingin aplikasi loading cepat dan responsif.

**Acceptance Criteria:**
- Page load < 2 detik
- Database query optimization
- Caching implementation
- Image optimization
- Lazy loading
- Performance monitoring

**Subtasks:**

#### SB-043-01: Database Optimization 📋
- Add indexes pada foreign keys
- Optimize slow queries
- Implement eager loading
- Remove N+1 queries
- Test query performance

**Estimasi:** 4 hours  
**Dependencies:** None

#### SB-043-02: Caching 📋
- Implement Redis cache (optional)
- Cache static data (roles, permissions)
- Cache frequent queries
- Set cache expiration
- Test cache invalidation

**Estimasi:** 5 hours  
**Dependencies:** SB-043-01

#### SB-043-03: Frontend Optimization 📋
- Minify CSS/JS
- Optimize images (WebP, lazy load)
- Implement CDN (optional)
- Test load times
- Fix bottlenecks

**Estimasi:** 4 hours  
**Dependencies:** SB-043-02

---

### ST-044: Security Hardening 📋
**Priority:** 🔴 CRITICAL  
**Status:** 📋 TODO  
**Story Points:** 8  
**Assignee:** Security Engineer  

**User Story:**  
Sebagai Admin, saya ingin sistem aman dari serangan dan data terlindungi.

**Acceptance Criteria:**
- Security audit
- Fix vulnerabilities
- HTTPS enforcement
- SQL injection prevention
- XSS prevention
- CSRF protection
- Rate limiting
- Security headers

**Subtasks:**

#### SB-044-01: Security Audit 📋
- Run security scan (OWASP ZAP, etc)
- Identify vulnerabilities
- Prioritize fixes
- Document findings

**Estimasi:** 3 hours  
**Dependencies:** None

#### SB-044-02: Fix Vulnerabilities 📋
- Fix SQL injection risks
- Fix XSS risks
- Implement rate limiting
- Add security headers
- Test fixes

**Estimasi:** 5 hours  
**Dependencies:** SB-044-01

#### SB-044-03: SSL/HTTPS Setup 📋
- Get SSL certificate
- Configure web server
- Force HTTPS redirect
- Test HTTPS
- Update documentation

**Estimasi:** 2 hours  
**Dependencies:** SB-044-02

---

# SUMMARY

---

## 📊 Ticket Statistics

### Total Tickets
- **Epics:** 15
- **Stories:** 44
- **Subtasks:** 150+

### By Status
- ✅ **DONE:** 20 Stories (Phase 1)
- 🚧 **IN PROGRESS:** 2 Stories
- 📋 **TODO:** 22 Stories (Phase 2-3)

### By Priority
- 🔴 **CRITICAL:** 12 Epics/Stories
- 🟠 **HIGH:** 8 Epics/Stories
- 🟡 **MEDIUM:** 6 Epics/Stories
- 🟢 **LOW:** 4 Epics/Stories

### Story Points
- **Phase 1 (DONE):** ~130 points
- **Phase 2 (TODO):** ~90 points
- **Phase 3 (TODO):** ~80 points
- **Maintenance (Ongoing):** ∞ points

---

## 🎯 Sprint Planning Suggestion

### Sprint 1-2 (DONE ✅)
- EP-001: Authentication & RBAC
- EP-002: User Management

### Sprint 3-4 (DONE ✅)
- EP-003: Data Akademik Master
- EP-004: Guru & Siswa Management
- EP-005: Dashboard System

### Sprint 5-6 (DONE ✅)
- EP-006: Advanced Scheduling System

### Sprint 7-8 (NEXT 📋)
- EP-007: Nilai/Grades Management

### Sprint 9-10
- EP-008: Absensi/Attendance System

### Sprint 11
- EP-009: Pengumuman & Communication

### Sprint 12-13
- EP-010: Reporting & Analytics

### Sprint 14
- EP-011: Mobile Optimization & PWA

### Sprint 15
- EP-012: Integration & API

### Ongoing
- EP-013: Testing & QA
- EP-014: Documentation & Training
- EP-015: Performance & Security

---

## 📝 Notes

### Dependencies
- Pastikan setup environment lengkap sebelum mulai development
- Fase 2 depends on Fase 1 completion
- API development bisa paralel dengan frontend

### Team Assignment
- **Backend Developer:** Database, Controller, Service, API
- **Frontend Developer:** Views, UI/UX, JavaScript
- **Full Stack Developer:** Complete features end-to-end
- **QA Engineer:** Testing, bug reporting
- **DevOps:** Deployment, CI/CD, monitoring

### Definition of Done (DoD)
Sebuah ticket dianggap DONE jika:
- ✅ Code implemented dan tested
- ✅ Unit tests written (if applicable)
- ✅ Feature tested manually
- ✅ Code reviewed dan approved
- ✅ Merged to main branch
- ✅ Deployed to staging
- ✅ Documentation updated

---

**Document Version:** 1.0  
**Last Updated:** 22 April 2026  
**Status:** Active  
**Next Review:** End of each sprint

