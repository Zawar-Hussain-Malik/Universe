<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timetable;
use App\Models\Course;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            '08:00 AM - 09:30 AM',
            '09:30 AM - 11:00 AM',
            '11:00 AM - 12:30 PM',
            '02:00 PM - 03:30 PM',
            '03:30 PM - 05:00 PM',
        ];
        $rooms = ['Room 101', 'Room 102', 'Room 201', 'Room 202', 'Lab 1', 'Lab 2'];

        foreach ($courses as $course) {
            // Create 2-3 timetable slots per course
            $slotCount = rand(2, 3);
            $usedDays = [];

            for ($i = 0; $i < $slotCount; $i++) {
                $day = $days[array_rand($days)];
                
                // Avoid duplicate days for same course
                while (in_array($day, $usedDays) && count($usedDays) < count($days)) {
                    $day = $days[array_rand($days)];
                }
                $usedDays[] = $day;

                Timetable::create([
                    'course_id' => $course->id,
                    'day' => $day,
                    'time' => $timeSlots[array_rand($timeSlots)],
                    'room_no' => $rooms[array_rand($rooms)],
                ]);
            }
        }
    }
}
