@extends('layouts.app')

@section('title', 'Courses')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-book"></i>
            Courses
        </h5>

        <a href="{{ route('courses.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Course

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
        @endif

        <form method="GET" class="mb-3">

            <div class="input-group">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search Course">

                <button class="btn btn-primary">
                    Search
                </button>

            </div>

        </form>

        <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Teacher</th>
                    <th>Credit</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($courses as $course)

                <tr>

                    <td>{{ $course->code }}</td>

                    <td>{{ $course->name }}</td>

                    <td>{{ $course->department->name ?? '' }}</td>

                    <td>{{ $course->teacher->name ?? '' }}</td>

                    <td>{{ $course->credit_hours }}</td>

                    <td>{{ $course->semester }}</td>

                    <td>

                        @if($course->status == 'active')

                        <span class="badge bg-success">
                            Active
                        </span>

                        @else

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('courses.show',$course->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="bi bi-eye"></i>

                        </a>

                        <a href="{{ route('courses.edit',$course->id) }}"
                           class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form method="POST"
                              action="{{ route('courses.destroy',$course->id) }}"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete Course?')">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">
                        No Courses Found
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        </div>

        {{ $courses->links() }}

    </div>

</div>

@endsection

