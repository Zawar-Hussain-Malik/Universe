@extends('admin.layout')

@section('title', 'Alumni | UniVerse Admin')

@section('content')
    <div class="content">
        <header>
            <h1>Alumni Directory</h1>
            <p>Recently verified graduates.</p>
        </header>

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
                @forelse ($alumni as $member)
                    <tr>
                        <td>{{ $member->student->user->name }}</td>
                        <td>{{ $member->graduation_year ?? 'N/A' }}</td>
                        <td>{{ $member->company ?? 'N/A' }}</td>
                        <td>{{ $member->designation ?? 'N/A' }}</td>
                        <td>{{ $member->student->user->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No alumni records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $alumni->links() }}
    </div>
@endsection

