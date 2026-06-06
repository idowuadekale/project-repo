<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('auth.register', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'matric_number' => ['nullable', 'string', 'max:20', 'unique:users'],
            'role' => ['required', 'in:student,supervisor'],
            'department_id' => ['required', 'exists:departments,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matric_number' => $request->matric_number,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return match ($user->role) {
            'supervisor' => redirect()->route('supervisor.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }
}
