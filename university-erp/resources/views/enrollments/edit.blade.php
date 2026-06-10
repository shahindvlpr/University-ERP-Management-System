@extends('layouts.app')

@section('title','Edit Enrollment')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">

        <h5 class="mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Enrollment
        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('enrollments.update',$enrollment->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Student
                    </label>

                    <select name="student_id"
                            class="form-select">

                        @foreach($students as $student)

                        <option value="{{ $student->id }}"
                        {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>

                            {{ $student->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Course
                    </label>

                    <select name="course_id"
                            class="form-select">

                        @foreach($courses as $course)

                        <option value="{{ $course->id }}"
                        {{ $enrollment->course_id == $course->id ? 'selected' : '' }}>

                            {{ $course->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Session
                    </label>

                    <input type="number"
                           name="session"
                           value="{{ $enrollment->session }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Semester
                    </label>

                    <input type="number"
                           name="semester"
                           value="{{ $enrollment->semester }}"
                           class="form-control">

                </div>

                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="enrolled"
                        {{ $enrollment->status=='enrolled'?'selected':'' }}>
                            Enrolled
                        </option>

                        <option value="completed"
                        {{ $enrollment->status=='completed'?'selected':'' }}>
                            Completed
                        </option>

                        <option value="dropped"
                        {{ $enrollment->status=='dropped'?'selected':'' }}>
                            Dropped
                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-success">
                Update Enrollment
            </button>

            <a href="{{ route('enrollments.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </form>

    </div>

</div>

@endsection