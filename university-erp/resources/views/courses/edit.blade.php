@extends('layouts.app')

@section('title','Edit Course')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-warning">
        <h5 class="mb-0">
            Edit Course
        </h5>
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('courses.update',$course->id) }}">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Course Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $course->name }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Course Code</label>
                    <input type="text"
                           name="code"
                           value="{{ $course->code }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">

                    <label>Department</label>

                    <select name="department_id"
                            class="form-control">

                        @foreach($departments as $department)

                        <option value="{{ $department->id }}"
                        {{ $course->department_id==$department->id?'selected':'' }}>

                            {{ $department->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Teacher</label>

                    <select name="teacher_id"
                            class="form-control">

                        @foreach($teachers as $teacher)

                        <option value="{{ $teacher->id }}"
                        {{ $course->teacher_id==$teacher->id?'selected':'' }}>

                            {{ $teacher->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Credit Hours</label>

                    <input type="number"
                           name="credit_hours"
                           value="{{ $course->credit_hours }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Semester</label>

                    <input type="number"
                           name="semester"
                           value="{{ $course->semester }}"
                           class="form-control">

                </div>

                <div class="col-md-12 mb-3">

                    <label>Description</label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ $course->description }}</textarea>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="active"
                        {{ $course->status=='active'?'selected':'' }}>
                            Active
                        </option>

                        <option value="inactive"
                        {{ $course->status=='inactive'?'selected':'' }}>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

            <button class="btn btn-success">

                <i class="bi bi-save"></i>
                Update Course

            </button>

        </form>

    </div>

</div>

@endsection

