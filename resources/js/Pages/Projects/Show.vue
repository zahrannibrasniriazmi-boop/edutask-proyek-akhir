<script setup>
import { ref, computed } from 'vue';
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
    project: Object,
    tasks: Array,
    taskStats: Object,
});

const showCreateTaskModal = ref(false);
const showEditProjectModal = ref(false);
const showDeleteTaskModal = ref(false);
const taskToDelete = ref(null);

// Forms
const taskForm = useForm({
    title: '',
    description: '',
    priority: 'medium',
    status: 'todo',
    assigned_name: '',
    due_date: '',
});

const editProjectForm = useForm({
    title: props.project.title,
    course_name: props.project.course_name || '',
    description: props.project.description || '',
    status: props.project.status,
    due_date: props.project.due_date ? props.project.due_date.substring(0, 10) : '',
});

// Group tasks by status for Kanban Board
const tasksByStatus = computed(() => {
    return {
        todo: props.tasks.filter((t) => t.status === 'todo'),
        in_progress: props.tasks.filter((t) => t.status === 'in_progress'),
        review: props.tasks.filter((t) => t.status === 'review'),
        completed: props.tasks.filter((t) => t.status === 'completed'),
    };
});

const openCreateTaskModal = (initialStatus = 'todo') => {
    taskForm.reset();
    taskForm.status = initialStatus;
    showCreateTaskModal.value = true;
};

const closeCreateTaskModal = () => {
    showCreateTaskModal.value = false;
    taskForm.reset();
};

const submitTask = () => {
    taskForm.post(route('projects.tasks.store', props.project.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeCreateTaskModal();
        },
    });
};

const openEditProjectModal = () => {
    showEditProjectModal.value = true;
};

const closeEditProjectModal = () => {
    showEditProjectModal.value = false;
};

const updateProject = () => {
    editProjectForm.patch(route('projects.update', props.project.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeEditProjectModal();
        },
    });
};

const changeTaskStatus = (task, newStatus) => {
    if (task.status === newStatus) return;
    router.patch(
        route('tasks.update', task.id),
        { status: newStatus },
        { preserveScroll: true }
    );
};

const confirmDeleteTask = (task) => {
    taskToDelete.value = task;
    showDeleteTaskModal.value = true;
};

const closeDeleteTaskModal = () => {
    showDeleteTaskModal.value = false;
    taskToDelete.value = null;
};

