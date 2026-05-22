<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\Course;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create 3-5 assignments per course
            $assignments = [
                [
                    'title' => 'Assignment 1: ' . $course->name . ' Basics',
                    'description' => 'Complete the basic concepts and submit your solutions.',
                    'due_date' => now()->addDays(7),
                ],
                [
                    'title' => 'Assignment 2: ' . $course->name . ' Advanced',
                    'description' => 'Implement advanced features and submit your code.',
                    'due_date' => now()->addDays(14),
                ],
                [
                    'title' => 'Quiz 1: ' . $course->name . ' Midterm Review',
                    'description' => 'Online quiz covering first half of the course.',
                    'due_date' => now()->addDays(21),
                ],
                [
                    'title' => 'Assignment 3: ' . $course->name . ' Project',
                    'description' => 'Final project submission for the course.',
                    'due_date' => now()->addDays(30),
                ],
            ];

            foreach ($assignments as $assignmentData) {
                Assignment::create([
                    'course_id' => $course->id,
                    'title' => $assignmentData['title'],
                    'description' => $assignmentData['description'],
                    'due_date' => $assignmentData['due_date'],
                ]);
            }
        }
    }
}
