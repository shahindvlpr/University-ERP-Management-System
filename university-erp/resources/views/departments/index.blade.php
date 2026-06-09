@extends('layouts.app')

@section('content')

<a href="{{ route('departments.create') }}"
   class="btn btn-primary mb-3">
    Add Department
</a>

<table class="table table-bordered">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Code</th>
    <th>Action</th>
</tr>

@foreach($departments as $department)

<tr>

<td>{{ $department->id }}</td>
<td>{{ $department->name }}</td>
<td>{{ $department->code }}</td>

<td>

<a href="{{ route('departments.edit',$department->id) }}"
   class="btn btn-warning btn-sm">
   Edit
</a>

<form method="POST"
      action="{{ route('departments.destroy',$department->id) }}"
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

@endsection