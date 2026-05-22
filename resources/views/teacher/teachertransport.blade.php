@extends('teacher.layout')

@section('title', 'Transport | UniVerse Teacher')

@section('content')
  <div class="transport-card">
    <header>Student Transport Information</header>
    
    @if($students->count() > 0)
      <div class="student-list">
        @foreach($students as $student)
          <div class="student-card">
            <strong>{{ $student->user->name }}</strong>
            <div>Roll No: {{ $student->roll_no }}</div>
            <div>Email: {{ $student->user->email }}</div>
            @if($student->transport)
              <div class="transport-info">
                <strong>Transport Details:</strong><br>
                Route: {{ $student->transport->route }}<br>
                Bus No: {{ $student->transport->bus_no }}<br>
                Driver: {{ $student->transport->driver }}
              </div>
            @else
              <div class="transport-info no-transport">
                No transport assigned
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @else
      <p class="text-center text-muted p-20">
        No students found in your courses.
      </p>
    @endif
  </div>
@endsection
