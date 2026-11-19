# EduTask – Sistem Manajemen Tugas & Kolaborasi Proyek Mahasiswa
> **TUGAS PROYEK AKHIR – TAHAP 1**  
> **Topik:** Inisiasi Proyek dan Persiapan Pengembangan Aplikasi  
> **Technology Stack:** Laravel 12 • Vue.js 3 • Inertia.js • Tailwind CSS • SQLite / MySQL

---

## 👥 Identitas Kelompok & Anggota

- **Mata Kuliah**: Proyek Perangkat Lunak / Pemrograman Web Berbasis Kerangka Kerja
- **Kelompok**: Kelompok [Nomor Kelompok]
- **Anggota Tim**:
  1. **[Nama Mahasiswa 1 / Ketua Kelompok]** – NIM: [NIM 1] *(Peran: Project Lead & Full-Stack Developer)*
  2. **[Nama Mahasiswa 2]** – NIM: [NIM 2] *(Peran: Frontend Developer & UI/UX Designer)*
  3. **[Nama Mahasiswa 3]** – NIM: [NIM 3] *(Peran: Backend Developer & Database Engineer)*

---

## 📌 Ringkasan Proyek

**EduTask** adalah platform manajemen proyek dan papan penugasan (*Kanban Task Board*) kolaboratif berbasis web yang dirancang khusus untuk memfasilitasi mahasiswa dalam mengelola proyek perkuliahan secara terstruktur, membagi tugas anggota kelompok secara adil, serta memantau progres dan tenggat waktu (*deadline*) secara transparan.

Proyek ini dibangun menggunakan arsitektur monolitik modern yang memadukan keandalan **Laravel 12** sebagai backend framework, kedinamisan **Vue.js 3** sebagai frontend framework, serta **Inertia.js** sebagai penghubung tanpa perlu membangun REST API terpisah.

---

## 🚀 Technology Stack & Peran Komponen

| Teknologi | Versi | Peran dalam Sistem |
| :--- | :--- | :--- |
| **Laravel** | v12.x (PHP 8.3+) | **Backend Framework**: Menangani perutean (*routing*), kontroler logika bisnis, model ORM Eloquent, sistem migrasi basis data, dan autentikasi sesi pengguna. |
| **Vue.js** | v3.x (Composition API) | **Frontend Framework**: Membangun antarmuka pengguna interaktif (*reactive components*), manajemen formulir, dan rendering halaman Single Page Application (SPA). |
| **Inertia.js** | v2.x | **Bridge / Adapter**: Menghubungkan Laravel controller langsung dengan komponen Vue.js. Mengirimkan data via *props* tanpa *full page reload* dan tanpa kerepotan manajemen token/REST API tradisional. |
| **Tailwind CSS** | v4.x | **Utility-First CSS**: Menghasilkan tata letak (*layout*) responsif, modern, dan konsisten di berbagai ukuran layar perangkat. |
| **Vite** | v7.x | **Frontend Build Tool**: Menyediakan *Hot Module Replacement* (HMR) saat pengembangan dan meng-compile berkas produksi dengan performa optimal. |
| **SQLite / MySQL** | - | **Database Engine**: Mengelola persistensi data pengguna, proyek, dan penugasan tim. Terkonfigurasi SQLite siap pakai out-of-the-box (zero configuration). |

---

## ✅ Luaran (Deliverables) Tahap 1

- [x] **Inisiasi & Konfigurasi Proyek**: Project Laravel 12 berhasil dihubungkan dengan Vue.js 3 dan Inertia.js menggunakan starter kit Breeze.
- [x] **Aplikasi Berjalan Lancar**: Aplikasi dapat dijalankan di lingkungan lokal dengan server PHP Artisan dan Vite dev server.
- [x] **Dokumen PRD.md**: Dokumen *Product Requirements Document* lengkap telah disusun di root repository ([PRD.md](./PRD.md)), mencakup latar belakang, target pengguna, user flow, kebutuhan fungsional/non-fungsional, wireframe, dan panduan prompting AI.
- [x] **Implementasi Fitur Utama Awal**:
  - Halaman Beranda (*Landing Page*) modern dan informatif.
  - Sistem Autentikasi lengkap (*Register, Login, Update Profile*).
  - Dashboard analitik ringkasan proyek & status tugas.
  - Manajemen Proyek (CRUD Proyek, Filter Status, Pencarian, Indikator Persentase Progres Otomatis).
  - Papan Tugas Interaktif (*Kanban Task Board* 4 kolom: *To Do, In Progress, Review, Completed* dengan fitur ubah status tugas instan).
