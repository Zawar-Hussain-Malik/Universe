<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2>UniVerse</h2>
        </div>
        <div class="navbar-actions">
            <span class="role-chip">{{ ucfirst(optional(auth()->user())->role ?? 'Admin') }}</span>
            <form action="{{ route('logout') }}" method="GET">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <a href="{{ route('admin.admindashboard') }}"
               class="{{ request()->routeIs('admin.admindashboard') ? 'active' : '' }}">Dashboard</a>

            <a href="{{ route('admin.adminstudent') }}"
               class="{{ request()->routeIs('admin.adminstudent') ? 'active' : '' }}">Students</a>

            <a href="{{ route('admin.adminteacher') }}"
               class="{{ request()->routeIs('admin.adminteacher') ? 'active' : '' }}">Teachers</a>

            <a href="{{ route('admin.admintimetable') }}"
               class="{{ request()->routeIs('admin.admintimetable') ? 'active' : '' }}">Timetable</a>

            <a href="{{ route('admin.adminfee') }}"
               class="{{ request()->routeIs('admin.adminfee') ? 'active' : '' }}">Fees</a>

            <a href="{{ route('admin.admincourse') }}"
               class="{{ request()->routeIs('admin.admincourse') ? 'active' : '' }}">Courses</a>

            <a href="{{ route('admin.adminresult') }}"
               class="{{ request()->routeIs('admin.adminresult') ? 'active' : '' }}">Result</a>

            <a href="{{ route('admin.admintransport') }}"
               class="{{ request()->routeIs('admin.admintransport') ? 'active' : '' }}">Transport</a>

            <a href="{{ route('admin.adminalumni') }}"
               class="{{ request()->routeIs('admin.adminalumni') ? 'active' : '' }}">Alumni</a>

            <a href="{{ route('admin.adminhelpdesk') }}"
               class="{{ request()->routeIs('admin.adminhelpdesk') ? 'active' : '' }}">Helpdesk</a>
        </div>

        <div id="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
