@extends('layouts.app')

@section('title','Edit Exam')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-warning">

    Edit Exam

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('exams.update',$exam->id) }}">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">

<label>Course</label>

<select name="course_id"
        class="form-select">

@foreach($courses as $course)

<option value="{{ $course->id }}"
{{ $exam->course_id == $course->id ? 'selected' : '' }}>

{{ $course->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Title</label>

<input type="text"
       name="title"
       value="{{ $exam->title }}"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Total Marks</label>

<input type="number"
       name="total_marks"
       value="{{ $exam->total_marks }}"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Exam Date</label>

<input type="date"
       name="exam_date"
       value="{{ $exam->exam_date }}"
       class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Status</label>

<select name="status"
        class="form-select">

<option value="upcoming">

Upcoming

</option>

<option value="completed">

Completed

</option>

</select>

</div>

</div>

<button class="btn btn-success">

Update Exam

</button>

</form>

</div>

</div>

@endsection