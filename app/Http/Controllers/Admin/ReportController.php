<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // Projects per department
        $byDepartment = Department::withCount([
            'projects',
            'projects as approved_count' => fn ($q) => $q->where('status', 'approved'),
            'projects as pending_count' => fn ($q) => $q->where('status', 'pending'),
            'projects as rejected_count' => fn ($q) => $q->where('status', 'rejected'),
        ])->get();

        // Projects per year
        $byYear = Project::selectRaw('year, COUNT(*) as total,
                    SUM(status = "approved") as approved,
                    SUM(status = "pending")  as pending,
                    SUM(status = "rejected") as rejected')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Overall stats
        $stats = [
            'total_projects' => Project::count(),
            'approved' => Project::where('status', 'approved')->count(),
            'pending' => Project::where('status', 'pending')->count(),
            'rejected' => Project::where('status', 'rejected')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_supervisors' => User::where('role', 'supervisor')->count(),
        ];

        return view('admin.reports', compact('byDepartment', 'byYear', 'stats'));
    }
}
