<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::withCount([
            'users',
            'projects',
            'users as students_count' => fn ($q) => $q->where('role', 'student'),
            'users as supervisors_count' => fn ($q) => $q->where('role', 'supervisor'),
            'projects as approved_count' => fn ($q) => $q->where('status', 'approved'),
            'projects as pending_count' => fn ($q) => $q->where('status', 'pending'),
        ]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $departments = $query->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $totalDepts = Department::count();
        $totalProjects = Project::count();

        return view('admin.departments.index',
            compact('departments', 'totalDepts', 'totalProjects'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:departments,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $dept = Department::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        ActivityLog::log('Created department', $dept->name);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$dept->name}\" created successfully.");
    }

    public function edit(Department $department)
    {
        $department->loadCount([
            'projects',
            'users as students_count' => fn ($q) => $q->where('role', 'student'),
            'users as supervisors_count' => fn ($q) => $q->where('role', 'supervisor'),
        ]);

        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100',
                Rule::unique('departments')->ignore($department->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $old = $department->name;

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        ActivityLog::log('Updated department', "{$old} → {$department->name}");

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        // Professional cascade logic:
        // — Approved projects: keep in repository, set department_id = null
        //   (they stay visible; we just lose the department label)
        // — Pending/rejected projects: delete them (they haven't been archived)
        // — Users in this dept: set department_id = null (they stay, just unassigned)

        // Nullify approved project department reference
        $department->projects()
            ->where('status', 'approved')
            ->update(['department_id' => null]);

        // Delete pending + rejected projects (and log)
        $department->projects()
            ->whereIn('status', ['pending', 'rejected'])
            ->each(function ($project) {
                if ($project->file_path) {
                    \Storage::disk('private')->delete($project->file_path);
                }
                $project->delete();
            });

        // Unassign users
        $department->users()->update(['department_id' => null]);

        $name = $department->name;
        $department->delete();

        ActivityLog::log('Deleted department', $name);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$name}\" deleted. Approved projects kept in repository.");
    }
}
