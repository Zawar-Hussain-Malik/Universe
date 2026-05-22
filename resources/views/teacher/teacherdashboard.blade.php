@extends('teacher.layout')

@section('title', 'Teacher Dashboard | UniVerse')

@section('content')
<div class="main">
  <header>
    <div class="profile-pic-top">
    @php
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $imagePath = null;
        
        foreach ($extensions as $ext) {
            $path = 'storage/teachers/' . $teacher->id . '.' . $ext;
            if (file_exists(public_path($path))) {
                $imagePath = $path;
                break;
            }
        }
    @endphp

    @if($imagePath)
        <img src="{{ asset($imagePath) }}" alt="Profile Photo">
    @else
        <img src="{{ asset('storage/teachers/default.png') }}" alt="Default Profile Photo">
    @endif
</div>
    <div>
      <h1>Welcome, {{ $teacher->user->name }}</h1>
      <p>Your personalized teaching dashboard</p>
    </div>
  </header>

  <div class="stats-grid">
    <div class="stat-card">
      <h4>Total Courses</h4>
      <div class="number">{{ $stats['courses'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Assignments</h4>
      <div class="number">{{ $stats['assignments'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Total Students</h4>
      <div class="number">{{ $stats['students'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Pending Submissions</h4>
      <div class="number">{{ $stats['pending_submissions'] }}</div>
    </div>
  </div>

  <div class="profile-card">
    <div class="info">
      <div><strong>Full Name</strong> <span>{{ $teacher->user->name }}</span></div>
      <div><strong>Department</strong> <span>{{ $teacher->department ?? 'N/A' }}</span></div>
      <div><strong>Designation</strong> <span>{{ $teacher->designation ?? 'N/A' }}</span></div>
      <div><strong>Email</strong> <span>{{ $teacher->user->email }}</span></div>
      <div><strong>Courses Assigned</strong> <span>{{ $courses->pluck('name')->implode(', ') ?: 'No courses assigned' }}</span></div>
    </div>
  </div>

  @if($recentAssignments->count() > 0)
  <div class="recent-section">
    <h3>Recent Assignments</h3>
    @foreach($recentAssignments as $assignment)
    <div class="recent-item">
      <strong>{{ $assignment->title }}</strong> - {{ $assignment->course->name }}<br>
      <small>Due: {{ $assignment->due_date->format('M d, Y') }}</small>
    </div>
    @endforeach
  </div>
  @endif
</div>
@endsection
