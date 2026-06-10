@extends('layouts.app')

@section('title','My Attendance')

@section('content')

<div class="card">

<div class="card-header">

My Attendance

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Date</th>
<th>Course</th>
<th>Status</th>

</tr>

@foreach($attendances as $attendance)

<tr>

<td>{{ $attendance->date }}</td>

<td>{{ $attendance->course->name }}</td>

<td>

{{ ucfirst($attendance->status) }}

</td>

</tr>

@endforeach

</table>

{{ $attendances->links() }}

</div>

</div>

@endsection