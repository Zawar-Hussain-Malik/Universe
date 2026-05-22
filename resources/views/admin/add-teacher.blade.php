@extends('admin.layout')

@section('title', 'Add Teacher | UniVerse Admin')

@section('content')
    <div class="content">
        <h2>Add Single Teacher</h2>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.teacher.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            <div class="grid">
                <label>Name<span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required />

                <label>Email<span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required />

                <label>Password (optional)</label>
                <input type="password" name="password" placeholder="leave blank for default" />

                <label>Designation</label>
                <input type="text" name="designation" value="{{ old('designation') }}" />

                <label>Department<span class="required">*</span></label>
                <input type="text" name="department" value="{{ old('department') }}" required />

                <label>Photo (optional)</label>
                <input type="file" name="photo" accept="image/*" />
            </div>

            <div style="margin-top:16px">
                <button type="submit" class="btn">Create Teacher</button>
                <a href="{{ route('admin.adminteacher') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
