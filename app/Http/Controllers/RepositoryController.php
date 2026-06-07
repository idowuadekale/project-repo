<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepositoryController extends Controller
{
    // Browse all approved projects
    public function index(Request $request)
    {
        $query = Project::with(['student', 'supervisor', 'department'])
            ->where('status', 'approved');

        // Search by title, abstract or keywords
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%");
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'title' => $query->orderBy('title'),
            default => $query->latest(),
        };

        $projects = $query->paginate(12)->withQueryString();
        $departments = Department::orderBy('name')->get();
        $years = Project::where('status', 'approved')
                        ->selectRaw('DISTINCT year')
                        ->orderBy('year', 'desc')
                        ->pluck('year');

        $total = Project::where('status', 'approved')->count();

        return view('repository.index', compact(
            'projects', 'departments', 'years', 'total'
        ));
    }

    // View single approved project
    public function show(Project $project)
    {
        // Only approved projects are publicly viewable
        if (!$project->isApproved()) {
            abort(404);
        }

        $project->load(['student', 'supervisor', 'department', 'comments.user']);

        return view('repository.show', compact('project'));
    }

    // Download PDF of approved project
    public function download(Project $project)
    {
        if (!$project->isApproved()) {
            abort(403, 'Only approved projects can be downloaded.');
        }

        return Storage::disk('private')->download(
            $project->file_path,
            str()->slug($project->title).'.pdf'
        );
    }
}
