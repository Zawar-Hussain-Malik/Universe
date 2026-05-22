@extends('admin.layout')

@section('title', 'Timetable | UniVerse Admin')

@section('content')
    <div class="content">
        <div class="section-header">
            <h2>Weekly Timetable</h2>
            <p>Overview of scheduled classes across all courses.</p>
        </div>

        <div class="day-grid">
            @forelse ($slots->groupBy('day') as $day => $daySlots)
                <div class="day-card">
                    <h3>{{ ucfirst($day) }}</h3>
                    @foreach ($daySlots as $slot)
                        <div class="slot">
                            <strong>{{ $slot->course->code }} — {{ $slot->course->name }}</strong>
                            <span>{{ $slot->time }}</span>
                            <span>Room: {{ $slot->room_no ?? 'TBD' }}</span>
                        </div>
                    @endforeach
                </div>
            @empty
                <p class="empty">No timetable slots have been created yet.</p>
            @endforelse
        </div>
    </div>
@endsection

