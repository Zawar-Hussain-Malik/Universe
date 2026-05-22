<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            AssignmentSeeder::class,
            AttendanceSeeder::class,
            FeeSeeder::class,
            ResultSeeder::class,
            TimetableSeeder::class,
            TransportSeeder::class,
            AnnouncementSeeder::class,
            AlumniSeeder::class,
        ]);
    }
}