- [x] **Automated Testing**: 30 skenario pengujian PHPUnit lulus 100% (*feature test & authentication*).
- [x] **Database Seeder**: Data demo realistis dan kredensial pengujian siap pakai untuk evaluator/dosen.
- [x] **Dokumentasi & Git Repository**: Struktur repository rapi dengan riwayat commit terorganisir.

---

## 🔑 Akun Demo Pengujian (Seeded Accounts)

Untuk mempermudah dosen dan asisten praktikum dalam menguji aplikasi tanpa perlu registrasi manual:

| Peran Akun | Alamat Email | Kata Sandi (Password) |
| :--- | :--- | :--- |
| **Ketua Tim (Admin)** | `budi@edutask.test` | `password` |
| **Anggota 1 (Frontend)** | `siti@edutask.test` | `password` |
| **Anggota 2 (Backend)** | `ahmad@edutask.test` | `password` |

*(Penguji juga dapat mendaftarkan akun baru melalui tombol **Daftar Akun**).*

---

## 💻 Panduan Instalasi & Menjalankan Aplikasi secara Lokal

Ikuti langkah-langkah mudah berikut untuk menjalankan proyek di komputer lokal:

### 1. Prasyarat Lingkungan (Prerequisites)
Pastikan telah terinstal:
- PHP >= 8.2 (disertai ekstensi `pdo_sqlite` atau `pdo_mysql`, dan `zip`)
- Composer >= 2.0
- Node.js >= 18.0 & npm >= 9.0
- Git

### 2. Kloning Repository
```bash
git clone <URL_REPOSITORY_GITHUB_ANDA>
cd belajar-laravel
```

### 3. Instalasi Dependensi Backend (Composer)
```bash
composer install
```

### 4. Instalasi Dependensi Frontend (Node.js)
```bash
npm install
```

### 5. Konfigurasi Berkas Lingkungan (.env)
Jika berkas `.env` belum ada:
```bash
cp .env.example .env
php artisan key:generate
```

### 6. Migrasi Database & Pengisian Data Demo (Seeding)
Aplikasi secara default menggunakan SQLite (`database/database.sqlite`). Jalankan migrasi beserta data demo:
```bash
php artisan migrate:fresh --seed
```

### 7. Menjalankan Aplikasi
Buka **dua terminal terpisah**:

**Terminal 1 (Backend Server):**
```bash
php artisan serve
```
*(Server backend berjalan di `http://127.0.0.1:8000`)*

**Terminal 2 (Frontend Vite Server):**
```bash
npm run dev
```

Buka peramban (*browser*) dan akses: **`http://127.0.0.1:8000`**

*(Alternatif: Anda juga dapat menjalankan `npm run build` sekali saja, kemudian cukup menjalankan `php artisan serve`).*

---

## 🧪 Menjalankan Pengujian Otomatis (Automated Tests)

Untuk memverifikasi seluruh fungsionalitas backend dan autentikasi:
```bash
php artisan test
```
*Hasil: 30 passed tests (69 assertions).*

---

