@extends('admin.layout')

@section('title', 'Teachers | UniVerse Admin')

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

        <div class="upload-card" style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
            <div>
                <h4>📤 Upload Teachers via CSV</h4>
                <form action="{{ route('admin.teacher.upload-csv') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <input type="file" name="csv_file" accept=".csv,.txt" required>
                    <button type="submit">Upload CSV</button>
                </form>
                <div class="csv-info">
                    <strong>CSV Format:</strong> name, email, password, role, designation, department<br>
                    <small>Note: Password is optional (defaults to 'password123'). Role should be 'teacher'.</small>
                </div>
            </div>

            <div style="text-align:right">
                <a href="{{ route('admin.teacher.create') }}" class="btn">+ Add Teacher</a>
            </div>
        </div>

        <div class="section">
            <h3>Faculty Overview</h3>
            <div class="departments">
                @forelse ($departmentStats as $dept)
                    <div class="dept-card" data-department="{{ $dept->department ?? 'Unknown' }}">
                        <strong>{{ $dept->department ?? 'Unknown' }}</strong>
                        <span>{{ $dept->total }}</span>
                        <small>Teachers</small>
                    </div>
                @empty
                    <p>No teachers found.</p>
                @endforelse
            </div>
        </div>

        <div class="table-card">
            <div class="search-filter">
                <input type="text" id="teacherSearch" placeholder="Search by teacher name, email or designation">
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Courses</th>
                    </tr>
                </thead>
                <tbody id="teacherTableBody">
                    @forelse ($teachers as $index => $teacher)
                        <tr data-row-department="{{ $teacher->department ?? 'Unknown' }}">
                            <td>{{ $teachers->firstItem() + $index }}</td>
                            <td>{{ $teacher->user->name }}</td>
                            <td>{{ $teacher->department ?? 'N/A' }}</td>
                            <td>{{ $teacher->designation ?? 'N/A' }}</td>
                            <td>{{ $teacher->user->email }}</td>
                            <td>
                                <div class="course-list">
                                    @forelse ($teacher->courses as $course)
                                        <span class="course-pill">{{ $course->code }}</span>
                                    @empty
                                        <span class="course-pill">No course</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No teachers recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const teacherCards = document.querySelectorAll('.dept-card');
    const teacherRows = document.querySelectorAll('#teacherTableBody tr');
    const teacherSearch = document.getElementById('teacherSearch');
    let teacherDepartment = null;

    const filterTeachers = () => {
        const term = teacherSearch.value.toLowerCase();
        teacherRows.forEach(row => {
            const matchesDept = !teacherDepartment || row.dataset.rowDepartment === teacherDepartment;
            const matchesTerm = row.textContent.toLowerCase().includes(term);
            row.style.display = matchesDept && matchesTerm ? '' : 'none';
        });
    };

    teacherCards.forEach(card => {
        card.addEventListener('click', () => {
            teacherCards.forEach(c => c.classList.remove('active'));
            if (teacherDepartment === card.dataset.department) {
                teacherDepartment = null;
            } else {
                teacherDepartment = card.dataset.department;
                card.classList.add('active');
            }
            filterTeachers();
        });
    });

    teacherSearch?.addEventListener('input', filterTeachers);
</script>
@endpush

