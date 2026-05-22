<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transport;
use App\Models\Student;

class TransportSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $routes = [
            'Campus - City Center',
            'Campus - Model Town',
            'Campus - Gulberg',
            'Campus - DHA',
            'Campus - Faisalabad Road',
        ];
        $busNumbers = ['BUS-101', 'BUS-102', 'BUS-103', 'BUS-104', 'BUS-105'];
        $drivers = ['Ali Raza', 'Bilal Khan', 'Usman Sheikh', 'Ahmed Ali', 'Hassan Malik'];

        // Assign transport to 60% of students
        $studentsWithTransport = $students->random((int)($students->count() * 0.6));

        foreach ($studentsWithTransport as $student) {
            Transport::create([
                'student_id' => $student->id,
                'route' => $routes[array_rand($routes)],
                'bus_no' => $busNumbers[array_rand($busNumbers)],
                'driver' => $drivers[array_rand($drivers)],
            ]);
        }
    }
}