## 📁 Struktur Utama Proyek

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/                 # Kontroler Autentikasi (Breeze)
│   │   ├── ProjectController.php # Logika CRUD Proyek & Kalkulasi Progress
│   │   ├── TaskController.php    # Logika Manajemen Tugas & Update Status
│   │   └── ProfileController.php # Pengelolaan Profil Pengguna
│   └── Models/
│       ├── User.php              # Model Pengguna & Relasi Proyek/Tugas
│       ├── Project.php           # Model Proyek & Helper Persentase Progres
│       └── Task.php              # Model Tugas Tim & Tingkat Prioritas
├── database/
│   ├── migrations/               # Skema Tabel Database (users, projects, tasks)
│   └── seeders/DatabaseSeeder.php# Seeder Data Pengujian & Akun Demo
├── resources/
│   └── js/
│       ├── Components/           # Komponen UI Reusable (Modal, Button, Input)
│       ├── Layouts/
│       │   ├── AuthenticatedLayout.vue # Navigasi & Shell Pengguna Terautentikasi
│       │   └── GuestLayout.vue         # Shell Halaman Login/Register
│       └── Pages/
│           ├── Welcome.vue       # Halaman Beranda (Landing Page)
│           ├── Dashboard.vue     # Dashboard Ringkasan & Metrik Tugas
│           ├── Projects/
│           │   ├── Index.vue     # Daftar Proyek, Pencarian, & Filter Status
│           │   └── Show.vue      # Papan Kanban Tugas & Pembaruan Status Interaktif
│           └── Auth/             # Halaman Login, Register, Forgot Password
├── routes/
│   ├── web.php                   # Definisi Rute Web & Middleware Autentikasi
│   └── auth.php                  # Rute Autentikasi Breeze
├── PRD.md                        # Product Requirements Document (Tahap 1)
├── README.md                     # Dokumentasi Resmi Proyek
└── vite.config.js                # Konfigurasi Build Tool Vite
```

---

## 📝 Catatan Pengerjaan Pertemuan 1, Kendala & Solusi

| No | Aktivitas / Sasaran | Kendala yang Ditemukan | Solusi yang Diterapkan |
| :---: | :--- | :--- | :--- |
| 1 | Konfigurasi Stack Laravel + Vue + Inertia | Instalasi Breeze awal memerlukan dependensi ekstensi PHP `zip` dan `pdo_sqlite` yang belum aktif pada konfigurasi bawaan `php.ini`. | Mengaktifkan `extension=zip` dan `extension=pdo_sqlite` pada `php.ini`, lalu menjalankan kembali `composer require` dan `breeze:install vue`. |
| 2 | Menjalankan build frontend di Windows PowerShell | Kebijakan eksekusi skrip PowerShell (`ExecutionPolicy Restricted`) mencegah eksekusi file `npm.ps1`. | Menjalankan perintah melalui `npm.cmd` atau mengatur `Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass`. |
| 3 | Perancangan Database Proyek & Tugas | Diperlukan relasi cascade agar saat proyek dihapus, seluruh tugas yang bernaung di bawahnya tidak menjadi *orphan record*. | Menerapkan `foreignId('project_id')->constrained()->cascadeOnDelete()` pada migrasi tabel `tasks`. |
| 4 | Pembaruan Status Tugas Realtime | Menghindari *full page reload* ketika mahasiswa memindahkan status tugas di papan Kanban. | Memanfaatkan `router.patch()` dari Inertia.js untuk mengirimkan mutasi status secara asynchronous dengan *preserveScroll: true*. |

---

## 🌐 Panduan Git & Pengumpulan ke SPADA

### 1. Inisiasi dan Push ke Repository GitHub/GitLab (Dilakukan 1 kali oleh Ketua Kelompok)
1. Buat repository baru di [GitHub](https://github.com/new) atau [GitLab](https://gitlab.com/projects/new) dengan nama `edutask-proyek-akhir` (set visibility ke **Public**).
2. Jalankan perintah berikut pada terminal proyek:
```bash
git init
git add .
git commit -m "feat: inisiasi proyek EduTask dengan stack Laravel 12, Vue 3, Inertia.js dan dokumen PRD"
git branch -M main
git remote add origin https://github.com/<USERNAME_GITHUB>/edutask-proyek-akhir.git
git push -u origin main
```
3. Undang seluruh anggota kelompok sebagai *Collaborator* di repository GitHub/GitLab agar seluruh anggota memiliki rekam jejak commit.

### 2. Pengumpulan ke Portal SPADA (Dilakukan Masing-Masing / Individual)
Sesuai instruksi tugas:
> *"Pengiriman link github / gitlab ke spada di kirim masing-masing / individual"*

Setiap mahasiswa wajib mengirimkan tautan repository kelompok yang telah dibuat ke formulir pengumpulan SPADA masing-masing akun mahasiswa dengan menyertakan keterangan:
- Nama Lengkap & NIM
- Peran dalam Kelompok
- Tautan Repository: `https://github.com/<USERNAME>/<NAMA_REPO>`
- Catatan: Aplikasi telah mengimplementasikan stack Laravel 12 + Vue 3 + Inertia.js dengan dokumen PRD.md dan fitur Papan Proyek/Tugas aktif.

---
*EduTask © 2026 – Dikembangkan untuk Tugas Proyek Akhir Tahap 1.*
