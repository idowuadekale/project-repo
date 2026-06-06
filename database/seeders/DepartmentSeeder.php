<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Computer Science',
            'Biochemistry',
            'Physics',
            'Mathematics',
            'Chemistry',
            'Microbiology',
            'Geology',
        ];

        foreach ($departments as $name) {
            \App\Models\Department::firstOrCreate(['name' => $name]);
        }
    }
}
