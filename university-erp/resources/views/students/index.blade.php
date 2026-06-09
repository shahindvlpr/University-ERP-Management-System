@extends('layouts.app')

@section('content')

<a href="{{ route('students.create') }}"
   class="btn btn-primary mb-3">
Add Student
</a>

<form method="GET"
      class="mb-3">

<div class="row">

<div class="col-md-4">

<input type="text"
       name="search"
       value="{{ request('search') }}"
       class="form-control"
       placeholder="Search Student">

</div>

<div class="col-md-2">

<button class="btn btn-primary">
Search
</button>

</div>

</div>

</form>


<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Photo</th>
<th>Name</th>
<th>Student ID</th>
<th>Department</th>
<th>Action</th>
</tr>

@foreach($students as $student)

<tr>

<td>{{ $student->id }}</td>

<td>
@if($student->photo)
<img src="{{ asset('storage/'.$student->photo) }}"
     width="50">
@endif
</td>

<td>{{ $student->name }}</td>

<td>{{ $student->student_id }}</td>

<td>{{ $student->department->name ?? '' }}</td>

<td>
<a href="{{ route('students.show',$student->id) }}"
   class="btn btn-info btn-sm">
View
</a>

<a href="{{ route('students.edit',$student->id) }}"
   class="btn btn-warning btn-sm">
Edit
</a>

<form method="POST"
      action="{{ route('students.destroy',$student->id) }}"
      style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

{{ $students->links() }}

@endsection