@extends('student.layout')

@section('title', 'Assignments')

@section('content')
    <div class="main">
        <div class="header-section">
            <div>
                <h3>Assignments</h3>
                <p class="text-muted">Track submissions and due dates.</p>
            </div>
            @if ($filterCourse)
                <span class="filter-pill">Filtered: {{ $filterCourse->code }} — {{ $filterCourse->name }}</span>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($assignments->isEmpty())
            <div class="empty">
                No assignments available.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Your Submission</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        @php
                            $submission = $assignment->submissions->where('student_id', auth()->user()->student->id)->first();
                        @endphp
                        <tr>
                            <td>{{ $assignment->course->code }}</td>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ optional($assignment->due_date)->format('d M, Y') ?? 'TBA' }}</td>
                            <td>
                                <span class="badge {{ optional($assignment->due_date)->isPast() ? 'due' : 'open' }}">
                                    {{ optional($assignment->due_date)->isPast() ? 'Past Due' : 'Open' }}
                                </span>
                            </td>
                            <td>
                                @if($submission)
                                    <span class="badge" style="background: #28a745;">Submitted</span>
                                    <small class="text-muted d-block">{{ $submission->created_at->format('d M, Y H:i') }}</small>
                                @else
                                    <span class="badge" style="background: #6c757d;">Not Submitted</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    {{-- Download Assignment File --}}
                                    @if($assignment->file_path)
                                        <a href="{{ route('student.assignment.download', $assignment->id) }}" 
                                           class="btn btn-sm btn-primary" 
                                           title="Download Assignment">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif

                                    {{-- Upload/Resubmit Button --}}
                                    @if(!optional($assignment->due_date)->isPast() || !$assignment->due_date)
                                        <button type="button" 
                                                class="btn btn-sm btn-success" 
                                                onclick="openUploadModal({{ $assignment->id }}, '{{ $assignment->title }}', {{ $submission ? 'true' : 'false' }})"
                                                title="{{ $submission ? 'Resubmit Assignment' : 'Submit Assignment' }}">
                                            <i class="fas fa-upload"></i> {{ $submission ? 'Resubmit' : 'Submit' }}
                                        </button>
                                    @endif

                                    {{-- Download Submission --}}
                                    @if($submission && $submission->file_path)
                                        <a href="{{ route('student.assignment.submission.download', $submission->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Download Your Submission">
                                            <i class="fas fa-file-download"></i> Your File
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $assignments->links() }}
        @endif
    </div>

    {{-- Upload Modal --}}
    <div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 30px; border-radius: 8px; max-width: 500px; width: 90%;">
            <h4 id="modalTitle">Submit Assignment</h4>
            <p class="text-muted" id="modalSubtitle"></p>

            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin: 20px 0;">
                    <label for="submission_file" style="display: block; margin-bottom: 8px; font-weight: 500;">
                        Choose File (PDF, DOC, DOCX, ZIP - Max 10MB)
                    </label>
                    <input type="file" 
                           name="submission_file" 
                           id="submission_file" 
                           accept=".pdf,.doc,.docx,.zip"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin: 20px 0;">
                    <label for="comments" style="display: block; margin-bottom: 8px; font-weight: 500;">
                        Comments (Optional)
                    </label>
                    <textarea name="comments" 
                              id="comments" 
                              rows="3"
                              placeholder="Add any notes about your submission..."
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" 
                            onclick="closeUploadModal()" 
                            class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Submission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUploadModal(assignmentId, title, isResubmit) {
            const modal = document.getElementById('uploadModal');
            const form = document.getElementById('uploadForm');
            const modalTitle = document.getElementById('modalTitle');
            const modalSubtitle = document.getElementById('modalSubtitle');

            form.action = `/student/assignments/${assignmentId}/submit`;
            modalTitle.textContent = isResubmit ? 'Resubmit Assignment' : 'Submit Assignment';
            modalSubtitle.textContent = title;
            
            // Reset form
            form.reset();
            
            modal.style.display = 'flex';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('uploadModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUploadModal();
            }
        });
    </script>

    <style>
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-info {
            background: #17a2b8;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection