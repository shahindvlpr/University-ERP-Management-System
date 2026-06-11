@extends('layouts.teacher_app')

@section('title','My Routine')

@section('content')

<table class="table table-bordered">

<tr>
<th>Course</th>
<th>Day</th>
<th>Time</th>
<th>Room</th>
</tr>

@foreach($routines as $routine)

<tr>
<td>{{ $routine->course->name }}</td>
<td>{{ $routine->day }}</td>
<td>
{{ $routine->start_time }}
-
{{ $routine->end_time }}
</td>
<td>{{ $routine->room_no }}</td>
</tr>

@endforeach

</table>

@endsection