<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Fee;
use App\Models\Result;
use App\Models\Transport;
use App\Models\Alumni;
use App\Models\HelpdeskTicket;
use App\Models\Timetable;
use App\Models\User;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'classes' => Course::count(),
            'alumni' => Alumni::count(),
            'tickets' => HelpdeskTicket::count(),
            'transport' => Transport::count(),
        ];

        $recentCourses = Course::latest()->take(5)->get(['name', 'code']);
        $pendingTickets = HelpdeskTicket::latest()->where('status', '!=', 'closed')->take(5)->get(['subject', 'status']);
        $latestStudents = Student::with('user')->latest()->take(5)->get();

        return view('admin.admindashboard', compact('stats', 'recentCourses', 'pendingTickets', 'latestStudents'));
    }

    public function student()
    {
        $students = Student::with('user')->latest()->paginate(10);
        $departmentStats = Student::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        return view('admin.adminstudent', compact('students', 'departmentStats'));
    }

    public function teacher()
    {
        $teachers = Teacher::with(['user', 'courses'])->latest()->paginate(10);
        $departmentStats = Teacher::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        return view('admin.adminteacher', compact('teachers', 'departmentStats'));
    }

    public function course()
    {
        $courses = Course::with('teacher.user')->latest()->paginate(10);
        return view('admin.admincourse', compact('courses'));
    }

    public function fee()
    {
        $feeSummary = [
            'pending' => Fee::where('status', 'unpaid')->sum('amount'),
            'paid' => Fee::where('status', 'paid')->sum('amount'),
            'overdue' => Fee::where('status', 'unpaid')
                ->whereDate('due_date', '<', now())
                ->sum('amount'),
        ];

        $fees = Fee::with('student.user')
            ->latest()
            ->paginate(10);

        return view('admin.adminfee', compact('fees', 'feeSummary'));
    }

    public function result()
    {
        $results = Result::with(['student.user', 'course'])->latest()->paginate(10);
        return view('admin.adminresult', compact('results'));
    }

    public function timetable()
    {
        $slots = Timetable::with('course')
            ->orderBy('day')
            ->orderBy('time')
            ->get();

        return view('admin.admintimetable', compact('slots'));
    }

    public function transport()
    {
        $routes = Transport::with('student.user')->latest()->paginate(10);
        return view('admin.admintransport', compact('routes'));
    }

    public function alumni()
    {
        $alumni = Alumni::with('student.user')->latest()->paginate(10);
        return view('admin.adminalumni', compact('alumni'));
    }

    public function helpdesk()
    {
        $tickets = HelpdeskTicket::with('user')->latest()->paginate(10);
        return view('admin.adminhelpdesk', compact('tickets'));
    }

    public function updateTicket(Request $request, HelpdeskTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,pending,closed',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        return back()->with('status', "Ticket #{$ticket->id} updated.");
    }

    public function uploadStudentsCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Remove header row
        $header = array_shift($data);
        
        // Expected columns: name, email, password, role, father_name, dob, city, phone, blood_group, roll_no, department, semester, section
        $expectedColumns = ['name', 'email', 'password', 'role', 'father_name', 'dob', 'city', 'phone', 'blood_group', 'roll_no', 'department', 'semester', 'section'];
        
        // Validate header
        if (count($header) < 13) {
            return back()->withErrors(['csv_file' => 'CSV file must have at least 13 columns.']);
        }

        $errors = [];
        $successCount = 0;

        foreach ($data as $index => $row) {
            if (count($row) < 13) {
                $errors[] = "Row " . ($index + 2) . ": Insufficient columns.";
                continue;
            }

            try {
                $name = trim($row[0]);
                $email = trim($row[1]);
                $password = trim($row[2]);
                $role = trim($row[3]);
                $fatherName = trim($row[4]);
                $dob = trim($row[5]);
                $city = trim($row[6]);
                $phone = trim($row[7]);
                $bloodGroup = trim($row[8]);
                $rollNo = trim($row[9]);
                $department = trim($row[10]);
                $semester = trim($row[11]);
                $section = trim($row[12]);

                if (empty($email) || empty($name)) {
                    $errors[] = "Row " . ($index + 2) . ": Email and name are required.";
                    continue;
                }

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make($password ?: 'password123'),
                        'role' => $role ?: 'student',
                    ]
                );

                if ($user->role === 'student') {
                    Student::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'father_name' => $fatherName,
                            'dob' => $dob ?: null,
                            'city' => $city,
                            'phone' => $phone,
                            'blood_group' => $bloodGroup,
                            'roll_no' => $rollNo,
                            'department' => $department,
                            'semester' => $semester,
                            'section' => $section,
                        ]
                    );
                }

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$successCount} students.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(' ', array_slice($errors, 0, 5));
        }

        return back()->with('status', $message);
    }

    public function uploadTeachersCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        $header = array_shift($data);
        
        // Expected columns: name, email, password, role, designation, department
        if (count($header) < 6) {
            return back()->withErrors(['csv_file' => 'CSV file must have at least 6 columns.']);
        }

        $errors = [];
        $successCount = 0;

        foreach ($data as $index => $row) {
            if (count($row) < 6) {
                $errors[] = "Row " . ($index + 2) . ": Insufficient columns.";
                continue;
            }

            try {
                $name = trim($row[0]);
                $email = trim($row[1]);
                $password = trim($row[2]);
                $role = trim($row[3]);
                $designation = trim($row[4]);
                $department = trim($row[5]);

                if (empty($email) || empty($name)) {
                    $errors[] = "Row " . ($index + 2) . ": Email and name are required.";
                    continue;
                }

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make($password ?: 'password123'),
                        'role' => $role ?: 'teacher',
                    ]
                );

                if ($user->role === 'teacher') {
                    Teacher::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'designation' => $designation,
                            'department' => $department,
                        ]
                    );
                }

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$successCount} teachers.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(' ', array_slice($errors, 0, 5));
        }

        return back()->with('status', $message);
    }

    // ---------- Single create pages & handlers ----------

    public function createStudent()
    {
        return view('admin.add-student');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'roll_no' => 'required|string|unique:students,roll_no',
            'department' => 'required|string',
            'semester' => 'required|string',
            'section' => 'nullable|string',
            'father_name' => 'nullable|string',
            'dob' => 'nullable|date',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?: 'password123'),
                'role' => 'student',
            ]);

            $studentData = [
                'user_id' => $user->id,
                'roll_no' => $request->roll_no,
                'department' => $request->department,
                'semester' => $request->semester,
                'section' => $request->section,
                'father_name' => $request->father_name,
                'dob' => $request->dob ?: null,
                'city' => $request->city,
                'phone' => $request->phone,
                'blood_group' => $request->blood_group,
            ];

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                $image = $request->file('profile_pic');
                $extension = $image->getClientOriginalExtension();
                
                // Rename file to roll_no.extension
                $imageName = $request->roll_no . '.' . $extension;
                
                // Store in storage/app/public/students using the 'public' disk
                $path = $image->storeAs('students', $imageName, 'public');
                
                // Save relative path in database (e.g., 'students/12345.jpg')
                $studentData['profile_pic'] = $path;
            }

            Student::create($studentData);
            DB::commit();

            return redirect()->route('admin.adminstudent')->with('status', 'Student created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($user)) { $user->delete(); }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function createTeacher()
    {
        return view('admin.add-teacher');
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'designation' => 'nullable|string',
            'department' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?: 'password123'),
                'role' => 'teacher',
            ]);

            $teacherData = [
                'user_id' => $user->id,
                'designation' => $request->designation,
                'department' => $request->department,
            ];

            $teacher = Teacher::create($teacherData);

            // Handle teacher photo upload
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $extension = $image->getClientOriginalExtension();
                
                // Rename file to teacher_id.extension
                $imageName = $teacher->id . '.' . $extension;
                
                // Store in storage/app/public/teachers using the 'public' disk
                $path = $image->storeAs('teachers', $imageName, 'public');
                
                // If you have a photo column in teachers table, update it
                $teacher->update(['photo' => $path]);
            }

            DB::commit();

            return redirect()->route('admin.adminteacher')->with('status', 'Teacher created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($user)) { $user->delete(); }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroyStudent(Student $student)
    {
        // Delete student profile image if exists
        if ($student->profile_pic && Storage::disk('public')->exists($student->profile_pic)) {
            Storage::disk('public')->delete($student->profile_pic);
        }

        // Delete associated user (cascades student due to FK)
        $student->user->delete();

        return redirect()
            ->route('admin.adminstudent')
            ->with('success', 'Student deleted successfully.');
    }

    public function destroyTeacher(Teacher $teacher)
    {
        // Delete teacher profile image if exists
        if (isset($teacher->photo) && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Delete associated user
        $teacher->user->delete();

        return redirect()
            ->route('admin.adminteacher')
            ->with('success', 'Teacher deleted successfully.');
    }

    public function uploadCoursesCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        $header = array_shift($data);
        
        // Expected columns: code, name, credit_hours, department, teacher_email
        if (count($header) < 5) {
            return back()->withErrors(['csv_file' => 'CSV file must have at least 5 columns.']);
        }

        $errors = [];
        $successCount = 0;

        foreach ($data as $index => $row) {
            if (count($row) < 5) {
                $errors[] = "Row " . ($index + 2) . ": Insufficient columns.";
                continue;
            }

            try {
                $code = trim($row[0]);
                $name = trim($row[1]);
                $creditHours = trim($row[2]);
                $department = trim($row[3]);
                $teacherEmail = trim($row[4]);

                if (empty($code) || empty($name)) {
                    $errors[] = "Row " . ($index + 2) . ": Code and name are required.";
                    continue;
                }

                $teacher = null;
                if (!empty($teacherEmail)) {
                    $teacherUser = User::where('email', $teacherEmail)->where('role', 'teacher')->first();
                    if ($teacherUser) {
                        $teacher = Teacher::where('user_id', $teacherUser->id)->first();
                    }
                }

                Course::firstOrCreate(
                    ['code' => $code],
                    [
                        'name' => $name,
                        'credit_hours' => (int)$creditHours ?: 3,
                        'department' => $department,
                        'teacher_id' => $teacher ? $teacher->id : null,
                    ]
                );

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$successCount} courses.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(' ', array_slice($errors, 0, 5));
        }

        return back()->with('status', $message);
    }
}