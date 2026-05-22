@extends('admin.layout')

@section('title', 'Students | UniVerse Admin')

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
                <h4>📤 Upload Students via CSV</h4>
                <form action="{{ route('admin.student.upload-csv') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <input type="file" name="csv_file" accept=".csv,.txt" required>
                    <button type="submit">Upload CSV</button>
                </form>
                <div class="csv-info">
                    <strong>CSV Format:</strong> name, email, password, role, father_name, dob, city, phone, blood_group, roll_no, department, semester, section<br>
                    <small>Note: Password is optional (defaults to 'password123'). Role should be 'student'.</small>
                </div>
            </div>

            <div style="text-align:right">
                <a href="{{ route('admin.student.create') }}" class="btn">+ Add Student</a>
            </div>
        </div>

        <div class="section">
            <h3>Department Snapshot</h3>
            <div class="departments">
                @forelse ($departmentStats as $dept)
                    <div class="dept-card" data-department="{{ $dept->department ?? 'Unknown' }}">
                        <strong>{{ $dept->department ?? 'Unknown' }}</strong>
                        <span>{{ $dept->total }}</span>
                        <small>Students</small>
                    </div>
                @empty
                    <p>No department data found.</p>
                @endforelse
            </div>
        </div>

        <div class="table-card">
            <div class="search-filter">
                <input type="text" id="studentSearch" placeholder="Search by name, roll no, email">
                <button type="button" id="clearFilter">Clear Filters</button>
            </div>

            <h4>Active Students</h4>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Roll No</th>
                        <th>Department</th>
                        <th>Semester</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @forelse ($students as $index => $student)
                        <tr data-row-department="{{ $student->department ?? 'Unknown' }}">
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->roll_no }}</td>
                            <td>{{ $student->department ?? 'N/A' }}</td>
                            <td>{{ $student->semester ?? '-' }}</td>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const cards = document.querySelectorAll('.dept-card');
    const rows = document.querySelectorAll('#studentTableBody tr');
    const searchInput = document.getElementById('studentSearch');
    const clearButton = document.getElementById('clearFilter');
    let activeDepartment = null;

    const filterRows = () => {
        const term = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const matchesDept = !activeDepartment || row.dataset.rowDepartment === activeDepartment;
            const matchesTerm = row.textContent.toLowerCase().includes(term);
            row.style.display = matchesDept && matchesTerm ? '' : 'none';
        });
    };

    cards.forEach(card => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('active'));
            if (activeDepartment === card.dataset.department) {
                activeDepartment = null;
            } else {
                activeDepartment = card.dataset.department;
                card.classList.add('active');
            }
            filterRows();
        });
    });

    searchInput?.addEventListener('input', filterRows);

    clearButton?.addEventListener('click', () => {
        searchInput.value = '';
        activeDepartment = null;
        cards.forEach(c => c.classList.remove('active'));
        filterRows();
    });
</script>
@endpush

