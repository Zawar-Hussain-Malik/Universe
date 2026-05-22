<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Enrollment;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::with('course')->get();

        foreach ($enrollments as $enrollment) {
            // Create attendance records for the past 2 months
            $startDate = Carbon::now()->subMonths(2);
            $endDate = Carbon::now();

            $currentDate = $startDate->copy();
            $classCount = 0;

            while ($currentDate <= $endDate && $classCount < 30) {
                // Only weekdays (Monday to Friday)
                if ($currentDate->isWeekday()) {
                    // Randomly mark attendance (80% present rate)
                    $status = rand(1, 100) <= 80 ? 'present' : 'absent';

                    Attendance::create([
                        'student_id' => $enrollment->student_id,
                        'course_id' => $enrollment->course_id,
                        'date' => $currentDate->format('Y-m-d'),
                        'status' => $status,
                    ]);

                    $classCount++;
                }

                $currentDate->addDay();
            }
        }
    }
}
