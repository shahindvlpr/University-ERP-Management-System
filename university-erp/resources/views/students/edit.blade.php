@extends('layouts.app')

@section('content')

<div class="card p-4">

<h3>Edit Student</h3>
@if($errors->any())

<div class="alert alert-danger">

<ul>

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif
<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('students.update',$student->id) }}">

@csrf
@method('PUT')

<div class="mb-3">
<label>Student ID</label>
<input type="text"
       name="student_id"
       value="{{ $student->student_id }}"
       class="form-control">
</div>

<div class="mb-3">
<label>Name</label>
<input type="text"
       name="name"
       value="{{ $student->name }}"
       class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
       name="email"
       value="{{ $student->email }}"
       class="form-control">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text"
       name="phone"
       value="{{ $student->phone }}"
       class="form-control">
</div>

<div class="mb-3">
<label>Department</label>

<select name="department_id" class="form-control">

@foreach($departments as $department)

<option value="{{ $department->id }}"
{{ $student->department_id == $department->id ? 'selected' : '' }}>
{{ $department->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">
<label>Session</label>
<input type="text"
       name="session"
       value="{{ $student->session }}"
       class="form-control">
</div>

<div class="mb-3">
<label>Semester</label>
<input type="number"
       name="semester"
       value="{{ $student->semester }}"
       class="form-control">
</div>

<div class="mb-3">

@if($student->photo)

<img src="{{ asset('storage/'.$student->photo) }}"
     width="100"
     class="mb-2">

@endif

<input type="file"
       name="photo"
       class="form-control">

</div>

<button class="btn btn-success">
Update Student
</button>

</form>

</div>

@endsection