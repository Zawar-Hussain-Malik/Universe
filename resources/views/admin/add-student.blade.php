use Illuminate\Support\Facades\Storage;

@extends('admin.layout')

@section('title', 'Add Student | UniVerse Admin')

@section('content')
    <div class="content">
        <h2>Add Single Student</h2>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.student.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            <div class="grid">
                <label>Name<span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required />

                <label>Email<span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required />

                <label>Password (optional)</label>
                <input type="password" name="password" placeholder="leave blank for default" />

                <label>Roll No<span class="required">*</span></label>
                <input type="text" name="roll_no" value="{{ old('roll_no') }}" required />

                <label>Department<span class="required">*</span></label>
                <input type="text" name="department" value="{{ old('department') }}" required />

                <label>Semester<span class="required">*</span></label>
                <input type="text" name="semester" value="{{ old('semester') }}" required />

                <label>Section</label>
                <input type="text" name="section" value="{{ old('section') }}" />

                <label>Father Name</label>
                <input type="text" name="father_name" value="{{ old('father_name') }}" />

                <label>Date of Birth</label>
                <input type="date" name="dob" value="{{ old('dob') }}" />

                <label>City</label>
                <input type="text" name="city" value="{{ old('city') }}" />

                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" />

                <label>Blood Group</label>
                <input type="text" name="blood_group" value="{{ old('blood_group') }}" />

                <label>Profile Photo (optional)</label>
                <input type="file" name="profile_pic" accept="image/*" />
            </div>

            <div style="margin-top:16px">
                <button type="submit" class="btn">Create Student</button>
                <a href="{{ route('admin.adminstudent') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
