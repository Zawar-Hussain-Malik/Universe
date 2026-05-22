<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumni;
use App\Models\Student;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Create some alumni records (students who graduated)
        $alumniData = [
            [
                'roll_no' => 'STU-2020-001',
                'graduation_year' => '2023',
                'company' => 'Tech Solutions Inc.',
                'designation' => 'Software Engineer',
            ],
            [
                'roll_no' => 'STU-2020-002',
                'graduation_year' => '2023',
                'company' => 'Digital Systems Ltd.',
                'designation' => 'Senior Developer',
            ],
            [
                'roll_no' => 'STU-2020-003',
                'graduation_year' => '2022',
                'company' => 'Innovation Hub',
                'designation' => 'Project Manager',
            ],
            [
                'roll_no' => 'STU-2020-004',
                'graduation_year' => '2022',
                'company' => 'Cloud Services Co.',
                'designation' => 'DevOps Engineer',
            ],
            [
                'roll_no' => 'STU-2020-005',
                'graduation_year' => '2023',
                'company' => 'Data Analytics Pro',
                'designation' => 'Data Scientist',
            ],
        ];

        // Create users and students for alumni
        foreach ($alumniData as $alum) {
            // Create a user for alumni (if not exists)
            $user = \App\Models\User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $alum['roll_no'])) . '@alumni.universe.com'],
                [
                    'name' => 'Alumni ' . $alum['roll_no'],
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'student',
                ]
            );

            // Create student record
            $student = \App\Models\Student::firstOrCreate(
                ['roll_no' => $alum['roll_no']],
                [
                    'user_id' => $user->id,
                    'department' => 'Computer Science',
                    'semester' => '8',
                    'section' => 'A',
                ]
            );

            // Create alumni record
            Alumni::create([
                'student_id' => $student->id,
                'graduation_year' => $alum['graduation_year'],
                'company' => $alum['company'],
                'designation' => $alum['designation'],
            ]);
        }
    }
}
