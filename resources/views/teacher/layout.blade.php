<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/teacher.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2>UniVerse</h2>
        </div>
        <div class="navbar-actions">
            <span>{{ auth()->user()->name ?? 'Teacher' }}</span>
            <form action="{{ route('logout') }}" method="GET">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <a href="{{ route('teacher.teacherdashboard') }}" class="{{ request()->routeIs('teacher.teacherdashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('teacher.assignment') }}" class="{{ request()->routeIs('teacher.assignment') ? 'active' : '' }}">Assignments</a>
            <a href="{{ route('teacher.attendance') }}" class="{{ request()->routeIs('teacher.attendance') ? 'active' : '' }}">Attendance</a>
            <a href="{{ route('teacher.result') }}" class="{{ request()->routeIs('teacher.result') ? 'active' : '' }}">Results</a>
            <a href="{{ route('teacher.timetable') }}" class="{{ request()->routeIs('teacher.timetable') ? 'active' : '' }}">Timetable</a>
            <a href="{{ route('teacher.transport') }}" class="{{ request()->routeIs('teacher.transport') ? 'active' : '' }}">Transport</a>
        </div>

        <div id="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>

