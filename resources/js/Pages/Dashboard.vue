<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    recentProjects: Array,
    stats: Object,
    recentTasks: Array,
});

const statusBadge = (status) => {
    switch (status) {
        case 'planning':
            return { label: 'Perencanaan', class: 'bg-blue-50 text-blue-700 border-blue-200' };
        case 'in_progress':
            return { label: 'Sedang Berjalan', class: 'bg-amber-50 text-amber-700 border-amber-200' };
        case 'completed':
            return { label: 'Selesai', class: 'bg-emerald-50 text-emerald-700 border-emerald-200' };
        case 'on_hold':
            return { label: 'Ditunda', class: 'bg-slate-100 text-slate-700 border-slate-200' };
        default:
            return { label: status, class: 'bg-slate-100 text-slate-700 border-slate-200' };
    }
};

const taskStatusBadge = (status) => {
    switch (status) {
        case 'todo':
            return { label: 'To Do', class: 'bg-slate-100 text-slate-700 border-slate-200' };
        case 'in_progress':
            return { label: 'In Progress', class: 'bg-blue-50 text-blue-700 border-blue-200' };
        case 'review':
            return { label: 'Review', class: 'bg-purple-50 text-purple-700 border-purple-200' };
        case 'completed':
            return { label: 'Selesai', class: 'bg-emerald-50 text-emerald-700 border-emerald-200' };
        default:
            return { label: status, class: 'bg-slate-100 text-slate-700 border-slate-200' };
    }
};

const priorityBadge = (priority) => {
    switch (priority) {
        case 'urgent':
            return { label: 'Mendesak', class: 'bg-rose-50 text-rose-700 border-rose-200' };
        case 'high':
            return { label: 'Tinggi', class: 'bg-orange-50 text-orange-700 border-orange-200' };
        case 'medium':
            return { label: 'Sedang', class: 'bg-indigo-50 text-indigo-700 border-indigo-200' };
        case 'low':
            return { label: 'Rendah', class: 'bg-slate-100 text-slate-600 border-slate-200' };
        default:
            return { label: priority, class: 'bg-slate-100 text-slate-600 border-slate-200' };
    }
};
</script>

<template>
    <Head title="Dashboard Ringkasan" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold leading-tight text-slate-900">
                        Dashboard Kolaborasi Proyek
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Selamat datang kembali, <span class="font-semibold text-slate-800">{{ $page.props.auth.user.name }}</span>! Pantau perkembangan tugas kelompok Anda di sini.
                    </p>
                </div>
                <div>
                    <Link
                        :href="route('projects.index')"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Kelola Proyek & Tugas</span>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
                <!-- Status Bar Alert / Info Tahap 1 -->
                <div class="rounded-xl border border-indigo-100 bg-gradient-to-r from-indigo-50/80 via-white to-purple-50/50 p-5 shadow-xs">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-white shadow-xs">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-slate-900">
                                Status Implementasi Tahap 1: Inisiasi & Persiapan Pengembangan Berhasil!
                            </h3>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Stack <strong>Laravel 12 + Vue.js 3 + Inertia.js</strong> telah berjalan aktif. Fitur manajemen proyek dan papan penugasan (Task Board) sudah terhubung ke database. Dokumen <code>PRD.md</code> dan <code>README.md</code> tersedia di repository.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stats Counters Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Proyek</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-slate-900">{{ stats.total_projects }}</span>
                            <span class="text-xs font-medium text-slate-400">Proyek</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Berjalan</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-amber-600">{{ stats.in_progress_projects }}</span>
                            <span class="text-xs font-medium text-amber-500">Aktif</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selesai</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-emerald-600">{{ stats.completed_projects }}</span>
                            <span class="text-xs font-medium text-emerald-500">Done</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Tugas</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-slate-900">{{ stats.total_tasks }}</span>
                            <span class="text-xs font-medium text-slate-400">Tugas</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pending</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-blue-600">{{ stats.pending_tasks }}</span>
                            <span class="text-xs font-medium text-blue-500">To Do/Process</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tugas Selesai</span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-emerald-600">{{ stats.completed_tasks }}</span>
                            <span class="text-xs font-medium text-emerald-500">Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects Section -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Daftar Proyek Aktif</h3>
                            <p class="text-xs text-slate-500">Proyek perkuliahan dan kemajuan pengerjaan</p>
                        </div>
                        <Link
                            :href="route('projects.index')"
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition"
                        >
                            Lihat Semua Proyek &rarr;
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            v-for="project in recentProjects"
                            :key="project.id"
                            class="rounded-xl border border-slate-200 bg-white p-5 shadow-2xs hover:border-indigo-300 transition flex flex-col justify-between"
                        >
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-xs font-medium text-indigo-600 font-mono">
                                        {{ project.course_name || 'Proyek Umum' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium"
                                        :class="statusBadge(project.status).class"
                                    >
                                        {{ statusBadge(project.status).label }}
                                    </span>
                                </div>
                                <h4 class="mt-2 text-base font-bold text-slate-900">
                                    <Link :href="route('projects.show', project.id)" class="hover:text-indigo-600">
                                        {{ project.title }}
                                    </Link>
                                </h4>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-2">
                                    {{ project.description || 'Tidak ada deskripsi khusus.' }}
                                </p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100">
                                <div class="flex items-center justify-between text-xs text-slate-600 mb-1.5">
                                    <span>Progress Pengerjaan</span>
                                    <span class="font-bold text-slate-800">{{ project.progress_percentage }}% ({{ project.completed_tasks_count }}/{{ project.tasks_count }} tugas)</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                    <div
                                        class="h-full bg-indigo-600 transition-all duration-300 rounded-full"
                                        :style="{ width: `${project.progress_percentage}%` }"
                                    ></div>
                                </div>
                                <div class="mt-3 flex items-center justify-between text-xs">
                                    <span class="text-slate-400">
                                        Batas: {{ project.due_date ? new Date(project.due_date).toLocaleDateString('id-ID') : '-' }}
                                    </span>
                                    <Link
                                        :href="route('projects.show', project.id)"
                                        class="font-semibold text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1"
                                    >
                                        <span>Buka Board</span>
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks Table -->
                <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-2xs">
                    <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Tugas Terbaru Tim</h3>
                            <p class="text-xs text-slate-500">Daftar penugasan anggota yang perlu diselesaikan</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Nama Tugas</th>
                                    <th class="px-6 py-3">Proyek</th>
                                    <th class="px-6 py-3">Penanggung Jawab</th>
                                    <th class="px-6 py-3">Prioritas</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="task in recentTasks" :key="task.id" class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-3.5 font-medium text-slate-900">
                                        {{ task.title }}
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-slate-500">
                                        {{ task.project?.title }}
                                    </td>
                                    <td class="px-6 py-3.5 text-xs">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-0.5 text-slate-700 font-medium">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            {{ task.assigned_name || 'Belum ditugaskan' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs">
                                        <span
                                            class="inline-flex items-center rounded-md border px-2 py-0.5 font-medium"
                                            :class="priorityBadge(task.priority).class"
                                        >
                                            {{ priorityBadge(task.priority).label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs">
                                        <span
                                            class="inline-flex items-center rounded-md border px-2 py-0.5 font-medium"
                                            :class="taskStatusBadge(task.status).class"
                                        >
                                            {{ taskStatusBadge(task.status).label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right text-xs">
                                        <Link
                                            :href="route('projects.show', task.project_id)"
                                            class="font-semibold text-indigo-600 hover:text-indigo-800"
                                        >
                                            Detail &rarr;
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
