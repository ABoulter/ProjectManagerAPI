<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\TaskCollection;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    public function index(Request $request)
    {

        $tasks = QueryBuilder::for (Task::class)->allowedFilters([
            'is_done',
            'scheduled_at',
            'due_at',
            AllowedFilter::scope('scheduled_between'),
            AllowedFilter::scope('due_between'),
        ])->defaultSort('-created_at')->allowedSorts(['title', 'is_done', 'created_at'])->paginate();
        return new TaskCollection($tasks);
    }

    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Auth::user()->tasks()->create($validated);
        return new TaskResource($task);
    }
    public function update(updateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return new TaskResource($task);
    }
    public function destroy(updateTaskRequest $request, Task $task)
    {
        $task->delete();

        return response()->noContent();
    }

}