@extends('layouts.teacher_app')

@section('title','My Profile')

@section('content')

<div class="card">

<div class="card-body">

<h3>{{ $teacher->name }}</h3>

<p>Email: {{ $teacher->email }}</p>

<p>Teacher ID: {{ $teacher->teacher_id }}</p>

<p>Designation: {{ $teacher->designation }}</p>

<p>Department:
{{ $teacher->department->name }}
</p>

</div>

</div>

@endsection