<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_supervisors' => User::where('role', 'supervisor')->count(),
            'total_projects' => Project::count(),
            'pending' => Project::where('status', 'pending')->count(),
            'approved' => Project::where('status', 'approved')->count(),
            'rejected' => Project::where('status', 'rejected')->count(),
            'total_departments' => Department::count(),
        ];

        $recentProjects = Project::with(['student', 'supervisor', 'department'])
            ->latest()
            ->take(5)
            ->get();

        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentLogs'));
    }
}
