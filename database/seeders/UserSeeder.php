<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@universe.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Teachers
        $teachers = [
            ['name' => 'Dr. Sarah Khan', 'email' => 'sarah.khan@universe.com', 'role' => 'teacher'],
            ['name' => 'Dr. Ahmed Ali', 'email' => 'ahmed.ali@universe.com', 'role' => 'teacher'],
            ['name' => 'Dr. Fatima Hassan', 'email' => 'fatima.hassan@universe.com', 'role' => 'teacher'],
            ['name' => 'Dr. Usman Malik', 'email' => 'usman.malik@universe.com', 'role' => 'teacher'],
            ['name' => 'Dr. Ayesha Noor', 'email' => 'ayesha.noor@universe.com', 'role' => 'teacher'],
        ];

        foreach ($teachers as $teacher) {
            User::firstOrCreate(
                ['email' => $teacher['email']],
                [
                    'name' => $teacher['name'],
                    'password' => Hash::make('password123'),
                    'role' => $teacher['role'],
                ]
            );
        }

        // Students
        $students = [
            ['name' => 'Ali Ahmed', 'email' => 'ali.ahmed@universe.com', 'role' => 'student'],
            ['name' => 'Hina Raza', 'email' => 'hina.raza@universe.com', 'role' => 'student'],
            ['name' => 'Bilal Khan', 'email' => 'bilal.khan@universe.com', 'role' => 'student'],
            ['name' => 'Sara Ali', 'email' => 'sara.ali@universe.com', 'role' => 'student'],
            ['name' => 'Usman Sheikh', 'email' => 'usman.sheikh@universe.com', 'role' => 'student'],
            ['name' => 'Maryam Fatima', 'email' => 'maryam.fatima@universe.com', 'role' => 'student'],
            ['name' => 'Zain Malik', 'email' => 'zain.malik@universe.com', 'role' => 'student'],
            ['name' => 'Ayesha Khan', 'email' => 'ayesha.khan@universe.com', 'role' => 'student'],
        ];

        foreach ($students as $student) {
            User::firstOrCreate(
                ['email' => $student['email']],
                [
                    'name' => $student['name'],
                    'password' => Hash::make('password123'),
                    'role' => $student['role'],
                ]
            );
        }
    }
}
