<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Pengguna Demo
        $budi = User::firstOrCreate(
            ['email' => 'budi@edutask.test'],
            [
                'name' => 'Budi Santoso (Ketua Tim)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $siti = User::firstOrCreate(
            ['email' => 'siti@edutask.test'],
            [
                'name' => 'Siti Rahmawati (Frontend Dev)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $ahmad = User::firstOrCreate(
            ['email' => 'ahmad@edutask.test'],
            [
                'name' => 'Ahmad Fauzi (Backend Dev)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Proyek 1: EduTask
        $proj1 = Project::create([
            'user_id' => $budi->id,
            'title' => 'EduTask: Sistem Manajemen Tugas & Kolaborasi Proyek Mahasiswa',
            'course_name' => 'Proyek Perangkat Lunak',
            'description' => 'Platform kolaboratif pengerjaan tugas proyek akhir berbasis Laravel 12, Vue.js 3, dan Inertia.js dengan pelacakan task real-time.',
            'status' => 'in_progress',
            'due_date' => now()->addDays(30),
        ]);

        $tasksProj1 = [
            [
                'title' => 'Inisiasi Proyek & Konfigurasi Stack Laravel + Vue 3 + Inertia',
                'description' => 'Menyiapkan repositori, menginstal Laravel Breeze dengan Vue stack, konfigurasi Vite dan Tailwind CSS.',
                'priority' => 'urgent',
                'status' => 'completed',
                'assigned_name' => 'Budi Santoso',
                'due_date' => now()->subDays(2),
            ],
            [
                'title' => 'Penyusunan Dokumen PRD.md (Product Requirements Document)',
                'description' => 'Menyusun latar belakang, target pengguna, user flow, kebutuhan fungsional/non-fungsional, dan pedoman AI context.',
                'priority' => 'high',
                'status' => 'completed',
                'assigned_name' => 'Siti Rahmawati',
                'due_date' => now()->subDay(),
            ],
            [
                'title' => 'Perancangan Skema Database Proyek & Manajemen Tugas',
                'description' => 'Membuat migration tabel projects, tasks, relasi foreign key, dan model Eloquent.',
                'priority' => 'high',
                'status' => 'completed',
                'assigned_name' => 'Ahmad Fauzi',
                'due_date' => now(),
            ],
            [
                'title' => 'Implementasi Fitur Dashboard & Task Board Interaktif',
                'description' => 'Mengembangkan halaman Vue 3 untuk kanban task list, pengubahan status tugas secara instan, dan kalkulasi progress otomatis.',
                'priority' => 'urgent',
                'status' => 'in_progress',
                'assigned_name' => 'Budi Santoso',
                'due_date' => now()->addDays(5),
            ],
            [
                'title' => 'Pengujian Alur Frontend Inertia & Validasi Request',
                'description' => 'Menguji form submit, navigasi single page application tanpa reload, dan feedback error pesan.',
                'priority' => 'medium',
                'status' => 'in_progress',
                'assigned_name' => 'Siti Rahmawati',
                'due_date' => now()->addDays(7),
            ],
            [
                'title' => 'Review Kode & Refactoring Komponen Reusable',
                'description' => 'Melakukan standarisasi komponen UI (modal, status badge, button) dan audit performa build Vite.',
                'priority' => 'medium',
                'status' => 'review',
                'assigned_name' => 'Ahmad Fauzi',
                'due_date' => now()->addDays(10),
            ],
            [
                'title' => 'Penyusunan README.md & Panduan Setup Repository GitHub',
                'description' => 'Mendokumentasikan arsitektur, cara clone & run, struktur proyek, dan persiapan submit SPADA.',
                'priority' => 'high',
                'status' => 'completed',
                'assigned_name' => 'Budi Santoso',
                'due_date' => now()->addDays(1),
            ],
            [
                'title' => 'Pengumpulan Link Repository ke SPADA',
                'description' => 'Memastikan repositori GitHub dapat diakses publik/dosen dan submit link secara individual.',
                'priority' => 'medium',
                'status' => 'todo',
                'assigned_name' => 'Siti Rahmawati',
                'due_date' => now()->addDays(3),
            ],
        ];

        foreach ($tasksProj1 as $taskData) {
            $proj1->tasks()->create([
                ...$taskData,
                'user_id' => $budi->id,
            ]);
        }

        // 3. Proyek 2: Aplikasi Reservasi Lab
        $proj2 = Project::create([
            'user_id' => $siti->id,
            'title' => 'Sistem Reservasi & Penggunaan Fasilitas Lab Komputer',
            'course_name' => 'Rekayasa Perangkat Lunak Berorientasi Objek',
            'description' => 'Aplikasi web pemesanan slot laboratorium terintegrasi jadwal perkuliahan dan verifikasi asisten lab.',
            'status' => 'planning',
            'due_date' => now()->addDays(45),
        ]);

        $proj2->tasks()->createMany([
            [
                'user_id' => $siti->id,
                'title' => 'Analisis Kebutuhan Sistem & Wawancara Kepala Lab',
                'description' => 'Mengumpulkan data kapasitas PC lab dan aturan jam peminjaman.',
                'priority' => 'high',
                'status' => 'in_progress',
                'assigned_name' => 'Siti Rahmawati',
                'due_date' => now()->addDays(4),
            ],
            [
                'user_id' => $siti->id,
                'title' => 'Desain Wireframe UI/UX Reservasi Slot',
                'description' => 'Membuat mockup tampilan kalender pemesanan ruangan lab.',
                'priority' => 'medium',
                'status' => 'todo',
                'assigned_name' => 'Ahmad Fauzi',
                'due_date' => now()->addDays(8),
            ],
        ]);

        // 4. Proyek 3: Analisis Data Prestasi
        $proj3 = Project::create([
            'user_id' => $ahmad->id,
            'title' => 'Sistem Analisis Klaster Prestasi Mahasiswa dengan K-Means',
            'course_name' => 'Penambangan Data & Kecerdasan Buatan',
            'description' => 'Aplikasi pengolahan data akademik untuk mengidentifikasi kelompok mahasiswa berprestasi dan mahasiswa bimbingan khusus.',
            'status' => 'completed',
            'due_date' => now()->subDays(5),
        ]);

        $proj3->tasks()->createMany([
            [
                'user_id' => $ahmad->id,
                'title' => 'Preprocessing Dataset Akademik',
                'description' => 'Normalisasi nilai IPK, SKS, dan poin keaktifan ekstrakurikuler.',
                'priority' => 'high',
                'status' => 'completed',
                'assigned_name' => 'Ahmad Fauzi',
                'due_date' => now()->subDays(10),
            ],
            [
                'user_id' => $ahmad->id,
                'title' => 'Implementasi Algoritma Klastering K-Means',
                'description' => 'Perhitungan jarak Euclidean dan penentuan centroid optimal (Elbow method).',
                'priority' => 'urgent',
                'status' => 'completed',
                'assigned_name' => 'Budi Santoso',
                'due_date' => now()->subDays(6),
            ],
        ]);
    }
}
