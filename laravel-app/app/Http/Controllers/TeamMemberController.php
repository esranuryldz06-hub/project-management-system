<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('team-members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $validated['user_id'] = Auth::id();

        TeamMember::create($validated);

        return redirect('/team-members')
            ->with('success', 'Team member added successfully!');
    }

    public function edit($id)
    {
        $teamMember = TeamMember::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('team-members.edit', compact('teamMember'));
    }

    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::where('user_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $teamMember->update($validated);

        return redirect('/team-members')
            ->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        $teamMember = TeamMember::where('user_id', Auth::id())
            ->findOrFail($id);

        $teamMember->delete();

        return redirect('/team-members')
            ->with('success', 'Team member deleted successfully!');
    }
}
