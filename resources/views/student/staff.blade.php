@extends('student.layout')

@section('title', 'Faculty Directory')

@section('content')
    <div class="main">
        <div>
            <h3>Faculty</h3>
            <p class="text-muted">Teaching staff across all departments.</p>
        </div>

        <div class="grid">
            @forelse ($teachers as $teacher)
                <div class="card">
                    <h4>{{ $teacher->user->name }}</h4>
                    <p>{{ $teacher->designation ?? 'Faculty Member' }}</p>
                    <p>Email: {{ $teacher->user->email }}</p>
                    <span class="badge">{{ $teacher->department }}</span>
                </div>
            @empty
                <p>No teachers found.</p>
            @endforelse
        </div>
    </div>
@endsection

