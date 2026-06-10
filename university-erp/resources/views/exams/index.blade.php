@extends('layouts.app')

@section('title','Exams')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="bi bi-journal-text"></i>
            Exam List

        </h5>

        <a href="{{ route('exams.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Exam

        </a>

    </div>

    <div class="card-body">

        <form method="GET"
              class="mb-3">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search Exam">

        </form>

        <table class="table table-bordered table-hover">

            <thead>

            <tr>

                <th>Title</th>
                <th>Course</th>
                <th>Type</th>
                <th>Date</th>
                <th>Total Marks</th>
                <th>Status</th>
                <th width="180">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($exams as $exam)

            <tr>

                <td>{{ $exam->title }}</td>

                <td>{{ $exam->course->name }}</td>

                <td>{{ $exam->exam_type }}</td>

                <td>{{ $exam->exam_date }}</td>

                <td>{{ $exam->total_marks }}</td>

                <td>

                    <span class="badge bg-success">

                        {{ $exam->status }}

                    </span>

                </td>

                <td>

                    <a href="{{ route('exams.show',$exam->id) }}"
                       class="btn btn-info btn-sm">

                        View

                    </a>

                    <a href="{{ route('exams.edit',$exam->id) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('exams.destroy',$exam->id) }}"
                          method="POST"
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

                <td colspan="7"
                    class="text-center">

                    No Exam Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        {{ $exams->links() }}

    </div>

</div>

@endsection