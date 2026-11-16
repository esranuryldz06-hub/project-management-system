<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
            ->orWhereHas('teamMembers', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'done_jobs' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
        ]);

        $teamMemberIds = $validated['team_members'] ?? [];

        unset($validated['team_members']);

        $validated['user_id'] = Auth::id();

        $project = Project::create($validated);

        $project->teamMembers()->sync($teamMemberIds);

        return redirect('/projects')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $isManager = $project->user_id === Auth::id();

        $isMember = $project->teamMembers()
            ->where('users.id', Auth::id())
            ->exists();

        abort_unless($isManager || $isMember, 403);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $isManager = $project->user_id === Auth::id();

        $isMember = $project->teamMembers()
            ->where('users.id', Auth::id())
            ->exists();

        abort_unless($isManager || $isMember, 403);

        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('projects.edit', compact(
            'project',
            'users',
            'isManager'
        ));
    }

    public function update(Request $request, Project $project)
    {
        $isManager = $project->user_id === Auth::id();

        $isMember = $project->teamMembers()
            ->where('users.id', Auth::id())
            ->exists();

        abort_unless($isManager || $isMember, 403);

        // Team members can only update done_jobs.
        if (!$isManager) {
            $validated = $request->validate([
                'done_jobs' => 'required|integer|min:0',
            ]);

            $project->update($validated);

            return redirect('/projects')
                ->with('success', 'Completed jobs updated successfully!');
        }

        // Project managers can update all project information.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'done_jobs' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
        ]);

        $teamMemberIds = $validated['team_members'] ?? [];

        unset($validated['team_members']);

        $project->update($validated);

        $project->teamMembers()->sync($teamMemberIds);

        return redirect('/projects')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);

        $project->delete();

        return redirect('/projects')
            ->with('success', 'Project deleted successfully!');
    }
}
