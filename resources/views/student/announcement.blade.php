@extends('student.layout')

@section('title', 'Announcements')

@section('content')
    <div class="main">
        <div>
            <h3>Announcements</h3>
            <p class="text-muted">Latest updates from the administration.</p>
        </div>

        @forelse ($announcements as $announcement)
            <div class="announcement">
                <h4>{{ $announcement->title }}</h4>
                <time>{{ $announcement->created_at->format('d M, Y') }}</time>
                <p>{{ $announcement->description ?? $announcement->body ?? $announcement->message ?? 'Details not provided.' }}</p>
            </div>
        @empty
            <div class="announcement">
                <p>No announcements available.</p>
            </div>
        @endforelse

        {{ $announcements->links() }}
    </div>
@endsection

