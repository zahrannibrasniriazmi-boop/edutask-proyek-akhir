<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    projects: Object,
    filters: Object,
    stats: Object,
});

const search = ref(props.filters.search || '');
const selectedStatus = ref(props.filters.status || 'all');
const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const projectToDelete = ref(null);

const form = useForm({
    title: '',
    course_name: '',
    description: '',
    status: 'in_progress',
    due_date: '',
});

const applyFilter = () => {
    router.get(
        route('projects.index'),
        {
            search: search.value,
            status: selectedStatus.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
};

const handleSearch = () => {
    applyFilter();
};

const filterByStatus = (status) => {
    selectedStatus.value = status;
    applyFilter();
};

const openCreateModal = () => {
    form.reset();
    showCreateModal.value = true;
};

const closeCreateModal = () => {
    showCreateModal.value = false;
    form.reset();
};

const submitProject = () => {
    form.post(route('projects.store'), {
        onSuccess: () => {
            closeCreateModal();
        },
    });
};

const confirmDelete = (project) => {
    projectToDelete.value = project;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    projectToDelete.value = null;
};

const deleteProject = () => {
    if (!projectToDelete.value) return;
    router.delete(route('projects.destroy', projectToDelete.value.id), {
        onSuccess: () => {
            closeDeleteModal();
        },
    });
};

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
</script>

<template>
    <Head title="Manajemen Proyek" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold leading-tight text-slate-900">
                        Manajemen Proyek & Kolaborasi Tim
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola repositori proyek tugas akhir, mata kuliah, dan pembagian tanggung jawab anggota tim.
                    </p>
                </div>
                <div>
                    <button
                        type="button"
                        @click="openCreateModal"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Buat Proyek Baru</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
                <!-- Stat Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Proyek</span>
                        <div class="mt-2 text-2xl font-bold text-slate-900">{{ stats.total_projects }}</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sedang Berjalan</span>
                        <div class="mt-2 text-2xl font-bold text-amber-600">{{ stats.in_progress }}</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selesai</span>
                        <div class="mt-2 text-2xl font-bold text-emerald-600">{{ stats.completed }}</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Tugas Tim</span>
                        <div class="mt-2 text-2xl font-bold text-indigo-600">{{ stats.total_tasks }}</div>
                    </div>
                </div>

                <!-- Filters & Search Toolbar -->
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    <!-- Search Input -->
                    <form @submit.prevent="handleSearch" class="relative flex-1">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari berdasarkan judul proyek, mata kuliah, atau deskripsi..."
                            class="w-full rounded-lg border-slate-200 pl-10 pr-4 text-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-slate-400"
                        />
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>

                    <!-- Status Filters -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
                        <button
                            type="button"
                            @click="filterByStatus('all')"
                            class="rounded-lg px-3 py-1.5 text-xs font-semibold transition"
                            :class="selectedStatus === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        >
                            Semua
                        </button>
                        <button
                            type="button"
                            @click="filterByStatus('in_progress')"
                            class="rounded-lg px-3 py-1.5 text-xs font-semibold transition"
                            :class="selectedStatus === 'in_progress' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        >
                            Berjalan
                        </button>
                        <button
                            type="button"
                            @click="filterByStatus('planning')"
                            class="rounded-lg px-3 py-1.5 text-xs font-semibold transition"
                            :class="selectedStatus === 'planning' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        >
                            Perencanaan
                        </button>
                        <button
                            type="button"
                            @click="filterByStatus('completed')"
                            class="rounded-lg px-3 py-1.5 text-xs font-semibold transition"
                            :class="selectedStatus === 'completed' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        >
                            Selesai
                        </button>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div v-if="projects.data && projects.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="project in projects.data"
                        :key="project.id"
                        class="rounded-xl border border-slate-200 bg-white p-5 shadow-2xs hover:border-indigo-300 hover:shadow-sm transition flex flex-col justify-between"
                    >
                        <div>
                            <div class="flex items-start justify-between gap-2">
                                <span class="rounded bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">
                                    {{ project.course_name || 'Proyek Umum' }}
                                </span>
                                <span
                                    class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium"
                                    :class="statusBadge(project.status).class"
                                >
                                    {{ statusBadge(project.status).label }}
                                </span>
                            </div>

                            <h3 class="mt-3 text-lg font-bold text-slate-900 line-clamp-1">
                                <Link :href="route('projects.show', project.id)" class="hover:text-indigo-600 transition">
                                    {{ project.title }}
                                </Link>
                            </h3>
                            <p class="mt-2 text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ project.description || 'Belum ada rincian deskripsi untuk proyek ini.' }}
                            </p>
                        </div>

                        <div class="mt-5 pt-4 border-t border-slate-100 space-y-3">
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                    <span>Kemajuan Tugas</span>
                                    <span class="font-bold text-slate-900">{{ project.progress_percentage }}% ({{ project.completed_tasks_count }}/{{ project.tasks_count }})</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                    <div
                                        class="h-full bg-indigo-600 rounded-full transition-all duration-300"
                                        :style="{ width: `${project.progress_percentage}%` }"
                                    ></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>Pembuat: <strong>{{ project.user?.name }}</strong></span>
                                <span>Batas: {{ project.due_date ? new Date(project.due_date).toLocaleDateString('id-ID') : '-' }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-2 pt-2">
                                <Link
                                    :href="route('projects.show', project.id)"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-lg bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition"
                                >
                                    <span>Buka Board Tugas</span>
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </Link>
                                <button
                                    type="button"
                                    @click="confirmDelete(project)"
                                    class="rounded-lg p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                    title="Hapus Proyek"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-base font-bold text-slate-900">Belum ada proyek ditemukan</h3>
                    <p class="mt-1 text-xs text-slate-500">Mulai dengan membuat proyek baru untuk kelompok belajar atau tugas akhir Anda.</p>
                    <button
                        type="button"
                        @click="openCreateModal"
                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-700 transition"
                    >
                        <span>Buat Proyek Pertama</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Proyek -->
        <Modal :show="showCreateModal" @close="closeCreateModal" max-width="lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Tambah Proyek Baru
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Isi informasi proyek tugas akhir atau mata kuliah kelompok Anda.
                </p>

                <form @submit.prevent="submitProject" class="mt-6 space-y-4">
                    <div>
                        <InputLabel for="title" value="Judul Proyek" />
                        <TextInput
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Contoh: Sistem Informasi Tugas Akhir"
                            required
                        />
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="course_name" value="Mata Kuliah / Kategori" />
                        <TextInput
                            id="course_name"
                            v-model="form.course_name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Contoh: Proyek Perangkat Lunak"
                        />
                        <InputError :message="form.errors.course_name" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="status" value="Status Proyek" />
                            <select
                                id="status"
                                v-model="form.status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="planning">Perencanaan</option>
                                <option value="in_progress">Sedang Berjalan</option>
                                <option value="completed">Selesai</option>
                                <option value="on_hold">Ditunda</option>
                            </select>
                            <InputError :message="form.errors.status" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="due_date" value="Target Selesai (Deadline)" />
                            <TextInput
                                id="due_date"
                                v-model="form.due_date"
                                type="date"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.due_date" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="description" value="Deskripsi / Ruang Lingkup Proyek" />
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="Jelaskan ringkasan tujuan, sasaran, atau permasalahan proyek..."
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <SecondaryButton type="button" @click="closeCreateModal">
                            Batal
                        </SecondaryButton>
                        <PrimaryButton :disabled="form.processing">
                            Simpan Proyek
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Modal Konfirmasi Hapus -->
        <Modal :show="showDeleteModal" @close="closeDeleteModal" max-width="md">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Konfirmasi Hapus Proyek
                </h3>
                <p class="text-sm text-slate-500 mt-2">
                    Apakah Anda yakin ingin menghapus proyek <strong>"{{ projectToDelete?.title }}"</strong>? Semua tugas di dalamnya juga akan terhapus secara permanen.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="closeDeleteModal">Batal</SecondaryButton>
                    <DangerButton @click="deleteProject">Hapus Permanen</DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
