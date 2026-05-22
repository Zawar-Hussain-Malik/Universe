@extends('teacher.layout')

@section('title', 'Timetable | UniVerse Teacher')

@section('content')
  <div class="timetable-card">
    <header>
      <h2>Weekly Timetable</h2>
      <div>{{ auth()->user()->name }}</div>
    </header>
    <div class="table-wrap">
      <table class="timetable">
        <thead>
          <tr>
            <th>Day</th>
            <th>Time</th>
            <th>Course</th>
            <th>Room</th>
          </tr>
        </thead>
        <tbody>
          @forelse($timetables as $slot)
            <tr>
              <td>{{ $slot->day }}</td>
              <td>{{ $slot->time }}</td>
              <td>
                <div class="slot">
                  {{ $slot->course->code }} - {{ $slot->course->name }}
                </div>
              </td>
              <td>{{ $slot->room_no }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center p-20 text-muted">
                No timetable entries found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
