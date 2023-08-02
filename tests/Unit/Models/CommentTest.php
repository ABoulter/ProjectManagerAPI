<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

/**
 * ClassNameTest
 * @group group
 */
class CommentTest extends TestCase
{
    /** @test */
    public function test_tasks_can_have_comments(): void
    {

        $task = Task::factory()->create();

        $comment = $task->comments()->make([
            'content' => 'Task comment'
        ]);

        $comment->user()->associate($task->creator);

        $comment->save();

        $this->assertModelExists($comment);

    }
    public function test_projects_can_have_comments(): void
    {

        $project = Project::factory()->create();

        $comment = $project->comments()->make([
            'content' => 'Task comment'
        ]);

        $comment->user()->associate($project->creator);

        $comment->save();

        $this->assertModelExists($comment);

    }

}