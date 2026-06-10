@extends('layouts.app')

@section('title','Transcript')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">

            <i class="bi bi-file-earmark-text"></i>

            Student Transcript

        </h5>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>

            <tr>

                <th>Student ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Semester</th>
                <th width="120">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($students as $student)

            <tr>

                <td>
                    {{ $student->student_id }}
                </td>

                <td>
                    {{ $student->name }}
                </td>

                <td>
                    {{ $student->department->name ?? '-' }}
                </td>

                <td>
                    {{ $student->semester }}
                </td>

                <td>

                    <a href="{{ route('transcripts.show',$student->id) }}"
                       class="btn btn-info btn-sm">

                        View

                    </a>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5"
                    class="text-center">

                    No Student Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection