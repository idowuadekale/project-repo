<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // List all projects
    public function index(Request $request)
    {
        $query = Project::with(['student', 'supervisor', 'department'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('keywords', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $projects = $query->paginate(15);

        $years = Project::selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.projects.index', compact('projects', 'years'));
    }

    // View single project
    public function show(Project $project)
    {
        $project->load(['student', 'supervisor', 'department', 'comments.user']);
        $supervisors = User::where('role', 'supervisor')
            ->where('department_id', $project->department_id)
            ->get();

        return view('admin.projects.show', compact('project', 'supervisors'));
    }

    // Reassign supervisor
    public function assignSupervisor(Request $request, Project $project)
    {
        $request->validate([
            'supervisor_id' => ['required', 'exists:users,id'],
        ]);

        $project->update(['supervisor_id' => $request->supervisor_id]);

        ActivityLog::log('Reassigned supervisor', $project->title);

        return back()->with('success', 'Supervisor reassigned successfully.');
    }

    // Force approve (admin override)
    public function approve(Project $project)
    {
        $project->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        ActivityLog::log('Admin approved project', $project->title);

        return back()->with('success', 'Project approved.');
    }

    // Force reject
    public function reject(Request $request, Project $project)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10'],
        ]);

        $project->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        ActivityLog::log('Admin rejected project', $project->title);

        return back()->with('success', 'Project rejected.');
    }

    // Delete project + its file
    public function destroy(Project $project)
    {
        if ($project->file_path) {
            Storage::disk('private')->delete($project->file_path);
        }

        $title = $project->title;
        $project->delete();

        ActivityLog::log('Deleted project', $title);

        return back()->with('success', "Project \"{$title}\" deleted.");
    }

    // Activity log view
    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('action', 'like', '%'.$request->search.'%')
                  ->orWhere('subject', 'like', '%'.$request->search.'%');
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('admin.activity', compact('logs'));
    }

    // Download PDF
    public function download(Project $project)
    {
        return Storage::disk('private')->download(
            $project->file_path,
            str()->slug($project->title).'.pdf'
        );
    }
}
