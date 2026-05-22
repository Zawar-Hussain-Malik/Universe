<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Object-Oriented Programming',
                'code' => 'CS201',
                'credit_hours' => 3,
                'department' => 'Computer Science',
                'teacher_name' => 'Dr. Sarah Khan',
            ],
            [
                'name' => 'Data Structures & Algorithms',
                'code' => 'CS202',
                'credit_hours' => 4,
                'department' => 'Computer Science',
                'teacher_name' => 'Dr. Usman Malik',
            ],
            [
                'name' => 'Database Systems',
                'code' => 'CS203',
                'credit_hours' => 3,
                'department' => 'Computer Science',
                'teacher_name' => 'Dr. Sarah Khan',
            ],
            [
                'name' => 'Web Development',
                'code' => 'SE301',
                'credit_hours' => 3,
                'department' => 'Software Engineering',
                'teacher_name' => 'Dr. Ahmed Ali',
            ],
            [
                'name' => 'Software Engineering Principles',
                'code' => 'SE302',
                'credit_hours' => 3,
                'department' => 'Software Engineering',
                'teacher_name' => 'Dr. Ayesha Noor',
            ],
            [
                'name' => 'Introduction to Programming',
                'code' => 'IT101',
                'credit_hours' => 3,
                'department' => 'Information Technology',
                'teacher_name' => 'Dr. Fatima Hassan',
            ],
            [
                'name' => 'Computer Networks',
                'code' => 'CS204',
                'credit_hours' => 3,
                'department' => 'Computer Science',
                'teacher_name' => 'Dr. Usman Malik',
            ],
            [
                'name' => 'Operating Systems',
                'code' => 'CS205',
                'credit_hours' => 4,
                'department' => 'Computer Science',
                'teacher_name' => 'Dr. Sarah Khan',
            ],
        ];

        foreach ($courses as $courseData) {
            $teacher = Teacher::whereHas('user', function($q) use ($courseData) {
                $q->where('name', $courseData['teacher_name']);
            })->first();

            if ($teacher) {
                Course::firstOrCreate(
                    ['code' => $courseData['code']],
                    [
                        'name' => $courseData['name'],
                        'credit_hours' => $courseData['credit_hours'],
                        'department' => $courseData['department'],
                        'teacher_id' => $teacher->id,
                    ]
                );
            }
        }
    }
}
