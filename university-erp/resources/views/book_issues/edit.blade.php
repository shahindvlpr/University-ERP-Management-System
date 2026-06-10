@extends('layouts.app')

@section('title','Return Book')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-warning">

    Return Book

</div>

<div class="card-body">

<table class="table">

<tr>

<th>Student</th>

<td>

{{ $book_issue->student->name }}

</td>

</tr>

<tr>

<th>Book</th>

<td>

{{ $book_issue->book->book_name }}

</td>

</tr>

<tr>

<th>Return Date</th>

<td>

{{ $book_issue->return_date }}

</td>

</tr>

</table>

<form method="POST"
      action="{{ route('book-issues.update',
      $book_issue->id) }}">

@csrf
@method('PUT')

<button class="btn btn-success">

Confirm Return

</button>

</form>

</div>

</div>

@endsection