<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Student;
use App\Models\Timetable;
use App\Models\Enrollment;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    private function getTeacherCourses()
    {
        $teacher = Auth::user()->teacher;
        return Course::where('teacher_id', $teacher->id)->pluck('id');
    }
  
    public function dashboard()
    {
        $teacher = Auth::user()->teacher->load('user');
        $courseIds = $this->getTeacherCourses();

        $stats = [
            'courses' => $courseIds->count(),
            'assignments' => Assignment::whereIn('course_id', $courseIds)->count(),
            'students' => Enrollment::whereIn('course_id', $courseIds)->distinct('student_id')->count('student_id'),
            'pending_submissions' => Submission::whereHas('assignment', function($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })->whereNull('grade')->count(),
        ];

        $recentAssignments = Assignment::with('course')
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(5)
            ->get();

        $courses = Course::whereIn('id', $courseIds)
            ->withCount('enrollments')
            ->get();

        return view('teacher.teacherdashboard', compact('teacher', 'stats', 'recentAssignments', 'courses'));
    }

    public function courses()
    {
        $teacher = Auth::user()->teacher;
        $courses = Course::where('teacher_id', $teacher->id)
            ->with(['teacher.user', 'enrollments.student.user'])
            ->latest()
            ->get();
        return view('teacher.teachercourses', compact('courses'));
    }

    public function assignment()
    {
        $teacher = Auth::user()->teacher;
        $courses = Course::where('teacher_id', $teacher->id)
            ->with('enrollments.student.user')
            ->get();
        
        $assignments = Assignment::whereIn('course_id', $this->getTeacherCourses())
            ->with('course')
            ->withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('teacher.teacherassignment', compact('courses', 'assignments'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $teacher = Auth::user()->teacher;
        $course = Course::findOrFail($request->course_id);

        if ($course->teacher_id !== $teacher->id) {
            return back()->withErrors(['error' => 'Unauthorized access to this course.']);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Assignment created successfully!');
    }

    public function deleteAssignment($id)
    {
        $teacher = Auth::user()->teacher;
        $assignment = Assignment::whereIn('course_id', $this->getTeacherCourses())
            ->where('id', $id)
            ->firstOrFail();
        
        // Delete the file if it exists
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }
        
        $assignment->delete();
        
        return back()->with('success', 'Assignment deleted successfully!');
    }

    public function viewSubmissions($id)
    {
        $teacher = Auth::user()->teacher;
        $assignment = Assignment::whereIn('course_id', $this->getTeacherCourses())
            ->where('id', $id)
            ->with(['course', 'submissions.student.user'])
            ->firstOrFail();
        
        return view('teacher.assignmentsubmissions', compact('assignment'));
    }

    public function attendance()
    {
        $teacher = Auth::user()->teacher;
        $courses = Course::where('teacher_id', $teacher->id)->get();
        
        $selectedCourse = null;
        $students = collect();
        
        if (request('course_id')) {
            $selectedCourse = Course::where('teacher_id', $teacher->id)
                ->where('id', request('course_id'))
                ->first();
            
            if ($selectedCourse) {
                $students = Student::whereHas('enrollments', function($q) use ($selectedCourse) {
                    $q->where('course_id', $selectedCourse->id);
                })->with('user')->get();
            }
        }

        return view('teacher.teacherattendance', compact('courses', 'selectedCourse', 'students'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent',
        ]);

        $teacher = Auth::user()->teacher;
        $course = Course::findOrFail($request->course_id);

        if ($course->teacher_id !== $teacher->id) {
            return back()->withErrors(['error' => 'Unauthorized access to this course.']);
        }

        foreach ($request->attendance as $att) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $att['student_id'],
                    'course_id' => $request->course_id,
                    'date' => $request->date,
                ],
                ['status' => $att['status']]
            );
        }

        return back()->with('success', 'Attendance recorded successfully!');
    }

    public function result()
    {
        $teacher = Auth::user()->teacher;
        $courses = Course::where('teacher_id', $teacher->id)->get();
        
        $selectedCourse = null;
        $students = collect();
        $results = collect();
        
        if (request('course_id')) {
            $selectedCourse = Course::where('teacher_id', $teacher->id)
                ->where('id', request('course_id'))
                ->first();
            
            if ($selectedCourse) {
                $students = Student::whereHas('enrollments', function($q) use ($selectedCourse) {
                    $q->where('course_id', $selectedCourse->id);
                })->with('user')->get();

                $results = Result::where('course_id', $selectedCourse->id)
                    ->with('student.user')
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('teacher.teacherresult', compact('courses', 'selectedCourse', 'students', 'results'));
    }

    public function storeResult(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.marks' => 'required|numeric|min:0|max:100',
        ]);

        $teacher = Auth::user()->teacher;
        $course = Course::findOrFail($request->course_id);

        if ($course->teacher_id !== $teacher->id) {
            return back()->withErrors(['error' => 'Unauthorized access to this course.']);
        }

        foreach ($request->results as $resultData) {
            $marks = $resultData['marks'];
            $grade = 'F';
            if ($marks >= 90) $grade = 'A';
            elseif ($marks >= 80) $grade = 'B';
            elseif ($marks >= 70) $grade = 'C';
            elseif ($marks >= 60) $grade = 'D';

            Result::updateOrCreate(
                [
                    'student_id' => $resultData['student_id'],
                    'course_id' => $request->course_id,
                ],
                [
                    'marks' => $marks,
                    'grade' => $grade,
                ]
            );
        }

        return back()->with('success', 'Results saved successfully!');
    }

    public function timetable()
    {
        $teacher = Auth::user()->teacher;
        $timetables = Timetable::whereHas('course', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('course')->orderBy('day')->orderBy('time')->get();
        
        return view('teacher.teachertimetable', compact('timetables'));
    }

    public function transport()
    {
        $teacher = Auth::user()->teacher;
        $courseIds = $this->getTeacherCourses();
        
        $students = Student::whereHas('enrollments', function($q) use ($courseIds) {
            $q->whereIn('course_id', $courseIds);
        })->with(['user', 'transport'])->get();
        
        return view('teacher.teachertransport', compact('students'));
    }

    public function helpdesk()
    {
        return view('teacher.teacherhelpdesk');
    }
}