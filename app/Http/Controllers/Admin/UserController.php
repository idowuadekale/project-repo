<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // List all users
    public function index(Request $request)
    {
        $query = User::with('department')->where('id', '!=', auth()->id());

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('matric_number', 'like', '%'.$request->search.'%');
            });
        }

        $users = $query->latest()->paginate(15);
        $departments = Department::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'departments'));
    }

    // Show create form
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.users.create', compact('departments'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'matric_number' => ['nullable', 'string', 'unique:users'],
            'role' => ['required', 'in:student,supervisor,admin'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matric_number' => $request->matric_number,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::log('Created user account', $user->name);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" created successfully.");
    }

    // Show edit form
    public function edit(User $user)
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'departments'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'matric_number' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:student,supervisor,admin'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'matric_number' => $request->matric_number,
            'role' => $request->role,
            'department_id' => $request->department_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::log('Updated user account', $user->name);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" updated successfully.");
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::log('Deleted user account', $name);

        return back()->with('success', "User \"{$name}\" deleted.");
    }
}
