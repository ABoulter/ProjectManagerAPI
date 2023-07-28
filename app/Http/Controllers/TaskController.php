<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return new TaskCollection(Task::all());
    }

    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create($validated);
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