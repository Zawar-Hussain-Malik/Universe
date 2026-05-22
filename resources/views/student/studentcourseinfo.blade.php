@extends('student.layout')

@section('title', $course->name . ' Overview')

@section('content')
    <div class="main">
        <a href="{{ route('student.courses') }}" class="breadcrumb">← Back to courses</a>

        <div class="course-hero">
            <h2>{{ $course->name }} ({{ $course->code }})</h2>
            <p>Instructor: {{ optional(optional($course->teacher)->user)->name ?? 'TBA' }}</p>
            <div class="course-meta">
                <span class="pill">{{ $course->credit_hours }} Credit Hours</span>
                <span class="pill">{{ $course->department }}</span>
                <span class="pill">Semester: {{ optional($enrollment)->semester ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <h4>Course Details</h4>
                <table>
                    <tr>
                        <th>Teacher</th>
                        <td>{{ optional(optional($course->teacher)->user)->name ?? 'TBA' }}</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>{{ $course->department }}</td>
                    </tr>
                    <tr>
                        <th>Current Semester</th>
                        <td>{{ optional($enrollment)->semester ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $course->updated_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <h4>Recent Assignments</h4>
                <ul class="assignments">
                    @forelse ($assignments as $assignment)
                        <li>
                            <span>{{ $assignment->title }}</span>
                            <span>{{ optional($assignment->due_date)->format('d M') ?? 'TBA' }}</span>
                        </li>
                    @empty
                        <li>No assignments yet.</li>
                    @endforelse
                </ul>
                <div class="mt-15">
                    <a href="{{ route('student.courses.assignments', $course->code) }}" class="link-primary">View all assignments →</a>
                </div>
            </div>
        </div>
    </div>
@endsection

