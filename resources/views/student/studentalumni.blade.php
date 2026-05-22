@extends('student.layout')

@section('title', 'Alumni')

@section('content')
    <div class="main">
        <div>
            <h3>Alumni Network</h3>
            <p class="text-muted">Recent graduates and their current roles.</p>
        </div>

        @if ($alumni->isEmpty())
            <div class="empty">No alumni data available.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Graduation Year</th>
                        <th>Company</th>
                        <th>Designation</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumni as $member)
                        <tr>
                            <td>{{ $member->student->user->name }}</td>
                            <td>{{ $member->graduation_year ?? 'N/A' }}</td>
                            <td>{{ $member->company ?? 'N/A' }}</td>
                            <td>{{ $member->designation ?? 'N/A' }}</td>
                            <td>{{ $member->student->user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $alumni->links() }}
        @endif
    </div>
@endsection

