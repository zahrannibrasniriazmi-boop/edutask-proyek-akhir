<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_projects_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.index'));

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_a_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'title' => 'Sistem Informasi Kampus',
            'course_name' => 'Proyek Perangkat Lunak',
            'description' => 'Aplikasi kolaborasi',
            'status' => 'in_progress',
            'due_date' => now()->addDays(14)->toDateString(),
        ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'Sistem Informasi Kampus',
            'user_id' => $user->id,
        ]);

        $project = Project::where('title', 'Sistem Informasi Kampus')->first();
        $response->assertRedirect(route('projects.show', $project->id));
    }

    public function test_authenticated_user_can_view_project_show(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'title' => 'Project Alpha',
        ]);

        $response = $this->actingAs($user)->get(route('projects.show', $project->id));

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_task_under_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('projects.tasks.store', $project->id), [
            'title' => 'Setup Frontend Vue',
            'description' => 'Konfigurasi Inertia dan Tailwind',
            'priority' => 'high',
            'status' => 'todo',
            'assigned_name' => 'Budi Santoso',
            'due_date' => now()->addDays(5)->toDateString(),
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Setup Frontend Vue',
            'project_id' => $project->id,
            'status' => 'todo',
        ]);

        $response->assertSessionHas('message');
    }

    public function test_authenticated_user_can_update_task_status(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'status' => 'todo',
        ]);

        $response = $this->actingAs($user)->patch(route('tasks.update', $task->id), [
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed',
        ]);
    }
}
