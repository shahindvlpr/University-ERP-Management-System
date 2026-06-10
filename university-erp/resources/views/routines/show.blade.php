@extends('layouts.app')

@section('title','Routine Details')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-info text-white">

    Routine Details

</div>

<div class="card-body">

    <p>
        <strong>Course:</strong>
        {{ $routine->course->name }}
    </p>

    <p>
        <strong>Teacher:</strong>
        {{ $routine->teacher->name }}
    </p>

    <p>
        <strong>Day:</strong>
        {{ $routine->day }}
    </p>

    <p>
        <strong>Time:</strong>
        {{ $routine->start_time }}
        -
        {{ $routine->end_time }}
    </p>

    <p>
        <strong>Room:</strong>
        {{ $routine->room_no }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $routine->status }}
    </p>

</div>

</div>

@endsection