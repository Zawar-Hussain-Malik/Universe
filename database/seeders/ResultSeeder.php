<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Result;
use App\Models\Enrollment;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            // Create 2-3 result entries per enrollment
            $resultCount = rand(2, 3);

            for ($i = 0; $i < $resultCount; $i++) {
                $marks = rand(60, 95); // Random marks between 60-95
                $grade = $this->calculateGrade($marks);

                Result::create([
                    'student_id' => $enrollment->student_id,
                    'course_id' => $enrollment->course_id,
                    'marks' => $marks,
                    'grade' => $grade,
                ]);
            }
        }
    }

    private function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A+';
        if ($marks >= 85) return 'A';
        if ($marks >= 80) return 'B+';
        if ($marks >= 75) return 'B';
        if ($marks >= 70) return 'C+';
        if ($marks >= 65) return 'C';
        if ($marks >= 60) return 'D';
        return 'F';
    }
}
