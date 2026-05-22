@extends('teacher.layout')

@section('title', 'Attendance | UniVerse Teacher')

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

  <div class="attendance-card">
    <header>Mark Attendance</header>

    <form method="GET" action="{{ route('teacher.attendance') }}">
      <div class="form-group">
        <label for="course_id">Select Course</label>
        <select id="course_id" name="course_id" onchange="this.form.submit()">
          <option value="">--Select Course--</option>
          @foreach($courses as $course)
            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
              {{ $course->code }} - {{ $course->name }}
            </option>
          @endforeach
        </select>
      </div>
    </form>

    @if($selectedCourse && $students->count() > 0)
      <form action="{{ route('teacher.attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
        
        <div class="form-group">
          <label for="date">Date</label>
          <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required>
        </div>

        <div class="table-wrap">
          <table class="attendance-table">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Attendance</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $student)
                <tr>
                  <td>{{ $student->roll_no }}</td>
                  <td>{{ $student->user->name }}</td>
                  <td>
                    <select class="attendance-select" name="attendance[{{ $loop->index }}][status]" required>
                      <option value="present">Present</option>
                      <option value="absent">Absent</option>
                    </select>
                    <input type="hidden" name="attendance[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <button type="submit" class="submit-btn">Submit Attendance</button>
      </form>
    @elseif($selectedCourse)
      <p class="text-center text-muted mt-20">No students enrolled in this course.</p>
    @endif
  </div>
@endsection

