@extends('layouts.app')

@section('title','Exam Details')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-info text-white">

    Exam Details

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Title</th>

<td>{{ $exam->title }}</td>

</tr>

<tr>

<th>Course</th>

<td>{{ $exam->course->name }}</td>

</tr>

<tr>

<th>Type</th>

<td>{{ $exam->exam_type }}</td>

</tr>

<tr>

<th>Date</th>

<td>{{ $exam->exam_date }}</td>

</tr>

<tr>

<th>Total Marks</th>

<td>{{ $exam->total_marks }}</td>

</tr>

<tr>

<th>Session</th>

<td>{{ $exam->session }}</td>

</tr>

<tr>

<th>Semester</th>

<td>{{ $exam->semester }}</td>

</tr>

<tr>

<th>Status</th>

<td>{{ $exam->status }}</td>

</tr>

</table>

<a href="{{ route('exams.index') }}"
   class="btn btn-secondary">

    Back

</a>

</div>

</div>

@endsection