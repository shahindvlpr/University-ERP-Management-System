@extends('layouts.app')

@section('content')

<div class="card p-4">

<h3>Add Student</h3>
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
      action="{{ route('students.store') }}">

@csrf

<div class="mb-3">
<label>Student ID</label>
<input type="text"
       name="student_id"
       class="form-control">
</div>

<div class="mb-3">
<label>Name</label>
<input type="text"
       name="name"
       class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
       name="email"
       class="form-control">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text"
       name="phone"
       class="form-control">
</div>

<div class="mb-3">
<label>Department</label>

<select name="department_id"
        class="form-control">

@foreach($departments as $department)

<option value="{{ $department->id }}">
{{ $department->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">
<label>Session</label>
<input type="text"
       name="session"
       class="form-control">
</div>

<div class="mb-3">
<label>Semester</label>
<input type="number"
       name="semester"
       class="form-control">
</div>

<div class="mb-3">
<label>Photo</label>
<input type="file"
       name="photo"
       class="form-control">
</div>

<button class="btn btn-primary">
Save Student
</button>

</form>

</div>

@endsection