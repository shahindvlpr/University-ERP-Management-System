@extends('layouts.app')

@section('title','Add Routine')

@section('content')

<div class="card">

<div class="card-header bg-primary text-white">

    Add Routine

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('routines.store') }}">

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

<label>Teacher</label>

<select name="teacher_id"
        class="form-select">

@foreach($teachers as $teacher)

<option value="{{ $teacher->id }}">

{{ $teacher->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Day</label>

<select name="day"
        class="form-select">

<option>Saturday</option>
<option>Sunday</option>
<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Room No</label>

<input type="text"
       name="room_no"
       class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Start Time</label>

<input type="time"
       name="start_time"
       class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>End Time</label>

<input type="time"
       name="end_time"
       class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select name="status"
        class="form-select">

<option value="active">
    Active
</option>

<option value="inactive">
    Inactive
</option>

</select>

</div>

</div>

<button class="btn btn-success">

Save Routine

</button>

</form>

</div>

</div>

@endsection