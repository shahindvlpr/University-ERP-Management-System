@extends('layouts.app')

@section('title','Add Enrollment')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    Create Enrollment

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('enrollments.store') }}">

    @csrf

    <div class="row">

        <div class="col-md-6 mb-3">

            <label>Student</label>

            <select name="student_id"
                    class="form-select"
                    required>

                <option value="">
                    Select Student
                </option>

                @foreach($students as $student)

                <option value="{{ $student->id }}">
                    {{ $student->name }}
                </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-6 mb-3">

            <label>Course</label>

            <select name="course_id"
                    class="form-select"
                    required>

                <option value="">
                    Select Course
                </option>

                @foreach($courses as $course)

                <option value="{{ $course->id }}">
                    {{ $course->name }}
                </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-6 mb-3">

            <label>Session</label>

            <input type="number"
                   name="session"
                   value="{{ date('Y') }}"
                   class="form-control">

        </div>

        <div class="col-md-6 mb-3">

            <label>Semester</label>

            <input type="number"
                   name="semester"
                   class="form-control">

        </div>

    </div>

    <button class="btn btn-success">

        Save Enrollment

    </button>

</form>

</div>

</div>

@endsection