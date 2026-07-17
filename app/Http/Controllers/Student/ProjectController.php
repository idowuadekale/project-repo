<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary)
    {
    }

    public function index(Request $request)
    {
        $query = Project::where('student_id', auth()->id())
            ->with(['supervisor', 'department'])
            ->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate(10)->withQueryString();

        return view('student.projects.index', compact('projects'));
    }

    public function create()
    {
        $supervisors = User::where('role', 'supervisor')
            ->where('department_id', auth()->user()->department_id)
            ->orderBy('name')
            ->get();

        return view('student.projects.create', compact('supervisors'));
    }

    public function store(StoreProjectRequest $request)
    {
        // One active project rule
        $existing = Project::where('student_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existing) {
            return back()->with('error',
                'You already have an active submission. Wait for a decision before submitting again.');
        }

        // Generate a clean public_id for Cloudinary
        $publicId = 'proj_'.auth()->id().'_'.time();

        // Upload PDF to Cloudinary
        $uploaded = $this->cloudinary->uploadPdf(
            $request->file('project_file')->getRealPath(),
            $publicId
        );

        $project = Project::create([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'year' => $request->year,
            'keywords' => $request->keywords,
            'file_path' => $uploaded['url'],
            'file_public_id' => $uploaded['public_id'],
            'student_id' => auth()->id(),
            'supervisor_id' => $request->supervisor_id,
            'department_id' => auth()->user()->department_id,
            'status' => 'pending',
        ]);

        ActivityLog::log('Submitted project', $project->title);

        return redirect()->route('student.projects.index')
            ->with('success', 'Project submitted successfully. Awaiting supervisor review.');
    }

    public function show(Project $project)
    {
        if ($project->student_id !== auth()->id()) {
            abort(403);
        }

        $project->load(['supervisor', 'department', 'comments.user']);

        return view('student.projects.show', compact('project'));
    }

    /**
     * Download — redirect to Cloudinary URL directly.
     * No local disk needed. Vercel-safe.
     */
    public function download(Project $project)
    {
        $user = auth()->user();

        $canDownload = $project->student_id === $user->id
                    || $project->supervisor_id === $user->id
                    || $user->isAdmin();

        if (!$canDownload) {
            abort(403);
        }

        if (!$project->file_path) {
            return back()->with('error', 'No file attached to this project.');
        }

        return $this->streamDownload($project);
    }

    private function streamDownload(Project $project): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        // Build a clean filename from the project title
        $filename = \Str::slug($project->title).'.pdf';

        // Fetch the file content from Cloudinary
        $fileContent = file_get_contents($project->file_path);

        if ($fileContent === false) {
            return back()->with('error', 'Could not retrieve file. Please try again.');
        }

        return response()->streamDownload(
            function () use ($fileContent) {
                echo $fileContent;
            },
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                'Content-Length' => strlen($fileContent),
            ]
        );
    }
}
