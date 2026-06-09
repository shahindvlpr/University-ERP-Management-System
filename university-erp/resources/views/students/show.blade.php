@extends('layouts.app')

@section('content')

<div class="card p-4">

<h3>Student Details</h3>

@if($student->photo)

<img src="{{ asset('storage/'.$student->photo) }}"
     width="150"
     class="mb-3">

@endif

<p><b>Name:</b> {{ $student->name }}</p>

<p><b>Student ID:</b> {{ $student->student_id }}</p>

<p><b>Email:</b> {{ $student->email }}</p>

<p><b>Phone:</b> {{ $student->phone }}</p>

<p><b>Department:</b>
{{ $student->department->name ?? '' }}
</p>

<p><b>Session:</b>
{{ $student->session }}
</p>

<p><b>Semester:</b>
{{ $student->semester }}
</p>

</div>

@endsection