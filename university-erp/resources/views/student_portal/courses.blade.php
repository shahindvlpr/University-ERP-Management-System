@extends('layouts.app')

@section('title','My Courses')

@section('content')

<div class="card">

<div class="card-header">

My Courses

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Course Code</th>
<th>Course Name</th>
<th>Status</th>

</tr>

@foreach($courses as $course)

<tr>

<td>

{{ $course->course->code }}

</td>

<td>

{{ $course->course->name }}

</td>

<td>

{{ $course->status }}

</td>

</tr>

@endforeach

</table>

{{ $courses->links() }}

</div>

</div>

@endsection