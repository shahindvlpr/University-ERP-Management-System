@extends('layouts.teacher_app')

@section('title','My Courses')

@section('content')

<div class="card">

    <div class="card-header">
        My Courses
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Semester</th>
            </tr>

            @foreach($courses as $course)

            <tr>
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->semester }}</td>
            </tr>

            @endforeach

        </table>

    </div>

</div>

@endsection