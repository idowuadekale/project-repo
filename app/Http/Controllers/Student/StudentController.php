<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Project;

class StudentController extends Controller
{
    public function dashboard()
    {
        $projects = Project::where('student_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total' => Project::where('student_id', auth()->id())->count(),
            'pending' => Project::where('student_id', auth()->id())->where('status', 'pending')->count(),
            'approved' => Project::where('student_id', auth()->id())->where('status', 'approved')->count(),
            'rejected' => Project::where('student_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('student.dashboard', compact('projects', 'stats'));
    }
}
