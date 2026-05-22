<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // -----------------------
    // SHOW LOGIN VIEWS
    // -----------------------
    public function showAdminLogin()
    {
        return view('admin.admin_login');
    }

    public function showTeacherLogin()
    {
        return view('teacher.teacher_login');
    }

    public function showStudentLogin()
    {
        return view('student.student_login');
    }

    // -----------------------
    // HANDLE LOGIN
    // -----------------------
public function login(Request $request)
{
    // Validate input
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
        'role'     => 'required'
    ]);

    // Trim the password input
    $passwordInput = trim($request->password);

    // Find user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with this email'])->withInput();
    }

    // Debug: Check hash length
    //  dd($user->password, strlen($user->password), $passwordInput);

    // Check password
//     if (!Hash::check(trim($request->password), $user->password)) {
//     return back()->withErrors(['password' => 'Invalid password'])->withInput();
// }

    // Check role
    if ($user->role !== $request->role) {
        return back()->withErrors(['role' => 'Selected role does not match your account'])->withInput();
    }

    // Log in user
    Auth::login($user);

    // Redirect based on role
    if ($user->role === 'admin') {
        return redirect()->route('admin.admindashboard');
    } elseif ($user->role === 'teacher') {
        return redirect()->route('teacher.teacherdashboard');
    } elseif ($user->role === 'student') {
        return redirect()->route('student.studentdashboard');
    } else {
        return redirect('/');
    }
}


    // -----------------------
    // LOGOUT
    // -----------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
