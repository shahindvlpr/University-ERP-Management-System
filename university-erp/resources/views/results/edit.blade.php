@extends('layouts.app')

@section('title','Edit Result')

@section('content')

<div class="card shadow-sm">


<div class="card-header bg-warning text-dark">
    <h5 class="mb-0">
        <i class="bi bi-pencil-square"></i>
        Edit Result
    </h5>
</div>

<div class="card-body">

    <form method="POST"
          action="{{ route('results.update',$result->id) }}">

        @csrf
        @method('PUT')

        <div class="row">

            <!-- Student -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Student
                </label>

                <select name="student_id"
                        class="form-select"
                        required>

                    @foreach($students as $student)

                    <option value="{{ $student->id }}"
                        {{ $result->student_id == $student->id ? 'selected' : '' }}>

                        {{ $student->name }}
                        ({{ $student->student_id }})

                    </option>

                    @endforeach

                </select>

            </div>

            <!-- Course -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Course
                </label>

                <select name="course_id"
                        class="form-select"
                        required>

                    @foreach($courses as $course)

                    <option value="{{ $course->id }}"
                        {{ $result->course_id == $course->id ? 'selected' : '' }}>

                        {{ $course->name }}
                        ({{ $course->code }})

                    </option>

                    @endforeach

                </select>

            </div>

            <!-- Midterm -->

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Midterm Marks
                </label>

                <input type="number"
                       name="midterm_marks"
                       value="{{ $result->midterm_marks }}"
                       class="form-control"
                       required>

            </div>

            <!-- Final -->

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Final Marks
                </label>

                <input type="number"
                       name="final_marks"
                       value="{{ $result->final_marks }}"
                       class="form-control"
                       required>

            </div>

            <!-- Assignment -->

            <div class="col-md-4 mb-3">

                <label class="form-label">
                    Assignment Marks
                </label>

                <input type="number"
                       name="assignment_marks"
                       value="{{ $result->assignment_marks }}"
                       class="form-control"
                       required>

            </div>

            <!-- Session -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Session
                </label>

                <input type="number"
                       name="session"
                       value="{{ $result->session }}"
                       class="form-control"
                       required>

            </div>

            <!-- Semester -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Semester
                </label>

                <input type="number"
                       name="semester"
                       value="{{ $result->semester }}"
                       class="form-control"
                       required>

            </div>

        </div>

        <button class="btn btn-success">
            <i class="bi bi-check-circle"></i>
            Update Result
        </button>

        <a href="{{ route('results.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </form>

</div>


</div>

@endsection
