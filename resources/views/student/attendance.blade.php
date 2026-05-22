@extends('student.layout')

@section('title', 'Attendance')

@section('content')
    <div class="main">
        <div>
            <h3>Attendance Overview</h3>
            <p class="text-muted">Course-wise attendance percentage.</p>
        </div>

        @if ($attendanceSummary->isEmpty())
            <div class="empty">No attendance has been recorded yet.</div>
        @else
            <div class="attendance-grid">
                @foreach ($attendanceSummary as $summary)
                    <div class="card">
                        <h4>{{ $summary['course']->code }}</h4>
                        <p class="text-muted" style="margin:0;">{{ $summary['course']->name }}</p>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $summary['percentage'] }}%;"></div>
                        </div>
                        <div class="meta">
                            <span>{{ $summary['present'] }}/{{ $summary['total'] }} present</span>
                            <span>{{ $summary['percentage'] }}%</span>
                        </div>
                        <p class="text-muted" style="margin-top:8px;font-size:0.85rem;">
                            Last marked: {{ optional($summary['last_marked'])->format('d M, Y') ?? 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

