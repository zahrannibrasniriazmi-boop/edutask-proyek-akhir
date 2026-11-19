<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    stats: Object,
});
</script>

<template>
    <Head title="EduTask - Sistem Manajemen Proyek & Tugas Mahasiswa" />

    <div class="min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">
        <!-- Top Navigation -->
        <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-slate-900">
                            Edu<span class="text-indigo-600">Task</span>
                        </span>
                        <span class="ml-2 hidden rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 sm:inline-block">
                            Tahap 1 • Inisiasi Proyek
                        </span>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex items-center gap-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                    >
                        <span>Ke Dashboard</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-100 transition"
                        >
                            Masuk
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                        >
                            Daftar Akun
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main>
            <div class="relative overflow-hidden pt-12 pb-20 lg:pt-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto">
                        <div class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50/80 px-4 py-1.5 text-xs font-medium text-indigo-700 mb-6 shadow-xs">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                            Tugas Proyek Akhir • Tahap 1: Inisiasi Proyek & Stack
                        </div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                            Kelola Proyek & Tugas Akademik Bersama <span class="text-indigo-600">EduTask</span>
                        </h1>
                        <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                            Platform kolaborasi modern untuk mahasiswa dalam mengelola proyek perkuliahan, pembagian tugas anggota tim, pelacakan progress, dan deadline secara terstruktur dan transparan.
                        </p>

                        <!-- Tech Stack Badges -->
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-2.5">
                            <span class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Laravel 12 (Backend)
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Vue.js 3 (Frontend)
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-lg border border-purple-200 bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                <span class="h-2 w-2 rounded-full bg-purple-500"></span>
                                Inertia.js (Bridge)
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-lg border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                                <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                                Tailwind CSS (Styling)
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                SQLite / MySQL (Database)
                            </span>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('projects.index')"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-base font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition"
                            >
                                <span>Buka Board Proyek & Tugas</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </Link>
                            <Link
                                v-else
                                :href="route('login')"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-base font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition"
                            >
                                <span>Masuk ke Aplikasi</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </Link>
                            <a
                                href="#demo-info"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-base font-semibold text-slate-700 hover:bg-slate-50 transition"
                            >
                                <span>Petunjuk & Akun Demo</span>
                            </a>
                        </div>
                    </div>

                    <!-- Demo Account Info Card -->
                    <div id="demo-info" class="mt-16 max-w-3xl mx-auto rounded-2xl border border-indigo-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="flex h-3 w-3 rounded-full bg-emerald-500"></span>
                                <h3 class="font-bold text-slate-900">Akun Demo Pengujian Dosen & Asisten (Siap Digunakan)</h3>
                            </div>
                            <span class="rounded bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">Seeded Data</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200/60">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Ketua Tim (Admin)</p>
                                <p class="font-bold text-slate-900 mt-1">budi@edutask.test</p>
                                <p class="text-xs text-slate-500 mt-1 font-mono">Password: <span class="font-bold text-slate-700">password</span></p>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200/60">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Anggota 1 (Frontend)</p>
                                <p class="font-bold text-slate-900 mt-1">siti@edutask.test</p>
                                <p class="text-xs text-slate-500 mt-1 font-mono">Password: <span class="font-bold text-slate-700">password</span></p>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200/60">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Anggota 2 (Backend)</p>
                                <p class="font-bold text-slate-900 mt-1">ahmad@edutask.test</p>
                                <p class="text-xs text-slate-500 mt-1 font-mono">Password: <span class="font-bold text-slate-700">password</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 1 Deliverables Overview Grid -->
                    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-300 transition">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 mb-4 font-bold text-lg">
                                01
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Teknologi Modern Full-Stack</h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Menggabungkan ketangguhan <strong>Laravel 12</strong> di backend, reaktivitas <strong>Vue.js 3</strong> di frontend, dan <strong>Inertia.js</strong> sebagai jembatan SPA tanpa repot membuat REST API manual.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-300 transition">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 mb-4 font-bold text-lg">
                                02
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Dokumen PRD.md Lengkap</h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Dilengkapi dokumen <strong>PRD.md</strong> terstruktur (Latar Belakang, User Persona, Flowchart, Kebutuhan Fungsional/Non-Fungsional, Wireframe, dan Pedoman AI Coding Tools).
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-300 transition">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 mb-4 font-bold text-lg">
                                03
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Fitur Utama: Project & Task Board</h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Sudah terimplementasi fungsionalitas manajemen proyek & papan penugasan (CRUD Proyek, Tambah Tugas, Filter Status & Prioritas, serta Pelacakan Progress).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200 bg-white py-8 text-center text-xs text-slate-500">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <p>EduTask • Tugas Proyek Akhir Tahap 1 • Inisiasi Proyek & Persiapan Lingkungan Pengembangan</p>
                <p class="mt-1 text-slate-400">Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }}) + Vue.js 3 + Inertia.js</p>
            </div>
        </footer>
    </div>
</template>
