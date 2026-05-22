@extends('admin.layout')

@section('title', 'Courses | UniVerse Admin')

@section('content')
    <div class="content">
        @if(session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="upload-card">
            <h4>📤 Upload Courses via CSV</h4>
            <form action="{{ route('admin.course.upload-csv') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                @csrf
                <input type="file" name="csv_file" accept=".csv,.txt" required>
                <button type="submit">Upload CSV</button>
            </form>
            <div class="csv-info">
                <strong>CSV Format:</strong> code, name, credit_hours, department, teacher_email<br>
                <small>Note: teacher_email should match an existing teacher's email. Leave empty if no teacher assigned.</small>
            </div>
        </div>

        <div class="section-header">
            <h2>Course Catalogue</h2>
            <p>Browse all courses with their assigned faculty members.</p>
        </div>

        <div class="table-card">
            <div class="filters">
                <input type="text" id="courseSearch" placeholder="Search by title or code">
                <select id="courseDepartmentFilter">
                    <option value="">All Departments</option>
                    @foreach ($courses->pluck('department')->unique()->filter() as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Semester</th>
                        <th>Teacher</th>
                    </tr>
                </thead>
                <tbody id="courseTableBody">
                    @forelse ($courses as $course)
                        <tr data-department="{{ $course->department }}" data-search="{{ strtolower($course->name . ' ' . $course->code) }}">
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->department ?? 'N/A' }}</td>
                            <td>{{ $course->credit_hours ?? '-' }} Credits</td>
                            <td>{{ optional($course->teacher->user ?? null)->name ?? 'Unassigned' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No courses available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const courseRows = document.querySelectorAll('#courseTableBody tr');
    const courseSearch = document.getElementById('courseSearch');
    const courseDepartmentFilter = document.getElementById('courseDepartmentFilter');

    const filterCourses = () => {
        const term = courseSearch.value.toLowerCase();
        const dept = courseDepartmentFilter.value;

        courseRows.forEach(row => {
            const matchesDept = !dept || row.dataset.department === dept;
            const matchesTerm = row.dataset.search.includes(term);
            row.style.display = matchesDept && matchesTerm ? '' : 'none';
        });
    };

    courseSearch?.addEventListener('input', filterCourses);
    courseDepartmentFilter?.addEventListener('change', filterCourses);
</script>
@endpush

