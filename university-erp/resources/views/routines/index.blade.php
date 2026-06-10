@extends('layouts.app')

@section('title','Routine List')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between">

    <h5>Routine List</h5>

    <a href="{{ route('routines.create') }}"
       class="btn btn-primary">

        Add Routine

    </a>

</div>

<div class="card-body">

<form method="GET" class="mb-3">

    <input type="text"
           name="search"
           class="form-control"
           placeholder="Search Course">

</form>

<table class="table table-bordered">

    <thead class="table-dark">

    <tr>

        <th>Course</th>
        <th>Teacher</th>
        <th>Day</th>
        <th>Time</th>
        <th>Room</th>
        <th>Status</th>
        <th>Action</th>

    </tr>

    </thead>

    <tbody>

    @foreach($routines as $routine)

    <tr>

        <td>{{ $routine->course->name }}</td>

        <td>{{ $routine->teacher->name }}</td>

        <td>{{ $routine->day }}</td>

        <td>
            {{ $routine->start_time }}
            -
            {{ $routine->end_time }}
        </td>

        <td>{{ $routine->room_no }}</td>

        <td>{{ $routine->status }}</td>

        <td>

            <a href="{{ route('routines.show',$routine->id) }}"
               class="btn btn-info btn-sm">

                View

            </a>

            <a href="{{ route('routines.edit',$routine->id) }}"
               class="btn btn-warning btn-sm">

                Edit

            </a>

            <form action="{{ route('routines.destroy',$routine->id) }}"
                  method="POST"
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

    </tbody>

</table>

{{ $routines->links() }}

</div>

</div>

@endsection