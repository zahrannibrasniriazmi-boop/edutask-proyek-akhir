<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Project::with(['user', 'tasks'])
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $projects = $query->paginate(9)->withQueryString();

        $stats = [
            'total_projects' => Project::count(),
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
        ];

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'filters' => [
                'search' => $search,
                'status' => $status ?? 'all',
            ],
            'stats' => $stats,
        ]);
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'due_date' => 'nullable|date',
        ]);

        $project = $request->user()->projects()->create($validated);

        return redirect()->route('projects.show', $project->id)
            ->with('message', 'Proyek berhasil dibuat!');
    }

    /**
     * Display the specified project and its task board.
     */
    public function show(Project $project): Response
    {
        $project->load(['user', 'tasks' => function ($query) {
            $query->latest();
        }]);

        $tasks = $project->tasks;

        $taskStats = [
            'total' => $tasks->count(),
            'todo' => $tasks->where('status', 'todo')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'review' => $tasks->where('status', 'review')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'tasks' => $tasks,
            'taskStats' => $taskStats,
        ]);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'due_date' => 'nullable|date',
        ]);

        $project->update($validated);

        return redirect()->back()->with('message', 'Proyek berhasil diperbarui!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('message', 'Proyek berhasil dihapus!');
    }
}
