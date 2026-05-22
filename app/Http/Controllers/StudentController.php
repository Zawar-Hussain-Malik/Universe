<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Result;
use App\Models\Transport;
use App\Models\Alumni;
use App\Models\HelpdeskTicket;
use App\Models\Timetable;
use App\Models\Teacher;
use App\Models\Announcement;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Middleware removed as requested

    public function dashboard()
    {
        $student = Auth::user()->student->load('user');
        $courseIds = $this->courseIdsForStudent($student->id);

        $stats = [
            'courses' => $courseIds->count(),
            'assignments' => Assignment::whereIn('course_id', $courseIds)->count(),
            'attendance' => Attendance::where('student_id', $student->id)->count(),
            'pending_fee' => Fee::where('student_id', $student->id)->where('status', '!=', 'paid')->sum('amount'),
        ];

        $recentAssignments = Assignment::with('course')
            ->whereIn('course_id', $courseIds)
            ->orderByDesc('due_date')
            ->take(3)
            ->get();

        $announcements = Announcement::latest()->take(3)->get();
        $transport = Transport::where('student_id', $student->id)->first();

        return view('student.studentdashboard', compact('student', 'stats', 'recentAssignments', 'announcements', 'transport'));
    }

    public function courses()
    {
        $enrollments = Enrollment::where('student_id', Auth::user()->student->id)
            ->with(['course.teacher.user'])
            ->get();

        return view('student.studentcourse', compact('enrollments'));
    }

    public function courseInfo($code)
    {
        $student = Auth::user()->student;
        $course = Course::where('code', $code)->with('teacher.user')->firstOrFail();

        abort_unless(
            Enrollment::where('student_id', $student->id)->where('course_id', $course->id)->exists(),
            403
        );

        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        $assignments = Assignment::where('course_id', $course->id)->orderByDesc('due_date')->take(5)->get();

        return view('student.studentcourseinfo', compact('course', 'enrollment', 'assignments'));
    }

    public function assignment()
    {
        $student = Auth::user()->student;
        $courseIds = $this->courseIdsForStudent($student->id);

        $assignments = Assignment::with(['course', 'submissions' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])
            ->whereIn('course_id', $courseIds)
            ->orderByDesc('due_date')
            ->paginate(8);

        return view('student.assignment', [
            'assignments' => $assignments,
            'filterCourse' => null,
        ]);
    }

    public function courseAssignments($code)
    {
        $student = Auth::user()->student;
        $course = Course::where('code', $code)->firstOrFail();

        abort_unless(
            Enrollment::where('student_id', $student->id)->where('course_id', $course->id)->exists(),
            403
        );

        $assignments = Assignment::with(['course', 'submissions' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])
            ->where('course_id', $course->id)
            ->orderByDesc('due_date')
            ->paginate(8);

        return view('student.assignment', [
            'assignments' => $assignments,
            'filterCourse' => $course,
        ]);
    }

    public function attendance()
    {
        $studentId = Auth::user()->student->id;
        $records = Attendance::with('course')
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('course_id')
            ->map(function ($items) {
                $total = $items->count();
                $present = $items->where('status', 'present')->count();

                return [
                    'course' => $items->first()->course,
                    'total' => $total,
                    'present' => $present,
                    'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                    'last_marked' => optional($items->sortByDesc('date')->first())->date,
                ];
            });

        return view('student.attendance', ['attendanceSummary' => $records]);
    }

    public function fee()
    {
        $fee = Fee::where('student_id', Auth::user()->student->id)->first();
        return view('student.studentfee', compact('fee'));
    }

    public function result()
    {
        $results = Result::where('student_id', Auth::user()->student->id)
            ->with('course')
            ->orderByDesc('updated_at')
            ->get();

        return view('student.studentresult', compact('results'));
    }

    public function transport()
    {
        $transport = Transport::where('student_id', Auth::user()->student->id)->first();
        return view('student.studenttransport', compact('transport'));
    }

    public function timetable()
    {
        $timetables = Timetable::whereIn('course_id', function($q) {
            $q->select('course_id')->from('enrollments')
              ->where('student_id', Auth::user()->student->id);
        })->get();
        return view('student.studenttimetable', compact('timetables'));
    }

    public function helpdesk()
    {
        $tickets = HelpdeskTicket::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('student.studenthelpdesk', compact('tickets'));
    }

    public function storeHelpdesk(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        HelpdeskTicket::create([
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        return redirect()->route('student.helpdesk')->with('status', 'Ticket submitted successfully.');
    }

    public function alumni()
    {
        $alumni = Alumni::with('student.user')->latest()->paginate(10);
        return view('student.studentalumni', compact('alumni'));
    }

    public function staff()
    {
        $teachers = Teacher::with('user')->orderBy('department')->get();
        return view('student.staff', compact('teachers'));
    }

    public function announcement()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('student.announcement', compact('announcements'));
    }

    public function marksSummary($code)
    {
        $student = Auth::user()->student;
        $course = Course::where('code', $code)->with('teacher.user')->firstOrFail();

        abort_unless(
            Enrollment::where('student_id', $student->id)->where('course_id', $course->id)->exists(),
            403
        );

        $results = Result::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->orderByDesc('updated_at')
            ->get();

        return view('student.markssummary', compact('course', 'results'));
    }

    public function quizzes($code)
    {
        $student = Auth::user()->student;
        $course = Course::where('code', $code)->with('assignments')->firstOrFail();

        abort_unless(
            Enrollment::where('student_id', $student->id)->where('course_id', $course->id)->exists(),
            403
        );

        return view('student.quizzes', compact('course'));
    }

    public function semesterProject($code)
    {
        $student = Auth::user()->student;
        $course = Course::where('code', $code)->with('teacher.user')->firstOrFail();

        abort_unless(
            Enrollment::where('student_id', $student->id)->where('course_id', $course->id)->exists(),
            403
        );

        return view('student.semesterproject', compact('course'));
    }

    public function downloadAssignment($id)
    {
        $student = Auth::user()->student;
        $courseIds = $this->courseIdsForStudent($student->id);
        
        $assignment = Assignment::whereIn('course_id', $courseIds)
            ->where('id', $id)
            ->firstOrFail();
        
        if (!$assignment->file_path) {
            return back()->withErrors(['error' => 'No file available for this assignment.']);
        }
        
        if (!Storage::disk('public')->exists($assignment->file_path)) {
            return back()->withErrors(['error' => 'File not found.']);
        }
        
        $extension = pathinfo($assignment->file_path, PATHINFO_EXTENSION);
        $downloadName = $assignment->title . ($extension ? '.' . $extension : '');
        
        return Storage::disk('public')->download($assignment->file_path, $downloadName);
    }

    // NEW: Submit Assignment
    public function submitAssignment(Request $request, $assignmentId)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx,zip|max:10240', // 10MB max
            'comments' => 'nullable|string|max:1000',
        ]);

        $student = Auth::user()->student;
        $courseIds = $this->courseIdsForStudent($student->id);
        
        $assignment = Assignment::whereIn('course_id', $courseIds)
            ->where('id', $assignmentId)
            ->firstOrFail();

        // Check if assignment is past due
        if ($assignment->due_date && $assignment->due_date->isPast()) {
            return back()->with('error', 'This assignment is past due and cannot accept submissions.');
        }

        DB::beginTransaction();
        try {
            // Check if submission already exists
            $submission = Submission::where('assignment_id', $assignmentId)
                ->where('student_id', $student->id)
                ->first();

            // Handle file upload
            if ($request->hasFile('submission_file')) {
                $file = $request->file('submission_file');
                $extension = $file->getClientOriginalExtension();
                
                // Create filename: assignmentID_studentID_timestamp.extension
                $fileName = $assignmentId . '_' . $student->id . '_' . time() . '.' . $extension;
                
                // Store in storage/app/public/submissions
                $path = $file->storeAs('submissions', $fileName, 'public');

                // If resubmission, delete old file
                if ($submission && $submission->file_path) {
                    Storage::disk('public')->delete($submission->file_path);
                }

                // Create or update submission
                if ($submission) {
                    $submission->update([
                        'file_path' => $path,
                    ]);
                    $message = 'Assignment resubmitted successfully!';
                } else {
                    Submission::create([
                        'assignment_id' => $assignmentId,
                        'student_id' => $student->id,
                        'file_path' => $path,
                    ]);
                    $message = 'Assignment submitted successfully!';
                }
            }

            DB::commit();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit assignment: ' . $e->getMessage());
        }
    }

    // NEW: Download Student's Own Submission
    public function downloadSubmission($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        $student = Auth::user()->student;

        // Ensure student can only download their own submission
        if ($submission->student_id !== $student->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            return back()->with('error', 'Submission file not found.');
        }

        $extension = pathinfo($submission->file_path, PATHINFO_EXTENSION);
        $downloadName = 'submission_' . $submission->assignment_id . '.' . $extension;
        
        return Storage::disk('public')->download($submission->file_path, $downloadName);
    }

    private function courseIdsForStudent(int $studentId)
    {
        return Enrollment::where('student_id', $studentId)->pluck('course_id');
    }
}