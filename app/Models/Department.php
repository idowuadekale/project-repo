<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Count helpers
    public function studentsCount(): int
    {
        return $this->users()->where('role', 'student')->count();
    }

    public function supervisorsCount(): int
    {
        return $this->users()->where('role', 'supervisor')->count();
    }
}
