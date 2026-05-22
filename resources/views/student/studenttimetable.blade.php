@extends('student.layout')

@section('title', 'Timetable')

@section('content')
    <div class="main">
        <div>
            <h3>Weekly Timetable</h3>
            <p class="text-muted">All scheduled classes for your enrolled courses.</p>
        </div>

        @if ($timetables->isEmpty())
            <div class="empty">Timetable has not been published yet.</div>
        @else
            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th>Day</th>
                        <th>Course</th>
                        <th>Time</th>
                        <th>Room</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($timetables as $slot)
                        <tr>
                            <td>{{ ucfirst($slot->day) }}</td>
                            <td>{{ $slot->course->code }} — {{ $slot->course->name }}</td>
                            <td>{{ $slot->time }}</td>
                            <td>{{ $slot->room_no ?? 'TBD' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

