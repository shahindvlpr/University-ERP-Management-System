@extends('layouts.teacher_app')

@section('title','My Students')

@section('content')

<div class="card">

<div class="card-header">
Students
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th>Name</th>
<th>ID</th>
<th>Course</th>
</tr>

@foreach($students as $item)

<tr>
<td>{{ $item->student->name }}</td>
<td>{{ $item->student->student_id }}</td>
<td>{{ $item->course->name }}</td>
</tr>

@endforeach

</table>

</div>

</div>

@endsection