<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'matric_number',
        'password',
        'role',
        'department_id',
        'profile_photo_path',
        'phone',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'student_id');
    }

    public function supervisedProjects()
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // Get profile photo URL or null
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo_path) {
            // Cloudinary URL stored directly
            return $this->profile_photo_path;
        }

        return null;
    }

    // Get initials for avatar placeholder
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', trim($this->name));
        if (count($parts) >= 2) {
            return strtoupper($parts[0][0].$parts[count($parts) - 1][0]);
        }

        return strtoupper($parts[0][0] ?? 'U');
    }
}
