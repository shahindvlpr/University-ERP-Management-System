@extends('layouts.app')

@section('title','Exam Mark Details')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-info text-white">

    Exam Mark Details

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

    <th>Student</th>

    <td>{{ $examMark->student->name }}</td>

</tr>

<tr>

    <th>Student ID</th>

    <td>{{ $examMark->student->student_id }}</td>

</tr>

<tr>

    <th>Exam</th>

    <td>{{ $examMark->exam->title }}</td>

</tr>

<tr>

    <th>Exam Type</th>

    <td>{{ $examMark->exam->exam_type }}</td>

</tr>

<tr>

    <th>Marks</th>

    <td>{{ $examMark->marks }}</td>

</tr>

<tr>

    <th>Remarks</th>

    <td>{{ $examMark->remarks }}</td>

</tr>

</table>

<a href="{{ route('exam-marks.index') }}"
   class="btn btn-secondary">

    Back

</a>

</div>

</div>

@endsection