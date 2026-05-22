<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Get students and courses
        $students = Student::all();
        $courses = Course::all();

        // Enroll students in courses based on their department and semester
        foreach ($students as $student) {
            foreach ($courses as $course) {
                // Enroll students in courses matching their department
                if ($student->department === $course->department) {
                    // Enroll based on semester logic (simplified)
                    $shouldEnroll = false;
                    
                    if ($student->semester == '1' && in_array($course->code, ['IT101'])) {
                        $shouldEnroll = true;
                    } elseif ($student->semester == '3' && in_array($course->code, ['CS201', 'CS202', 'CS203', 'CS204', 'CS205'])) {
                        $shouldEnroll = true;
                    } elseif ($student->semester == '5' && in_array($course->code, ['SE301', 'SE302'])) {
                        $shouldEnroll = true;
                    }

                    if ($shouldEnroll) {
                        Enrollment::firstOrCreate([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'semester' => $student->semester,
                        ]);
                    }
                }
            }
        }
    }
}
