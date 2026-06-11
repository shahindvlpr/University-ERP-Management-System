@extends('layouts.student_app')

@section('title','My Results')

@section('content')

<div class="card">

<div class="card-header">

My Results

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Course</th>
<th>Total</th>
<th>Grade</th>
<th>GPA</th>

</tr>

@foreach($results as $result)

<tr>

<td>

{{ $result->course->name }}

</td>

<td>

{{ $result->total_marks }}

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

{{ $results->links() }}

</div>

</div>

@endsection