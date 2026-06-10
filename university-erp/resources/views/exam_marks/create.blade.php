@extends('layouts.app')

@section('title','Add Exam Marks')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    Add Exam Marks

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('exam-marks.store') }}">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

<label>Exam</label>

<select name="exam_id"
        class="form-select"
        required>

@foreach($exams as $exam)

<option value="{{ $exam->id }}">

{{ $exam->title }}

({{ $exam->exam_type }})

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Student</label>

<select name="student_id"
        class="form-select"
        required>

@foreach($students as $student)

<option value="{{ $student->id }}">

{{ $student->name }}

({{ $student->student_id }})

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Marks</label>

<input type="number"
       step="0.01"
       name="marks"
       class="form-control"
       required>

</div>

<div class="col-md-6 mb-3">

<label>Remarks</label>

<input type="text"
       name="remarks"
       class="form-control">

</div>

</div>

<button class="btn btn-success">

Save Marks

</button>

<a href="{{ route('exam-marks.index') }}"
   class="btn btn-secondary">

    Back

</a>

</form>

</div>

</div>

@endsection