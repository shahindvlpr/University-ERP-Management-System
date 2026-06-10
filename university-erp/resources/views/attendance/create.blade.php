@extends('layouts.app')

@section('title','Add Attendance')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        Add Attendance
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('attendance.store') }}">

            @csrf

            <div class="mb-3">

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

            <div class="mb-3">

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

            <div class="mb-3">

                <label>Date</label>

                <input type="date"
                       name="date"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Status</label>

                <select name="status"
                        class="form-control">

                    <option value="present">
                        Present
                    </option>

                    <option value="absent">
                        Absent
                    </option>

                    <option value="late">
                        Late
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Remarks</label>

                <textarea name="remarks"
                          class="form-control"></textarea>

            </div>

            <button class="btn btn-primary">
                Save Attendance
            </button>

        </form>

    </div>

</div>

@endsection