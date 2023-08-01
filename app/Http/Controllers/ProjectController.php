<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCollection;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    public function index(Request $request)
    {
        $projects = QueryBuilder::for (Project::class)->AllowedIncludes('tasks')->paginate();
        return new ProjectCollection($projects);
    }
    public function store(StoreProjectRequest $request)
    {

        $validated = $request->validate();
        $project = Auth::user()->projects()->create($validated);

        return new ProjectResource($project);
    }

    public function show(Request $request, Project $project)
    {
        return (new ProjectResource($project))->load('tasks')->load('members');
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validate();

        $project->update($validated);



        return new ProjectResource($project);
    }

    public function destroy(Request $request, Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}