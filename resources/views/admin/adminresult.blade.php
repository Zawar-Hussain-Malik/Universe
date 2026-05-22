@extends('admin.layout')

@section('title', 'Results | UniVerse Admin')

@section('content')
    <div class="content">
        <div class="section-header">
            <h2>Semester Results</h2>
            <p>Latest uploaded grades across departments.</p>
        </div>

        <div class="filters">
            <select id="resultDepartmentFilter">
                <option value="">All Departments</option>
                @foreach ($results->pluck('student.department')->unique()->filter() as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
            <select id="resultSemesterFilter">
                <option value="">All Semesters</option>
                @foreach ($results->pluck('course.semester')->unique()->filter() as $semester)
                    <option value="{{ $semester }}">{{ $semester }}</option>
                @endforeach
            </select>
            <input type="text" id="resultSearch" placeholder="Search by student or course">
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>Semester</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody id="resultTableBody">
                    @forelse ($results as $result)
                        <tr data-department="{{ $result->student->department }}" data-semester="{{ $result->course->semester }}" data-search="{{ strtolower($result->student->user->name . ' ' . $result->course->name) }}">
                            <td>{{ $result->student->user->name }}</td>
                            <td>{{ $result->course->code }} - {{ $result->course->name }}</td>
                            <td>{{ $result->student->department ?? 'N/A' }}</td>
                            <td>{{ $result->course->semester ?? '-' }}</td>
                            <td><span class="grade-pill">{{ $result->grade ?? $result->marks }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No result records available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $results->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const resultRows = document.querySelectorAll('#resultTableBody tr');
    const departmentFilter = document.getElementById('resultDepartmentFilter');
    const semesterFilter = document.getElementById('resultSemesterFilter');
    const resultSearch = document.getElementById('resultSearch');

    const filterResults = () => {
        const dept = departmentFilter.value;
        const semester = semesterFilter.value;
        const term = resultSearch.value.toLowerCase();

        resultRows.forEach(row => {
            const matchesDept = !dept || row.dataset.department === dept;
            const matchesSemester = !semester || row.dataset.semester === semester;
            const matchesTerm = row.dataset.search.includes(term);
            row.style.display = matchesDept && matchesSemester && matchesTerm ? '' : 'none';
        });
    };

    departmentFilter?.addEventListener('change', filterResults);
    semesterFilter?.addEventListener('change', filterResults);
    resultSearch?.addEventListener('input', filterResults);
</script>
@endpush

