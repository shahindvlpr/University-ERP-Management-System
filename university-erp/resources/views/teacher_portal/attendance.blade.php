@extends('layouts.teacher_app')

@section('title','Attendance Management')

@section('content')

<div class="card">

    <div class="card-header">
        Attendance Management
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            Attendance records will be managed here.
        </div>

        <a href="{{ route('attendance.index') }}"
           class="btn btn-primary">
            Open Attendance Module
        </a>

    </div>

</div>

@endsection