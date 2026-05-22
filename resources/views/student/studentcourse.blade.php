@extends('student.layout')

@section('title', 'My Courses')

@section('content')
    <div class="main">
        <div>
            <h3>Your Courses</h3>
            <p class="text-muted">Explore enrolled subjects and access resources.</p>
        </div>

        @if ($enrollments->isEmpty())
            <div class="empty">You are not enrolled in any courses yet.</div>
        @else
            <div class="courses-container">
                @foreach ($enrollments as $enrollment)
                    <a class="course-card" href="{{ route('student.courses.show', $enrollment->course->code) }}">
                        <div class="course-header">
                            <span class="course-code">{{ $enrollment->course->code }}</span>
                            <span class="credit">{{ $enrollment->course->credit_hours }} CrHr</span>
                        </div>
                        <div class="course-title">{{ $enrollment->course->name }}</div>
                        <div class="meta">Instructor: {{ optional(optional($enrollment->course->teacher)->user)->name ?? 'TBA' }}</div>
                        <div class="meta">Department: {{ $enrollment->course->department }}</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection

