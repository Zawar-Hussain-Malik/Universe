@extends('student.layout')

@section('title', $course->name . ' - Quizzes')

@section('content')
<div class="main">
    <div class="header-row">
        <a href="{{ route('student.courses.show', $course->code) }}" class="back-btn">← Back</a>
        <h3>Quizzes - {{ $course->name }}</h3>
        <div class="spacer"></div>
    </div>
    <p>Check quiz schedules, topics, and slots. Attempt quizzes online here.</p>

    <div class="list-card">
        @if($course->assignments->where('title', 'like', '%quiz%')->count() > 0)
            <table class="quiz-table">
                <thead>
                    <tr>
                        <th>Quiz #</th>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->assignments->where('title', 'like', '%quiz%') as $index => $assignment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->due_date ? $assignment->due_date->format('d-M-Y') : 'N/A' }}</td>
                        <td><button class="small-btn">View Details</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-quizzes">
                No quizzes available for this course yet.
            </div>
        @endif
    </div>

    <p class="muted">
        Note: Quiz functionality is currently in development. Check back later for online quiz attempts.
    </p>
</div>
@endsection

