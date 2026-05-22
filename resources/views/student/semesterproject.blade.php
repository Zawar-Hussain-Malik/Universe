@extends('student.layout')

@section('title', $course->name . ' - Semester Project')

@section('content')
<div class="main-content">
    <div class="header-row">
        <a href="{{ route('student.courses.show', $course->code) }}" class="back-btn">← Back</a>
        <h3>Semester Project - {{ $course->name }}</h3>
        <div class="spacer"></div>
    </div>

    <div class="project-card">
        <div class="project-title">{{ $course->name }} - Semester Project</div>
        <div class="project-date">Course: {{ $course->code }} | Instructor: {{ $course->teacher->user->name ?? 'N/A' }}</div>

        <div class="project-details">
            Your semester project for this course. Please review the requirements and submit your project files before the deadline.
        </div>

        <div class="instructions">
            ✅ Review project requirements from your instructor<br>
            ✅ Prepare all necessary files and documentation<br>
            ✅ Ensure files are properly formatted and named<br>
            ✅ Upload project files before the submission deadline
        </div>

        <form id="projectForm" onsubmit="return false;">
            <div class="upload-box">
                <input type="file" id="projectFile" accept=".zip,.rar,.7z">
                <button type="button" onclick="uploadProject()">Upload Project</button>
            </div>
            <div class="uploaded" id="uploadMsg"></div>
        </form>

        <div class="note">
            ⚠️ Please upload a ZIP file containing all your project files.  
            File name format: <b>RegNo_Name_Project.zip</b>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function uploadProject() {
        const fileInput = document.getElementById("projectFile");
        const msg = document.getElementById("uploadMsg");
        const btn = document.querySelector(".upload-box button");
        
        if(fileInput.files.length === 0){
            alert("Please select your project file before uploading!");
            return;
        }
        
        const fileName = fileInput.files[0].name;
        msg.innerHTML = `✅ ${fileName} uploaded successfully! (Note: Backend upload functionality pending)`;
        btn.disabled = true;
        btn.innerText = "Uploaded";
        btn.classList.add('uploaded');
    }
</script>
@endpush

