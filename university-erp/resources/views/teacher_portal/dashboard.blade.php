@extends('layouts.teacher_app')

@section('title','Teacher Dashboard')

@section('content')

<h2 class="mb-4">
    Welcome, {{ $teacher->name }}
</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h2>{{ $courseCount }}</h2>
                <p>My Courses</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h2>{{ $studentCount }}</h2>
                <p>My Students</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning">
            <div class="card-body">
                <h2>{{ $routineCount }}</h2>
                <p>My Classes</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h2>{{ $todayClasses }}</h2>
                <p>Today's Classes</p>
            </div>
        </div>
    </div>

</div>

@endsection