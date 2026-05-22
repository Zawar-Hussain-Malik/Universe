<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fee;
use App\Models\Student;

class FeeSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            // Create fee record for each student
            $statuses = ['paid', 'unpaid', 'partial'];
            $status = $statuses[array_rand($statuses)];

            Fee::create([
                'student_id' => $student->id,
                'amount' => rand(50000, 100000), // Random amount between 50k-100k
                'due_date' => now()->addDays(rand(-30, 30)),
                'status' => $status,
            ]);
        }
    }
}
