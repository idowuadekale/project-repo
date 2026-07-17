<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'demo@project.com'],
            [
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => bcrypt('Project@123'),
            ]
        );
        \App\Models\User::firstOrCreate(
            ['email' => 'idowu.s.adekale@gmail.com'],
            [
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => bcrypt('Solomonid1@'),
            ]
        );
    }
}
