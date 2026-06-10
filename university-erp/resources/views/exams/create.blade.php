@extends('layouts.app')

@section('title','Create Exam')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    Create Exam

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('exams.store') }}">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

<label>Course</label>

<select name="course_id"
        class="form-select">

@foreach($courses as $course)

<option value="{{ $course->id }}">

{{ $course->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Exam Title</label>

<input type="text"
       name="title"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Exam Type</label>

<select name="exam_type"
        class="form-select">

<option>Midterm</option>
<option>Final</option>
<option>Quiz</option>
<option>Assignment</option>
<option>Viva</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label>Exam Date</label>

<input type="date"
       name="exam_date"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Total Marks</label>

<input type="number"
       name="total_marks"
       class="form-control">

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

Save Exam

</button>

</form>

</div>

</div>

@endsection