<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/student.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2>UniVerse</h2>
        </div>
        <div class="navbar-actions">
            <span>{{ auth()->user()->name ?? 'Student' }}</span>
            <form action="{{ route('logout') }}" method="GET">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <a href="{{ route('student.studentdashboard') }}" class="{{ request()->routeIs('student.studentdashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('student.courses') }}" class="{{ request()->routeIs('student.courses*') ? 'active' : '' }}">Courses</a>
            <a href="{{ route('student.assignment') }}" class="{{ request()->routeIs('student.assignment') ? 'active' : '' }}">Assignments</a>
            <a href="{{ route('student.attendance') }}" class="{{ request()->routeIs('student.attendance') ? 'active' : '' }}">Attendance</a>
            <a href="{{ route('student.result') }}" class="{{ request()->routeIs('student.result') ? 'active' : '' }}">Results</a>
            <a href="{{ route('student.fee') }}" class="{{ request()->routeIs('student.fee') ? 'active' : '' }}">Fees</a>
            <a href="{{ route('student.timetable') }}" class="{{ request()->routeIs('student.timetable') ? 'active' : '' }}">Timetable</a>
            <a href="{{ route('student.transport') }}" class="{{ request()->routeIs('student.transport') ? 'active' : '' }}">Transport</a>
            <a href="{{ route('student.helpdesk') }}" class="{{ request()->routeIs('student.helpdesk') ? 'active' : '' }}">Helpdesk</a>
            <a href="{{ route('student.alumni') }}" class="{{ request()->routeIs('student.alumni') ? 'active' : '' }}">Alumni</a>
            <a href="{{ route('student.staff') }}" class="{{ request()->routeIs('student.staff') ? 'active' : '' }}">Faculty</a>
            <a href="{{ route('student.announcement') }}" class="{{ request()->routeIs('student.announcement') ? 'active' : '' }}">Announcements</a>
        </div>

        <div id="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>

