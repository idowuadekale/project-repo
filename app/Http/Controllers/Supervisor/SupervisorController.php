<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;

class SupervisorController extends Controller
{
    public function dashboard()
    {
        return view('supervisor.dashboard');
    }
}
