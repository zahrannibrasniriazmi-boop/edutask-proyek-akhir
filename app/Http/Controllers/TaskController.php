<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task under a project.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,completed',
            'assigned_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $project->tasks()->create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back()->with('message', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Update the specified task (supports inline status change or editing).
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|required|in:low,medium,high,urgent',
            'status' => 'sometimes|required|in:todo,in_progress,review,completed',
            'assigned_name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->back()->with('message', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('message', 'Tugas berhasil dihapus!');
    }
}