const deleteTask = () => {
    if (!taskToDelete.value) return;
    router.delete(route('tasks.destroy', taskToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeDeleteTaskModal();
        },
    });
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
    <Head :title="project.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-4">
                <!-- Navigation Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <Link :href="route('projects.index')" class="hover:text-indigo-600 flex items-center gap-1">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Semua Proyek</span>
                    </Link>
                    <span>/</span>
                    <span class="text-slate-800 font-semibold truncate">{{ project.title }}</span>
                </div>

                <!-- Title & Actions Bar -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
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
                        <h2 class="text-2xl font-bold leading-tight text-slate-900">
                            {{ project.title }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Dibuat oleh <span class="font-semibold text-slate-700">{{ project.user?.name }}</span> • Target Selesai:
                            <span class="font-semibold text-slate-700">{{ project.due_date ? new Date(project.due_date).toLocaleDateString('id-ID') : 'Belum ditentukan' }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <button
                            type="button"
                            @click="openEditProjectModal"
                            class="rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition"
                        >
                            Edit Info Proyek
                        </button>
                        <button
                            type="button"
                            @click="openCreateTaskModal('todo')"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah Tugas Baru</span>
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
                <!-- Project Progress Summary Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-2xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 mb-1">Kemajuan Pengerjaan Proyek</p>
                            <div class="flex items-center gap-3">
                                <div class="h-3 flex-1 rounded-full bg-slate-100 overflow-hidden">
                                    <div
                                        class="h-full bg-indigo-600 rounded-full transition-all duration-300"
                                        :style="{ width: `${project.progress_percentage}%` }"
                                    ></div>
                                </div>
                                <span class="text-sm font-bold text-slate-900 shrink-0">
                                    {{ project.progress_percentage }}%
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 text-xs shrink-0 border-t sm:border-t-0 sm:border-l border-slate-100 pt-3 sm:pt-0 sm:pl-6">
                            <div>
                                <span class="text-slate-400 block">Total Tugas</span>
                                <span class="font-bold text-slate-900 text-sm">{{ taskStats.total }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Selesai</span>
                                <span class="font-bold text-emerald-600 text-sm">{{ taskStats.completed }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Tersisa</span>
                                <span class="font-bold text-amber-600 text-sm">{{ taskStats.total - taskStats.completed }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="project.description" class="mt-3 pt-3 border-t border-slate-100 text-xs text-slate-600 leading-relaxed">
                        <span class="font-semibold text-slate-700">Deskripsi:</span> {{ project.description }}
                    </div>
                </div>

                <!-- Interactive Kanban Board (4 Columns) -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span>Papan Tugas Tim (Task Board)</span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600">
                                {{ tasks.length }} Tugas
                            </span>
                        </h3>
                        <p class="text-xs text-slate-400 hidden sm:block">
                            Ubah status tugas langsung melalui dropdown di setiap kartu tugas.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Column 1: To Do -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-700">To Do</h4>
                                    <span class="rounded bg-white px-1.5 py-0.5 text-xs font-bold text-slate-600 border border-slate-200">
                                        {{ tasksByStatus.todo.length }}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    @click="openCreateTaskModal('todo')"
                                    class="text-slate-400 hover:text-indigo-600"
                                    title="Tambah tugas di To Do"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3 flex-1 overflow-y-auto">
                                <div
                                    v-for="task in tasksByStatus.todo"
                                    :key="task.id"
                                    class="rounded-lg border border-slate-200 bg-white p-3.5 shadow-2xs hover:border-indigo-300 transition"
                                >
                                    <div class="flex items-start justify-between gap-1">
                                        <span
                                            class="inline-flex items-center rounded border px-1.5 py-0.5 text-2xs font-semibold"
                                            :class="priorityBadge(task.priority).class"
                                        >
                                            {{ priorityBadge(task.priority).label }}
                                        </span>
                                        <button
                                            type="button"
                                            @click="confirmDeleteTask(task)"
                                            class="text-slate-300 hover:text-rose-500"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <h5 class="mt-2 text-xs font-bold text-slate-900 leading-snug">
                                        {{ task.title }}
                                    </h5>
                                    <p v-if="task.description" class="mt-1 text-2xs text-slate-500 line-clamp-2">
                                        {{ task.description }}
                                    </p>

                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                                        <span class="inline-flex items-center gap-1 font-medium text-slate-700">
                                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ task.assigned_name || 'Umum' }}
                                        </span>
                                        <span v-if="task.due_date" class="text-slate-400">
                                            {{ new Date(task.due_date).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' }) }}
                                        </span>
                                    </div>

                                    <!-- Quick Status Switcher -->
                                    <div class="mt-2.5">
                                        <select
                                            :value="task.status"
                                            @change="changeTaskStatus(task, $event.target.value)"
                                            class="w-full rounded border-slate-200 py-1 pl-2 pr-6 text-2xs font-medium text-slate-700 bg-slate-50 focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            <option value="todo">Pindahkan ke: To Do</option>
                                            <option value="in_progress">Pindahkan ke: In Progress</option>
                                            <option value="review">Pindahkan ke: Review</option>
                                            <option value="completed">Pindahkan ke: Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="tasksByStatus.todo.length === 0" class="py-6 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-lg">
                                    Tidak ada tugas To Do
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: In Progress -->
                        <div class="rounded-xl border border-blue-200 bg-blue-50/40 p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-3 border-b border-blue-200 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-blue-900">In Progress</h4>
                                    <span class="rounded bg-white px-1.5 py-0.5 text-xs font-bold text-blue-700 border border-blue-200">
                                        {{ tasksByStatus.in_progress.length }}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    @click="openCreateTaskModal('in_progress')"
                                    class="text-blue-400 hover:text-blue-700"
                                    title="Tambah tugas di In Progress"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3 flex-1 overflow-y-auto">
                                <div
                                    v-for="task in tasksByStatus.in_progress"
                                    :key="task.id"
                                    class="rounded-lg border border-slate-200 bg-white p-3.5 shadow-2xs hover:border-blue-300 transition"
                                >
                                    <div class="flex items-start justify-between gap-1">
                                        <span
                                            class="inline-flex items-center rounded border px-1.5 py-0.5 text-2xs font-semibold"
                                            :class="priorityBadge(task.priority).class"
                                        >
                                            {{ priorityBadge(task.priority).label }}
                                        </span>
                                        <button
                                            type="button"
                                            @click="confirmDeleteTask(task)"
                                            class="text-slate-300 hover:text-rose-500"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <h5 class="mt-2 text-xs font-bold text-slate-900 leading-snug">
                                        {{ task.title }}
                                    </h5>
                                    <p v-if="task.description" class="mt-1 text-2xs text-slate-500 line-clamp-2">
                                        {{ task.description }}
                                    </p>

                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                                        <span class="inline-flex items-center gap-1 font-medium text-slate-700">
                                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ task.assigned_name || 'Umum' }}
                                        </span>
                                        <span v-if="task.due_date" class="text-slate-400">
                                            {{ new Date(task.due_date).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' }) }}
                                        </span>
                                    </div>

                                    <!-- Quick Status Switcher -->
                                    <div class="mt-2.5">
                                        <select
                                            :value="task.status"
                                            @change="changeTaskStatus(task, $event.target.value)"
                                            class="w-full rounded border-slate-200 py-1 pl-2 pr-6 text-2xs font-medium text-slate-700 bg-slate-50 focus:border-blue-500 focus:ring-blue-500"
                                        >
                                            <option value="todo">Pindahkan ke: To Do</option>
                                            <option value="in_progress">Pindahkan ke: In Progress</option>
                                            <option value="review">Pindahkan ke: Review</option>
                                            <option value="completed">Pindahkan ke: Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="tasksByStatus.in_progress.length === 0" class="py-6 text-center text-xs text-blue-400 border border-dashed border-blue-200 rounded-lg">
                                    Tidak ada tugas In Progress
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Review -->
                        <div class="rounded-xl border border-purple-200 bg-purple-50/40 p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-3 border-b border-purple-200 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-purple-500"></span>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-purple-900">Review</h4>
                                    <span class="rounded bg-white px-1.5 py-0.5 text-xs font-bold text-purple-700 border border-purple-200">
                                        {{ tasksByStatus.review.length }}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    @click="openCreateTaskModal('review')"
                                    class="text-purple-400 hover:text-purple-700"
                                    title="Tambah tugas di Review"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3 flex-1 overflow-y-auto">
                                <div
                                    v-for="task in tasksByStatus.review"
                                    :key="task.id"
                                    class="rounded-lg border border-slate-200 bg-white p-3.5 shadow-2xs hover:border-purple-300 transition"
                                >
                                    <div class="flex items-start justify-between gap-1">
                                        <span
                                            class="inline-flex items-center rounded border px-1.5 py-0.5 text-2xs font-semibold"
                                            :class="priorityBadge(task.priority).class"
                                        >
                                            {{ priorityBadge(task.priority).label }}
                                        </span>
                                        <button
                                            type="button"
                                            @click="confirmDeleteTask(task)"
                                            class="text-slate-300 hover:text-rose-500"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <h5 class="mt-2 text-xs font-bold text-slate-900 leading-snug">
                                        {{ task.title }}
                                    </h5>
                                    <p v-if="task.description" class="mt-1 text-2xs text-slate-500 line-clamp-2">
                                        {{ task.description }}
                                    </p>

                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                                        <span class="inline-flex items-center gap-1 font-medium text-slate-700">
                                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ task.assigned_name || 'Umum' }}
                                        </span>
                                        <span v-if="task.due_date" class="text-slate-400">
                                            {{ new Date(task.due_date).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' }) }}
                                        </span>
                                    </div>

                                    <!-- Quick Status Switcher -->
                                    <div class="mt-2.5">
                                        <select
                                            :value="task.status"
                                            @change="changeTaskStatus(task, $event.target.value)"
                                            class="w-full rounded border-slate-200 py-1 pl-2 pr-6 text-2xs font-medium text-slate-700 bg-slate-50 focus:border-purple-500 focus:ring-purple-500"
                                        >
                                            <option value="todo">Pindahkan ke: To Do</option>
                                            <option value="in_progress">Pindahkan ke: In Progress</option>
                                            <option value="review">Pindahkan ke: Review</option>
                                            <option value="completed">Pindahkan ke: Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="tasksByStatus.review.length === 0" class="py-6 text-center text-xs text-purple-400 border border-dashed border-purple-200 rounded-lg">
                                    Tidak ada tugas Review
                                </div>
                            </div>
                        </div>

                        <!-- Column 4: Completed -->
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50/40 p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-3 border-b border-emerald-200 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-emerald-900">Selesai</h4>
                                    <span class="rounded bg-white px-1.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        {{ tasksByStatus.completed.length }}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    @click="openCreateTaskModal('completed')"
                                    class="text-emerald-400 hover:text-emerald-700"
                                    title="Tambah tugas Selesai"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-3 flex-1 overflow-y-auto">
                                <div
                                    v-for="task in tasksByStatus.completed"
                                    :key="task.id"
                                    class="rounded-lg border border-slate-200 bg-white p-3.5 shadow-2xs hover:border-emerald-300 transition opacity-90"
                                >
                                    <div class="flex items-start justify-between gap-1">
                                        <span
                                            class="inline-flex items-center rounded border px-1.5 py-0.5 text-2xs font-semibold"
                                            :class="priorityBadge(task.priority).class"
                                        >
                                            {{ priorityBadge(task.priority).label }}
                                        </span>
                                        <button
                                            type="button"
                                            @click="confirmDeleteTask(task)"
                                            class="text-slate-300 hover:text-rose-500"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <h5 class="mt-2 text-xs font-bold text-slate-900 line-through text-slate-400 leading-snug">
                                        {{ task.title }}
                                    </h5>
                                    <p v-if="task.description" class="mt-1 text-2xs text-slate-400 line-clamp-2">
                                        {{ task.description }}
                                    </p>

                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-2xs text-slate-500">
                                        <span class="inline-flex items-center gap-1 font-medium text-slate-700">
                                            <svg class="h-3 w-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ task.assigned_name || 'Umum' }}
                                        </span>
                                        <span v-if="task.due_date" class="text-slate-400">
                                            {{ new Date(task.due_date).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' }) }}
                                        </span>
                                    </div>

                                    <!-- Quick Status Switcher -->
                                    <div class="mt-2.5">
                                        <select
                                            :value="task.status"
                                            @change="changeTaskStatus(task, $event.target.value)"
                                            class="w-full rounded border-slate-200 py-1 pl-2 pr-6 text-2xs font-medium text-slate-700 bg-slate-50 focus:border-emerald-500 focus:ring-emerald-500"
                                        >
                                            <option value="todo">Pindahkan ke: To Do</option>
                                            <option value="in_progress">Pindahkan ke: In Progress</option>
                                            <option value="review">Pindahkan ke: Review</option>
                                            <option value="completed">Pindahkan ke: Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="tasksByStatus.completed.length === 0" class="py-6 text-center text-xs text-emerald-400 border border-dashed border-emerald-200 rounded-lg">
                                    Belum ada tugas selesai
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Tugas Baru -->
        <Modal :show="showCreateTaskModal" @close="closeCreateTaskModal" max-width="lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Tambah Tugas Baru
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Tambahkan rincian pekerjaan atau task untuk proyek <span class="font-semibold text-slate-700">"{{ project.title }}"</span>.
                </p>

                <form @submit.prevent="submitTask" class="mt-6 space-y-4">
                    <div>
                        <InputLabel for="task_title" value="Judul Tugas" />
                        <TextInput
                            id="task_title"
                            v-model="taskForm.title"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Contoh: Membuat Wireframe UI/UX di Figma"
                            required
                        />
                        <InputError :message="taskForm.errors.title" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="assigned_name" value="Penanggung Jawab" />
                            <TextInput
                                id="assigned_name"
                                v-model="taskForm.assigned_name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Contoh: Budi Santoso"
                            />
                            <InputError :message="taskForm.errors.assigned_name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="task_due_date" value="Batas Waktu (Deadline)" />
                            <TextInput
                                id="task_due_date"
                                v-model="taskForm.due_date"
                                type="date"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="taskForm.errors.due_date" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="priority" value="Tingkat Prioritas" />
                            <select
                                id="priority"
                                v-model="taskForm.priority"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="low">Rendah (Low)</option>
                                <option value="medium">Sedang (Medium)</option>
                                <option value="high">Tinggi (High)</option>
                                <option value="urgent">Mendesak (Urgent)</option>
                            </select>
                            <InputError :message="taskForm.errors.priority" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="task_status" value="Status Papan Awal" />
                            <select
                                id="task_status"
                                v-model="taskForm.status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="todo">To Do (Belum Dimulai)</option>
                                <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                                <option value="review">Review (Pemeriksaan)</option>
                                <option value="completed">Selesai (Completed)</option>
                            </select>
                            <InputError :message="taskForm.errors.status" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="task_description" value="Deskripsi / Catatan Tugas" />
                        <textarea
                            id="task_description"
                            v-model="taskForm.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="Rincian spesifikasi, instruksi, atau kriteria penyelesaian tugas..."
                        ></textarea>
                        <InputError :message="taskForm.errors.description" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <SecondaryButton type="button" @click="closeCreateTaskModal">
                            Batal
                        </SecondaryButton>
                        <PrimaryButton :disabled="taskForm.processing">
                            Simpan Tugas
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Modal Edit Proyek -->
        <Modal :show="showEditProjectModal" @close="closeEditProjectModal" max-width="lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Edit Informasi Proyek
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Perbarui judul, mata kuliah, status, atau tenggat waktu proyek.
                </p>

                <form @submit.prevent="updateProject" class="mt-6 space-y-4">
                    <div>
                        <InputLabel for="edit_title" value="Judul Proyek" />
                        <TextInput
                            id="edit_title"
                            v-model="editProjectForm.title"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="editProjectForm.errors.title" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit_course" value="Mata Kuliah / Kategori" />
                        <TextInput
                            id="edit_course"
                            v-model="editProjectForm.course_name"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="editProjectForm.errors.course_name" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="edit_status" value="Status Proyek" />
                            <select
                                id="edit_status"
                                v-model="editProjectForm.status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="planning">Perencanaan</option>
                                <option value="in_progress">Sedang Berjalan</option>
                                <option value="completed">Selesai</option>
                                <option value="on_hold">Ditunda</option>
                            </select>
                            <InputError :message="editProjectForm.errors.status" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="edit_due_date" value="Target Selesai (Deadline)" />
                            <TextInput
                                id="edit_due_date"
                                v-model="editProjectForm.due_date"
                                type="date"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="editProjectForm.errors.due_date" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="edit_desc" value="Deskripsi / Ruang Lingkup" />
                        <textarea
                            id="edit_desc"
                            v-model="editProjectForm.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        ></textarea>
                        <InputError :message="editProjectForm.errors.description" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <SecondaryButton type="button" @click="closeEditProjectModal">
                            Batal
                        </SecondaryButton>
                        <PrimaryButton :disabled="editProjectForm.processing">
                            Perbarui Proyek
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Modal Konfirmasi Hapus Tugas -->
        <Modal :show="showDeleteTaskModal" @close="closeDeleteTaskModal" max-width="sm">
            <div class="p-6">
                <h3 class="text-base font-bold text-slate-900">
                    Hapus Tugas
                </h3>
                <p class="text-xs text-slate-500 mt-2">
                    Apakah Anda yakin ingin menghapus tugas <strong>"{{ taskToDelete?.title }}"</strong>? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="mt-6 flex justify-end gap-2.5">
                    <SecondaryButton @click="closeDeleteTaskModal">Batal</SecondaryButton>
                    <DangerButton @click="deleteTask">Hapus</DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
