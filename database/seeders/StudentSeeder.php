<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'Ali Ahmed',
                'roll_no' => 'STU-2024-001',
                'department' => 'Computer Science',
                'semester' => '3',
                'section' => 'A',
                'father_name' => 'Ahmed Ali',
                'dob' => '2003-05-15',
                'city' => 'Karachi',
                'phone' => '0301-2345678',
                'blood_group' => 'O+',
            ],
            [
                'name' => 'Hina Raza',
                'roll_no' => 'STU-2024-002',
                'department' => 'Computer Science',
                'semester' => '3',
                'section' => 'A',
                'father_name' => 'Raza Khan',
                'dob' => '2003-08-20',
                'city' => 'Lahore',
                'phone' => '0302-3456789',
                'blood_group' => 'A+',
            ],
            [
                'name' => 'Bilal Khan',
                'roll_no' => 'STU-2024-003',
                'department' => 'Software Engineering',
                'semester' => '5',
                'section' => 'B',
                'father_name' => 'Khan Sahab',
                'dob' => '2002-11-10',
                'city' => 'Islamabad',
                'phone' => '0303-4567890',
                'blood_group' => 'B+',
            ],
            [
                'name' => 'Sara Ali',
                'roll_no' => 'STU-2024-004',
                'department' => 'Information Technology',
                'semester' => '1',
                'section' => 'A',
                'father_name' => 'Ali Hassan',
                'dob' => '2004-02-25',
                'city' => 'Karachi',
                'phone' => '0304-5678901',
                'blood_group' => 'AB+',
            ],
            [
                'name' => 'Usman Sheikh',
                'roll_no' => 'STU-2024-005',
                'department' => 'Computer Science',
                'semester' => '3',
                'section' => 'B',
                'father_name' => 'Sheikh Ahmed',
                'dob' => '2003-07-12',
                'city' => 'Lahore',
                'phone' => '0305-6789012',
                'blood_group' => 'O-',
            ],
            [
                'name' => 'Maryam Fatima',
                'roll_no' => 'STU-2024-006',
                'department' => 'Software Engineering',
                'semester' => '5',
                'section' => 'A',
                'father_name' => 'Fatima Khan',
                'dob' => '2002-09-30',
                'city' => 'Islamabad',
                'phone' => '0306-7890123',
                'blood_group' => 'A-',
            ],
            [
                'name' => 'Zain Malik',
                'roll_no' => 'STU-2024-007',
                'department' => 'Information Technology',
                'semester' => '1',
                'section' => 'B',
                'father_name' => 'Malik Sahab',
                'dob' => '2004-04-18',
                'city' => 'Karachi',
                'phone' => '0307-8901234',
                'blood_group' => 'B-',
            ],
            [
                'name' => 'Ayesha Khan',
                'roll_no' => 'STU-2024-008',
                'department' => 'Computer Science',
                'semester' => '3',
                'section' => 'A',
                'father_name' => 'Khan Ali',
                'dob' => '2003-12-05',
                'city' => 'Lahore',
                'phone' => '0308-9012345',
                'blood_group' => 'O+',
            ],
        ];

        foreach ($students as $index => $studentData) {
            $user = User::where('name', $studentData['name'])->first();
            if ($user) {
                Student::firstOrCreate(
                    ['roll_no' => $studentData['roll_no']],
                    [
                        'user_id' => $user->id,
                        'department' => $studentData['department'],
                        'semester' => $studentData['semester'],
                        'section' => $studentData['section'],
                        'father_name' => $studentData['father_name'],
                        'dob' => $studentData['dob'],
                        'city' => $studentData['city'],
                        'phone' => $studentData['phone'],
                        'blood_group' => $studentData['blood_group'],
                    ]
                );
            }
        }
    }
}
