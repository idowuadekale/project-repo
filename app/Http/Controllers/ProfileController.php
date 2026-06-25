<?php

namespace App\Http\Controllers;

use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct(protected CloudinaryService $cloudinary)
    {
    }

    public function edit()
    {
        $user = auth()->user()->load('department');
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('profile.edit', compact('user', 'departments'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email',
                Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:300'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'matric_number' => ['nullable', 'string',
                Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'department_id' => $request->department_id,
            'matric_number' => $request->matric_number,
        ]);

        \App\Models\ActivityLog::log('Updated profile', $user->name);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        $user = auth()->user();

        $uploaded = $this->cloudinary->uploadAvatar(
            $request->file('photo')->getRealPath(),
            $user->id
        );

        $user->update([
            'profile_photo_path' => $uploaded['url'],
        ]);

        ActivityLog::log('Updated profile photo', $user->name);

        return back()->with('success', 'Profile photo updated.');
    }

    public function removePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo_path) {
            $this->cloudinary->delete(
                'lasu-repo/avatars/user_'.$user->id,
                'image'
            );
            $user->update(['profile_photo_path' => null]);
        }

        ActivityLog::log('Removed profile photo', $user->name);

        return back()->with('success', 'Profile photo removed.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        \App\Models\ActivityLog::log('Changed password', auth()->user()->name);

        return back()->with('success', 'Password changed successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();

        // Keep approved projects, delete pending/rejected
        \App\Models\Project::where('student_id', $user->id)
            ->where('status', 'approved')
            ->update(['student_id' => null]);

        \App\Models\Project::where('student_id', $user->id)
            ->whereIn('status', ['pending', 'rejected'])
            ->each(function ($project) {
                if ($project->file_public_id) {
                    $this->cloudinary->delete($project->file_public_id, 'raw');
                }
                $project->delete();
            });

        // Remove profile photo
        if ($user->profile_photo_path) {
            $this->cloudinary->delete(
                'lasu-repo/avatars/user_'.$user->id,
                'image'
            );
        }

        ActivityLog::log('Deleted own account', $user->name);

        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
