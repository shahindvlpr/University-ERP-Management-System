@extends('layouts.app')

@section('title','Results')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5 class="mb-0">
            Student Results
        </h5>

        <a href="{{ route('results.create') }}"
           class="btn btn-primary">

            Add Result

        </a>

    </div>

    <div class="card-body">

        <form method="GET" class="mb-3">

            <div class="input-group">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search Student"
                       value="{{ request('search') }}">

                <button class="btn btn-primary">
                    Search
                </button>

            </div>

        </form>

        <div class="table-responsive">

        <table class="table table-hover">

            <thead class="table-dark">

                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                    <th>GPA</th>
                    <th>Semester</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($results as $result)

                <tr>

                    <td>
                        {{ $result->student->name }}
                    </td>

                    <td>
                        {{ $result->course->name }}
                    </td>

                    <td>
                        {{ $result->total_marks }}
                    </td>

                    <td>

                        <span class="badge bg-success">
                            {{ $result->grade }}
                        </span>

                    </td>

                    <td>

                        <span class="badge bg-primary">
                            {{ $result->gpa }}
                        </span>

                    </td>

                    <td>
                        {{ $result->semester }}
                    </td>

                    <td>

                        <a href="{{ route('results.show',$result->id) }}"
                           class="btn btn-info btn-sm">

                            View

                        </a>

                        <a href="{{ route('results.edit',$result->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form method="POST"
                              action="{{ route('results.destroy',$result->id) }}"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete Result?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7"
                        class="text-center">

                        No Results Found

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        </div>

        {{ $results->links() }}

    </div>

</div>

@endsection
