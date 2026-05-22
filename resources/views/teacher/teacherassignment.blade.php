@extends('teacher.layout')

@section('title', 'Assignments | UniVerse Teacher')

@section('content')
  @if(session('success'))
    <div class="alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert-error">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="upload-card">
    <header>Create New Assignment</header>

    <form action="{{ route('teacher.assignment.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="course_id">Select Course</label>
        <select id="course_id" name="course_id" required>
          <option value="">--Select Course--</option>
          @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="title">Assignment Title</label>
        <input type="text" id="title" name="title" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"></textarea>
      </div>

      <div class="form-group">
        <label for="due_date">Due Date</label>
        <input type="date" id="due_date" name="due_date" required>
      </div>

      <div class="form-group">
        <label for="file">Upload File (Optional)</label>
        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.zip">
      </div>

      <button type="submit" class="submit-btn">Create Assignment</button>
    </form>
  </div>

  <div class="assignments-list">
    <h3>Your Assignments</h3>
    @forelse($assignments as $assignment)
      <div class="assignment-item">
        <div class="assignment-header">
          <div>
            <strong>{{ $assignment->title }}</strong>
            <div>{{ $assignment->course->code }} - {{ $assignment->course->name }}</div>
            <small>Due: {{ $assignment->due_date->format('M d, Y') }}</small>
            @if($assignment->description)
              <div class="text-muted mt-5">{{ Str::limit($assignment->description, 100) }}</div>
            @endif
            @if($assignment->file_path)
              <div class="text-muted mt-5">
                <small>📎 File attached</small>
              </div>
            @endif
          </div>
          <div class="assignment-actions">
            <a href="{{ route('teacher.assignment.submissions', $assignment->id) }}" class="btn btn-sm btn-info">
              View Submissions ({{ $assignment->submissions_count ?? $assignment->submissions()->count() }})
            </a>
            <form action="{{ route('teacher.assignment.delete', $assignment->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p>No assignments created yet.</p>
    @endforelse

    <div class="mt-20">
      {{ $assignments->links() }}
    </div>
  </div>
@endsection
