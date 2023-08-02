<?php

namespace Tests\Feature\TaskController;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Task;

/**
 * ClassNameTest
 * @group group
 */
class TaskControllerDestroyTest extends TestCase
{
    /** @test */
    public function test_can_destroy_created_task()
    {
        $task = Task::factory()->create();
        Sanctum::actingAs($task->creator);

        $route = route('tasks.destroy', $task);
        $response = $this->deleteJson($route);

        $response->assertNoContent();

        $this->assertDatabaseMissing('tasks', $task->toArray());

    }




}