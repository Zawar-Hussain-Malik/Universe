@extends('student.layout')

@section('title', $course->name . ' - Marks Summary')

@section('content')
<div class="main-content">
    <div class="header-row">
        <a href="{{ route('student.courses.show', $course->code) }}" class="back-btn">← Back</a>
        <h3>Marks & Performance - {{ $course->name }}</h3>
        <div class="spacer"></div>
    </div>

    <div class="marks-column">
        @if($results->count() > 0)
            <div class="marks-card" onclick="toggleOpen('resultsDetails')">
                <h4>Course Results</h4>
                <div class="muted">Click to view all marks and grades</div>
                <div id="resultsDetails" class="details">
                    <table>
                        <thead>
                            <tr>
                                <th>Assessment Type</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                            <tr>
                                <td>Result #{{ $result->id }}</td>
                                <td>{{ $result->marks ?? 'N/A' }}</td>
                                <td><strong>{{ $result->grade ?? 'N/A' }}</strong></td>
                                <td>{{ $result->updated_at->format('d-M-Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="marks-card">
                <h4>No Results Available</h4>
                <div class="muted">Results for this course have not been published yet.</div>
            </div>
        @endif

        <div class="marks-card" onclick="toggleOpen('courseInfo')">
            <h4>Course Information</h4>
            <div class="muted">Click to view course details</div>
            <div id="courseInfo" class="details">
                <table>
                    <tr>
                        <td><strong>Course Code:</strong></td>
                        <td>{{ $course->code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Course Name:</strong></td>
                        <td>{{ $course->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Credit Hours:</strong></td>
                        <td>{{ $course->credit_hours }}</td>
                    </tr>
                    <tr>
                        <td><strong>Department:</strong></td>
                        <td>{{ $course->department }}</td>
                    </tr>
                    <tr>
                        <td><strong>Instructor:</strong></td>
                        <td>{{ $course->teacher->user->name ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleOpen(id) {
        const allDetails = document.querySelectorAll('.details');
        allDetails.forEach(d => {
            if (d.id !== id) {
                d.classList.remove('open');
                d.setAttribute('aria-hidden', 'true');
            }
        });
        const selected = document.getElementById(id);
        if (selected) {
            const isOpen = selected.classList.contains('open');
            selected.classList.toggle('open', !isOpen);
            selected.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
        }
    }
</script>
@endpush

