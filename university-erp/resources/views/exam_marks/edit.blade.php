@extends('layouts.app')

@section('title','Edit Exam Marks')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-warning">

    Edit Exam Marks

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('exam-marks.update',$examMark->id) }}">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">

<label>Exam</label>

<select name="exam_id"
        class="form-select">

@foreach($exams as $exam)

<option value="{{ $exam->id }}"
{{ $examMark->exam_id == $exam->id ? 'selected' : '' }}>

{{ $exam->title }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Student</label>

<select name="student_id"
        class="form-select">

@foreach($students as $student)

<option value="{{ $student->id }}"
{{ $examMark->student_id == $student->id ? 'selected' : '' }}>

{{ $student->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Marks</label>

<input type="number"
       step="0.01"
       name="marks"
       value="{{ $examMark->marks }}"
       class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Remarks</label>

<input type="text"
       name="remarks"
       value="{{ $examMark->remarks }}"
       class="form-control">

</div>

</div>

<button class="btn btn-success">

Update Marks

</button>

</form>

</div>

</div>

@endsection