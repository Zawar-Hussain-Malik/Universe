@extends('teacher.layout')

@section('title', 'Results | UniVerse Teacher')

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

  <div class="assessment-card">
    <header>Enter Student Marks</header>

    <form method="GET" action="{{ route('teacher.result') }}">
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
      <form action="{{ route('teacher.result.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">

        <div class="table-wrap">
          <table class="assessment-table">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Marks (0-100)</th>
                <th>Current Grade</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $student)
                <tr>
                  <td>{{ $student->roll_no }}</td>
                  <td>{{ $student->user->name }}</td>
                  <td>
                    <input type="number" 
                           name="results[{{ $loop->index }}][marks]" 
                           min="0" 
                           max="100" 
                           value="{{ $results->get($student->id)->marks ?? '' }}" 
                           required>
                    <input type="hidden" name="results[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                  </td>
                  <td>
                    @if($results->has($student->id))
                      <strong>{{ $results->get($student->id)->grade }}</strong>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <button type="submit" class="submit-btn">Submit Marks</button>
      </form>
    @elseif($selectedCourse)
      <p class="text-center text-muted mt-20">No students enrolled in this course.</p>
    @endif
  </div>
@endsection

