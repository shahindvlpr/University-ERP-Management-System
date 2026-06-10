@extends('layouts.app')

@section('title','Book Issues')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">

    <h5>
        Book Issues
    </h5>

    <a href="{{ route('book-issues.create') }}"
       class="btn btn-primary">

        Issue Book

    </a>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

    <th>Student</th>
    <th>Book</th>
    <th>Issue Date</th>
    <th>Return Date</th>
    <th>Status</th>
    <th>Fine</th>
    <th>Action</th>

</tr>

</thead>

<tbody>

@foreach($issues as $issue)

<tr>

<td>
    {{ $issue->student->name }}
</td>

<td>
    {{ $issue->book->book_name }}
</td>

<td>
    {{ $issue->issue_date }}
</td>

<td>
    {{ $issue->return_date }}
</td>

<td>

<span class="badge bg-success">

    {{ $issue->status }}

</span>

</td>

<td>

৳{{ $issue->fine }}

</td>

<td>

@if($issue->status=='issued')

<a href="{{ route('book-issues.edit',$issue->id) }}"
   class="btn btn-warning btn-sm">

    Return

</a>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $issues->links() }}

</div>

</div>

@endsection