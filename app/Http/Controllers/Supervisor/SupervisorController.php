<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Project;

class SupervisorController extends Controller
{
    public function dashboard()
    {
        $recentProjects = Project::where('supervisor_id', auth()->id())
            ->with(['student', 'department'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total' => Project::where('supervisor_id', auth()->id())->count(),
            'pending' => Project::where('supervisor_id', auth()->id())->where('status', 'pending')->count(),
            'approved' => Project::where('supervisor_id', auth()->id())->where('status', 'approved')->count(),
            'rejected' => Project::where('supervisor_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('supervisor.dashboard', compact('recentProjects', 'stats'));
    }
}
