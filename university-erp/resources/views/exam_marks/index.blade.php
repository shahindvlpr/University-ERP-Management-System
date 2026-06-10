@extends('layouts.app')

@section('title','Exam Marks')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">

    <h5 class="mb-0">

        <i class="bi bi-pencil-square"></i>

        Exam Marks

    </h5>

    <a href="{{ route('exam-marks.create') }}"
       class="btn btn-primary">

        Add Marks

    </a>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>

    <th>Student</th>
    <th>Exam</th>
    <th>Marks</th>
    <th>Remarks</th>
    <th width="180">Action</th>

</tr>

</thead>

<tbody>

@forelse($marks as $mark)

<tr>

    <td>{{ $mark->student->name }}</td>

    <td>{{ $mark->exam->title }}</td>

    <td>{{ $mark->marks }}</td>

    <td>{{ $mark->remarks }}</td>

    <td>

        <a href="{{ route('exam-marks.show',$mark->id) }}"
           class="btn btn-info btn-sm">

            View

        </a>

        <a href="{{ route('exam-marks.edit',$mark->id) }}"
           class="btn btn-warning btn-sm">

            Edit

        </a>

        <form method="POST"
              action="{{ route('exam-marks.destroy',$mark->id) }}"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm">

                Delete

            </button>

        </form>

    </td>

</tr>

@empty

<tr>

<td colspan="5"
    class="text-center">

    No Marks Found

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $marks->links() }}

</div>

</div>

@endsection