@extends('admin.layout')

@section('title', 'Admin Dashboard | UniVerse')

@section('content')
    <div class="main">
        <div class="dashboard-header">
            <h2>Welcome back, {{ auth()->user()->name ?? 'Admin' }}</h2>
            <button id="refreshStats" class="fetch-btn">
                🔄 Refresh Stats
            </button>
        </div>

        <div class="cards">
            <div class="card" data-target="{{ $stats['students'] }}">
                <h2 id="students">{{ number_format($stats['students']) }}</h2>
                <p>Total Students</p>
            </div>
            <div class="card" data-target="{{ $stats['teachers'] }}">
                <h2 id="teachers">{{ number_format($stats['teachers']) }}</h2>
                <p>Total Teachers</p>
            </div>
            <div class="card" data-target="{{ $stats['classes'] }}">
                <h2 id="classes">{{ number_format($stats['classes']) }}</h2>
                <p>Classes</p>
            </div>
            <div class="card" data-target="{{ $stats['alumni'] }}">
                <h2 id="alumni">{{ number_format($stats['alumni']) }}</h2>
                <p>Alumni</p>
            </div>
            <div class="card" data-target="{{ $stats['tickets'] }}">
                <h2 id="tickets">{{ number_format($stats['tickets']) }}</h2>
                <p>Help Desk Tickets</p>
            </div>
            <div class="card" data-target="{{ $stats['transport'] }}">
                <h2 id="transport">{{ number_format($stats['transport']) }}</h2>
                <p>Transport</p>
            </div>
        </div>

        <div class="recent-wrapper">
            <div class="recent-card">
                <h4>Latest Courses</h4>
                <ul>
                    @forelse ($recentCourses as $course)
                        <li>
                            {{ $course->name }}
                            <span>{{ $course->code }}</span>
                        </li>
                    @empty
                        <li>No courses yet</li>
                    @endforelse
                </ul>
            </div>
            <div class="recent-card">
                <h4>Pending Tickets</h4>
                <ul>
                    @forelse ($pendingTickets as $ticket)
                        <li>
                            {{ $ticket->subject }}
                            <span>{{ ucfirst($ticket->status) }}</span>
                        </li>
                    @empty
                        <li>No open tickets</li>
                    @endforelse
                </ul>
            </div>
            <div class="recent-card">
                <h4>New Admissions</h4>
                <ul>
                    @forelse ($latestStudents as $latest)
                        <li>
                            {{ $latest->user->name }}
                            <span>{{ $latest->department }}</span>
                        </li>
                    @empty
                        <li>No recent students</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const animateCard = (card) => {
        const target = Number(card.dataset.target ?? 0);
        const valueNode = card.querySelector('h2');
        const duration = 800;
        const frameRate = 20;
        const increment = Math.ceil(target / (duration / frameRate));
        let current = 0;

        const interval = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(interval);
            }
            valueNode.textContent = new Intl.NumberFormat().format(current);
        }, frameRate);
    };

    const triggerAnimation = () => {
        document.querySelectorAll('.card[data-target]').forEach(animateCard);
    };

    document.getElementById('refreshStats').addEventListener('click', triggerAnimation);
    window.addEventListener('load', triggerAnimation);
</script>
@endpush

