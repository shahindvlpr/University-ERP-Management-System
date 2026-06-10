@extends('layouts.app')

@section('title','Enrollments')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

    <h5 class="mb-0">
        <i class="bi bi-journal-check"></i>
        Enrollment List
    </h5>

    <a href="{{ route('enrollments.create') }}"
       class="btn btn-primary">

        Add Enrollment

    </a>

</div>

<div class="card-body">

    <form method="GET" class="mb-3">

        <div class="input-group">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search Student">

            <button class="btn btn-primary">
                Search
            </button>

        </div>

    </form>

    <table class="table table-hover">

        <thead class="table-dark">

        <tr>

            <th>Student</th>
            <th>Course</th>
            <th>Session</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        </thead>

        <tbody>

        @forelse($enrollments as $enrollment)

        <tr>

            <td>{{ $enrollment->student->name }}</td>

            <td>{{ $enrollment->course->name }}</td>

            <td>{{ $enrollment->session }}</td>

            <td>{{ $enrollment->semester }}</td>

            <td>

                <span class="badge bg-success">
                    {{ ucfirst($enrollment->status) }}
                </span>

            </td>

            <td>

                <a href="{{ route('enrollments.show',$enrollment->id) }}"
                   class="btn btn-info btn-sm">

                    <i class="bi bi-eye"></i>

                </a>

                <a href="{{ route('enrollments.edit',$enrollment->id) }}"
                   class="btn btn-warning btn-sm">

                    <i class="bi bi-pencil"></i>

                </a>

                <form action="{{ route('enrollments.destroy',$enrollment->id) }}"
                      method="POST"
                      style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete Enrollment?')">

                        <i class="bi bi-trash"></i>

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6" class="text-center">
                No Enrollment Found
            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

    {{ $enrollments->links() }}

</div>

</div>

@endsection