<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // Show all submissions by this student
    public function index()
    {
        $projects = Project::where('student_id', auth()->id())
            ->with(['supervisor', 'department'])
            ->latest()
            ->get();

        return view('student.projects.index', compact('projects'));
    }

    // Show submission form
    public function create()
    {
        $supervisors = User::where('role', 'supervisor')
            ->where('department_id', auth()->user()->department_id)
            ->orderBy('name')
            ->get();

        return view('student.projects.create', compact('supervisors'));
    }

    // Store submission
    public function store(StoreProjectRequest $request)
    {
        // Check: student can only have one approved or pending project
        $existing = Project::where('student_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existing) {
            return back()->with('error',
                'You already have an active project submission.');
        }

        // Handle PDF upload
        $filePath = $request->file('project_file')
            ->store('projects', 'private');

        // Create project
        $project = Project::create([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'year' => $request->year,
            'keywords' => $request->keywords,
            'file_path' => $filePath,
            'student_id' => auth()->id(),
            'supervisor_id' => $request->supervisor_id,
            'department_id' => auth()->user()->department_id,
            'status' => 'pending',
        ]);

        ActivityLog::log('Submitted project', $project->title);

        return redirect()->route('student.projects.index')
            ->with('success', 'Project submitted successfully! Awaiting supervisor review.');
    }

    // View single project detail
    public function show(Project $project)
    {
        // Students can only view their own projects
        if ($project->student_id !== auth()->id()) {
            abort(403);
        }

        $project->load(['supervisor', 'department', 'comments.user']);

        return view('student.projects.show', compact('project'));
    }

    // Download the PDF
    public function download(Project $project)
    {
        if ($project->student_id !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('private')->download(
            $project->file_path,
            str()->slug($project->title).'.pdf'
        );
    }
}
