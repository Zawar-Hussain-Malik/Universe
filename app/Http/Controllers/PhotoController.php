<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\Teacher;

class PhotoController extends Controller
{
    /**
     * Store uploaded photo for a student and update `profile_pic` if the student exists.
     * Files are stored in `storage/app/public/students` and are publicly available via
     * `asset('storage/students/filename')` after running `php artisan storage:link`.
     */
    public function storeStudent(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $filename = 'student_'.$id.'.'.$ext;

        // Store file in storage/app/public/students
        $path = $file->storeAs('public/students', $filename);

        // If Student exists, update profile_pic and remove old file if present
        $student = Student::find($id);
        if ($student) {
            if ($student->profile_pic) {
                // profile_pic is stored as "students/filename.ext" in DB
                Storage::delete('public/'.$student->profile_pic);
            }
            $student->profile_pic = 'students/'.$filename;
            $student->save();
        }

        return back()->with('success', 'Student photo uploaded successfully.');
    }

    /**
     * Store uploaded photo for a teacher. By default this stores the file under
     * `storage/app/public/teachers`. If you want to persist the path to DB, add a
     * `photo` or `profile_pic` column to the `teachers` table and update it similarly to students.
     */
    public function storeTeacher(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $filename = 'teacher_'.$id.'.'.$ext;

        // Store file in storage/app/public/teachers
        $path = $file->storeAs('public/teachers', $filename);

        // If you add a DB column to Teacher for the path, you can update it here.
        $teacher = Teacher::find($id);
        if ($teacher) {
            // Example (requires a column like `photo` or `profile_pic` on teachers):
            // if ($teacher->photo) { Storage::delete('public/'.$teacher->photo); }
            // $teacher->photo = 'teachers/'.$filename; $teacher->save();
        }

        return back()->with('success', 'Teacher photo uploaded successfully.');
    }
}
