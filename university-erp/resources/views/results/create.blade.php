@extends('layouts.app')

@section('title','Add Result')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        Add Student Result
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('results.store') }}">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Student</label>

                    <select name="student_id"
                            class="form-control">

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
                            class="form-control">

                        @foreach($courses as $course)

                        <option value="{{ $course->id }}">
                            {{ $course->name }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Midterm Marks</label>
                    <input type="number"
                           name="midterm_marks"
                           class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Final Marks</label>
                    <input type="number"
                           name="final_marks"
                           class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Assignment Marks</label>
                    <input type="number"
                           name="assignment_marks"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Session</label>
                    <input type="number"
                           name="session"
                           class="form-control"
                           value="{{ date('Y') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Semester</label>
                    <input type="number"
                           name="semester"
                           class="form-control">
                </div>

            </div>

            <button class="btn btn-primary">
                Save Result
            </button>

        </form>

    </div>

</div>

@endsection
