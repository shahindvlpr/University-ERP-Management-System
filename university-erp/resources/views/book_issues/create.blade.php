@extends('layouts.app')

@section('title','Issue Book')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    Issue Book

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('book-issues.store') }}">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

<label>Student</label>

<select name="student_id"
        class="form-select">

@foreach($students as $student)

<option value="{{ $student->id }}">

{{ $student->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Book</label>

<select name="book_id"
        class="form-select">

@foreach($books as $book)

<option value="{{ $book->id }}">

{{ $book->book_name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Issue Date</label>

<input type="date"
       name="issue_date"
       class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Return Date</label>

<input type="date"
       name="return_date"
       class="form-control">

</div>

</div>

<button class="btn btn-success">

Issue Book

</button>

</form>

</div>

</div>

@endsection