<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PhotoController; 

// ---------------------------------------------------
// PUBLIC ROUTES
// ---------------------------------------------------

Route::get('/', [HomeController::class, 'index'])->name('home');

// Photo upload example routes (store to storage/app/public/...)
Route::post('/photos/student/{id}', [PhotoController::class, 'storeStudent'])->name('photos.student.store')->middleware('auth');
Route::post('/photos/teacher/{id}', [PhotoController::class, 'storeTeacher'])->name('photos.teacher.store')->middleware('auth');

// -----------------------
// Login Pages
// -----------------------

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------------------------------------
// ADMIN ROUTES (No logic yet — only view routing)
// ---------------------------------------------------

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');
    Route::get('/alumni', [AdminController::class, 'alumni'])->name('admin.adminalumni');
    Route::get('/student', [AdminController::class, 'student'])->name('admin.adminstudent');
    Route::post('/student/upload-csv', [AdminController::class, 'uploadStudentsCSV'])->name('admin.student.upload-csv');
    // Add single-student create routes
    Route::get('/student/add', [AdminController::class, 'createStudent'])->name('admin.student.create');
    Route::post('/student', [AdminController::class, 'storeStudent'])->name('admin.student.store');

    Route::get('/teacher', [AdminController::class, 'teacher'])->name('admin.adminteacher');
    Route::post('/teacher/upload-csv', [AdminController::class, 'uploadTeachersCSV'])->name('admin.teacher.upload-csv');
    // Add single-teacher create routes
    Route::get('/teacher/add', [AdminController::class, 'createTeacher'])->name('admin.teacher.create');
    Route::post('/teacher', [AdminController::class, 'storeTeacher'])->name('admin.teacher.store');
    Route::get('/course', [AdminController::class, 'course'])->name('admin.admincourse');
    Route::post('/course/upload-csv', [AdminController::class, 'uploadCoursesCSV'])->name('admin.course.upload-csv');
    Route::get('/fee', [AdminController::class, 'fee'])->name('admin.adminfee');
    Route::get('/result', [AdminController::class, 'result'])->name('admin.adminresult');
    Route::get('/timetable', [AdminController::class, 'timetable'])->name('admin.admintimetable');
    Route::get('/transport', [AdminController::class, 'transport'])->name('admin.admintransport');
    Route::get('/helpdesk', [AdminController::class, 'helpdesk'])->name('admin.adminhelpdesk');
    Route::patch('/helpdesk/{ticket}', [AdminController::class, 'updateTicket'])->name('admin.helpdesk.update');
    // Delete student
    Route::delete('/student/{student}', [AdminController::class, 'destroyStudent'])->name('admin.student.delete');

    // Delete teacher
    Route::delete('/teacher/{teacher}', [AdminController::class, 'destroyTeacher'])->name('admin.teacher.delete');
});


// ---------------------------------------------------
// TEACHER ROUTES
// ---------------------------------------------------

Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function () {

    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.teacherdashboard');
    Route::get('/courses', [TeacherController::class, 'courses'])->name('teacher.courses');
    
    Route::get('/assignment', [TeacherController::class, 'assignment'])->name('teacher.assignment');
    Route::post('/assignment', [TeacherController::class, 'storeAssignment'])->name('teacher.assignment.store');
    Route::delete('/assignment/{id}', [TeacherController::class, 'deleteAssignment'])->name('teacher.assignment.delete');
    Route::get('/assignment/{id}/submissions', [TeacherController::class, 'viewSubmissions'])->name('teacher.assignment.submissions');
    
    Route::get('/attendance', [TeacherController::class, 'attendance'])->name('teacher.attendance');
    Route::post('/attendance', [TeacherController::class, 'storeAttendance'])->name('teacher.attendance.store');
    
    Route::get('/result', [TeacherController::class, 'result'])->name('teacher.result');
    Route::post('/result', [TeacherController::class, 'storeResult'])->name('teacher.result.store');
    
    Route::get('/timetable', [TeacherController::class, 'timetable'])->name('teacher.timetable');
    Route::get('/transport', [TeacherController::class, 'transport'])->name('teacher.transport');
});

// ---------------------------------------------------
// STUDENT ROUTES
// ---------------------------------------------------

Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {

    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.studentdashboard');

    Route::get('/courses', [StudentController::class, 'courses'])->name('student.courses');
    Route::get('/courses/{code}/assignments', [StudentController::class, 'courseAssignments'])->name('student.courses.assignments');
    Route::get('/courses/{code}', [StudentController::class, 'courseInfo'])->name('student.courses.show');

    Route::post('/assignments/{assignment}/submit', [StudentController::class, 'submitAssignment'])->name('student.assignment.submit');
    Route::get('/assignments/submission/{submission}/download', [StudentController::class, 'downloadSubmission'])->name('student.assignment.submission.download');
    
    Route::get('/announcement', [StudentController::class, 'announcement'])->name('student.announcement');
    Route::get('/assignment', [StudentController::class, 'assignment'])->name('student.assignment');
    Route::get('/assignment/{id}/download', [StudentController::class, 'downloadAssignment'])->name('student.assignment.download');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('student.attendance');
    Route::get('/fee', [StudentController::class, 'fee'])->name('student.fee');
    Route::get('/result', [StudentController::class, 'result'])->name('student.result');
    Route::get('/staff', [StudentController::class, 'staff'])->name('student.staff');
    Route::get('/alumni', [StudentController::class, 'alumni'])->name('student.alumni');

    Route::get('/helpdesk', [StudentController::class, 'helpdesk'])->name('student.helpdesk');
    Route::post('/helpdesk', [StudentController::class, 'storeHelpdesk'])->name('student.helpdesk.store');

    Route::get('/timetable', [StudentController::class, 'timetable'])->name('student.timetable');
    Route::get('/transport', [StudentController::class, 'transport'])->name('student.transport');

    // Course detail routes
    Route::get('/courses/{code}/marks', [StudentController::class, 'marksSummary'])->name('student.courses.marks');
    Route::get('/courses/{code}/quizzes', [StudentController::class, 'quizzes'])->name('student.courses.quizzes');
    Route::get('/courses/{code}/project', [StudentController::class, 'semesterProject'])->name('student.courses.project');

});