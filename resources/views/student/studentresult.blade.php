@extends('student.layout')

@section('title', 'Results')

@section('content')
    <div class="main">
        <div>
            <h3>Result History</h3>
            <p class="text-muted">Grades recorded for your enrolled courses.</p>
        </div>

        @if ($results->isEmpty())
            <div class="empty">No results have been published yet.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $result->course->code }} — {{ $result->course->name }}</td>
                            <td>{{ $result->marks ?? 'N/A' }}</td>
                            <td><span class="grade-pill">{{ $result->grade ?? 'N/A' }}</span></td>
                            <td>{{ $result->updated_at->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

