<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request)
    {

        $validated = $request->validate();
        $project = Auth::user()->projects()->create($validated);

        return new ProjectResource($project);
    }

    public function show(Request $request, Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validate();

        $project->update($validated);



        return new ProjectResource($project);
    }
}