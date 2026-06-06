<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // All projects assigned to this supervisor
    public function index(Request $request)
    {
        $query = Project::where('supervisor_id', auth()->id())
            ->with(['student', 'department'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->get();

        $stats = [
            'total' => Project::where('supervisor_id', auth()->id())->count(),
            'pending' => Project::where('supervisor_id', auth()->id())->where('status', 'pending')->count(),
            'approved' => Project::where('supervisor_id', auth()->id())->where('status', 'approved')->count(),
            'rejected' => Project::where('supervisor_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('supervisor.projects.index', compact('projects', 'stats'));
    }

    // Single project detail + comment form
    public function show(Project $project)
    {
        // Only the assigned supervisor can view
        if ($project->supervisor_id !== auth()->id()) {
            abort(403);
        }

        $project->load(['student', 'department', 'comments.user']);

        return view('supervisor.projects.show', compact('project'));
    }

    // Approve a project
    public function approve(Project $project)
    {
        if ($project->supervisor_id !== auth()->id()) {
            abort(403);
        }

        if (!$project->isPending()) {
            return back()->with('error', 'Only pending projects can be approved.');
        }

        $project->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        ActivityLog::log('Approved project', $project->title);

        return back()->with('success', "Project \"{$project->title}\" has been approved.");
    }

    // Reject a project with a reason
    public function reject(Request $request, Project $project)
    {
        if ($project->supervisor_id !== auth()->id()) {
            abort(403);
        }

        if (!$project->isPending()) {
            return back()->with('error', 'Only pending projects can be rejected.');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $project->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        ActivityLog::log('Rejected project', $project->title);

        return back()->with('success', "Project \"{$project->title}\" has been rejected.");
    }

    // Leave a comment on a project
    public function comment(Request $request, Project $project)
    {
        if ($project->supervisor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        Comment::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        ActivityLog::log('Commented on project', $project->title);

        return back()->with('success', 'Comment posted.');
    }

    // Revert rejection back to pending (optional re-review)
    public function revert(Project $project)
    {
        if ($project->supervisor_id !== auth()->id()) {
            abort(403);
        }

        $project->update([
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        ActivityLog::log('Reverted project to pending', $project->title);

        return back()->with('success', 'Project reverted to pending for re-review.');
    }
}
