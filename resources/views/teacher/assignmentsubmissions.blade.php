@extends('teacher.layout')

@section('title', 'Assignment Submissions | UniVerse Teacher')

@section('content')
  <div class="main">
    <div class="header-section">
      <div>
        <h3>Submissions for: {{ $assignment->title }}</h3>
        <p class="text-muted">{{ $assignment->course->code }} - {{ $assignment->course->name }}</p>
        <p class="text-muted">Due Date: {{ $assignment->due_date->format('M d, Y') }}</p>
      </div>
      <a href="{{ route('teacher.assignment') }}" class="btn btn-secondary">← Back to Assignments</a>
    </div>

    @if($assignment->description)
      <div class="card mb-20">
        <h4>Description</h4>
        <p>{{ $assignment->description }}</p>
      </div>
    @endif

    <div class="card">
      <h4>Student Submissions</h4>
      
      @if($assignment->submissions->isEmpty())
        <div class="empty">
          <p>No submissions yet.</p>
        </div>
      @else
        <table>
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Roll No</th>
              <th>Submitted At</th>
              <th>File</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody>
            @foreach($assignment->submissions as $submission)
              <tr>
                <td>{{ $submission->student->user->name }}</td>
                <td>{{ $submission->student->roll_no }}</td>
                <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                <td>
                  @if($submission->file_path)
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                      View File
                    </a>
                  @else
                    <span class="text-muted">No file</span>
                  @endif
                </td>
                <td>
                  @if($submission->grade !== null)
                    <strong>{{ $submission->grade }}</strong>
                  @else
                    <span class="text-muted">Not graded</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection

