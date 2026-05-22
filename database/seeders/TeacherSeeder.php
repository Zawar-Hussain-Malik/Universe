<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Sarah Khan',
                'designation' => 'Professor',
                'department' => 'Computer Science',
            ],
            [
                'name' => 'Dr. Ahmed Ali',
                'designation' => 'Associate Professor',
                'department' => 'Software Engineering',
            ],
            [
                'name' => 'Dr. Fatima Hassan',
                'designation' => 'Assistant Professor',
                'department' => 'Information Technology',
            ],
            [
                'name' => 'Dr. Usman Malik',
                'designation' => 'Professor',
                'department' => 'Computer Science',
            ],
            [
                'name' => 'Dr. Ayesha Noor',
                'designation' => 'Associate Professor',
                'department' => 'Software Engineering',
            ],
        ];

        foreach ($teachers as $teacherData) {
            $user = User::where('name', $teacherData['name'])->first();
            if ($user) {
                Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'designation' => $teacherData['designation'],
                        'department' => $teacherData['department'],
                    ]
                );
            }
        }
    }
}
