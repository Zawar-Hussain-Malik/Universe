@extends('student.layout')

@section('title', 'Student Dashboard')

@section('content')
    <div class="main">
        <div>
            <h3>Welcome back, {{ $student->user->name }}</h3>
            <p class="text-muted">Here's a snapshot of your academic activity.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>{{ $stats['courses'] }}</h4>
                <span>Active Courses</span>
            </div>
            <div class="stat-card">
                <h4>{{ $stats['assignments'] }}</h4>
                <span>Assignments</span>
            </div>
            <div class="stat-card">
                <h4>{{ number_format($stats['attendance']) }}</h4>
                <span>Attendance Marks</span>
            </div>
            <div class="stat-card">
                <h4>PKR {{ number_format($stats['pending_fee'], 0) }}</h4>
                <span>Pending Fees</span>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-pic-top">
            @php
                // Images are stored in storage/app/public/students but accessed via public/storage/students
                // Use the profile_pic from database if available, otherwise try roll_no
                $imagePath = $student->profile_pic 
                    ? 'storage/' . $student->profile_pic 
                    : 'storage/students/' . $student->roll_no;
            @endphp

            @if($student->profile_pic)
                <img src="{{ asset('storage/' . $student->profile_pic) }}" alt="Profile Photo" onerror="this.src='{{ asset('storage/students/default.jpg') }}';">
            @else
                <img src="{{ asset('storage/students/' . $student->roll_no . '.jpg') }}" 
                     onerror="this.src='{{ asset('storage/students/' . $student->roll_no . '.png') }}'; this.onerror=function(){this.src='{{ asset('storage/students/default.jpg') }}';};"
                     alt="Profile Photo">
            @endif
        </div>

                <div>
                    <h1>Student Information</h1>
                    <p>Personal details and academic profile</p>
                </div>
            </div>
            <div class="info">
                <div><strong>Full Name</strong> {{ $student->user->name }}</div>
                <div><strong>Father's Name</strong> {{ $student->father_name ?? 'N/A' }}</div>
                <div><strong>Registration Number</strong> {{ $student->roll_no }}</div>
                <div><strong>Date of Birth</strong> {{ $student->dob ?? 'N/A' }}</div>
                <div><strong>City</strong> {{ $student->city ?? 'N/A' }}</div>
                <div><strong>Phone Number</strong> {{ $student->phone ?? 'N/A' }}</div>
                <div><strong>Blood Group</strong> {{ $student->blood_group ?? 'N/A' }}</div>
                <div><strong>Department</strong> {{ $student->department }}</div>
                <div><strong>Semester</strong> {{ $student->semester ?? 'N/A' }}</div>
                <div><strong>Email</strong> {{ $student->user->email }}</div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <h4>Upcoming Assignments</h4>
                <ul class="timeline">
                    @forelse ($recentAssignments as $assignment)
                        <li>
                            <span>{{ $assignment->title }} <small class="text-muted">({{ $assignment->course->code }})</small></span>
                            <span class="badge">{{ optional($assignment->due_date)->format('d M') ?? 'TBA' }}</span>
                        </li>
                    @empty
                        <li>No assignments scheduled.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card">
                <h4>Latest Announcements</h4>
                <ul class="timeline">
                    @forelse ($announcements as $announcement)
                        <li>
                            <span>{{ $announcement->title }}</span>
                            <span class="badge">{{ $announcement->created_at->format('d M') }}</span>
                        </li>
                    @empty
                        <li>No announcements yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        @if ($transport)
            <div class="transport-card">
                <div>
                    <h4 style="margin-bottom:4px;">Transport Assignment</h4>
                    <p style="color:#475467;">Route: {{ $transport->route }} — Bus {{ $transport->bus_no }}</p>
                </div>
                <div>
                    <span class="badge">Driver: {{ $transport->driver ?? 'TBA' }}</span>
                </div>
            </div>
        @endif
    </div>
@endsection

