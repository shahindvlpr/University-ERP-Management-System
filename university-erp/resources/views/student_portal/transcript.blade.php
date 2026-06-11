@extends('layouts.student_app')

@section('title','My Transcript')

@section('content')

<div class="card">

<div class="card-header">

Academic Transcript

</div>

<div class="card-body">

<h5>

{{ $student->name }}

</h5>

<p>

Student ID:
{{ $student->student_id }}

</p>

<table class="table table-bordered">

<tr>

<th>Course</th>
<th>Grade</th>
<th>GPA</th>

</tr>

@foreach($results as $result)

<tr>

<td>

{{ $result->course->name }}

</td>

<td>

{{ $result->grade }}

</td>

<td>

{{ $result->gpa }}

</td>

</tr>

@endforeach

</table>

<button
onclick="window.print()"
class="btn btn-success">

Print Transcript

</button>

</div>

</div>

@endsection