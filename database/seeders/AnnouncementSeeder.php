<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $teachers = User::where('role', 'teacher')->take(3)->get();

        $announcements = [
            [
                'title' => 'Welcome to New Academic Year',
                'description' => 'We welcome all students to the new academic year. Please check your course schedules and attend orientation sessions.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Midterm Examinations Schedule',
                'description' => 'Midterm examinations will commence from next week. Please check the examination schedule posted on the notice board.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Assignment Submission Deadline Extended',
                'description' => 'The deadline for Assignment 2 has been extended by one week. Please submit your assignments before the new deadline.',
                'user_id' => $teachers->first()->id ?? $admin->id,
            ],
            [
                'title' => 'Library Hours Extended',
                'description' => 'Library will remain open until 10 PM during examination period. Make use of this facility for your studies.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Sports Week Registration Open',
                'description' => 'Annual sports week registration is now open. Interested students can register at the sports office.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Course Material Available Online',
                'description' => 'All course materials and lecture slides are now available on the student portal. Please download and review them.',
                'user_id' => $teachers->skip(1)->first()->id ?? $admin->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
