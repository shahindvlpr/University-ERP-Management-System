@extends('layouts.app')

@section('title','Reports')

@section('content')

<div class="row g-4">

    <div class="col-md-3">

        <div class="card text-center p-4">

            <h2>{{ $data['students'] }}</h2>

            <p>Total Students</p>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center p-4">

            <h2>{{ $data['teachers'] }}</h2>

            <p>Total Teachers</p>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center p-4">

            <h2>{{ $data['courses'] }}</h2>

            <p>Total Courses</p>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center p-4">

            <h2>{{ $data['results'] }}</h2>

            <p>Total Results</p>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card p-4">

            <h5>Attendance Summary</h5>

            <hr>

            <p>
                Present:
                <strong>
                    {{ $data['attendance_present'] }}
                </strong>
            </p>

            <p>
                Absent:
                <strong>
                    {{ $data['attendance_absent'] }}
                </strong>
            </p>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card p-4">

            <h5>Fee Summary</h5>

            <hr>

            <p>
                Collected:
                <strong>
                    ৳{{ number_format($data['fees_collected']) }}
                </strong>
            </p>

            <p>
                Due:
                <strong>
                    ৳{{ number_format($data['fees_due']) }}
                </strong>
            </p>

        </div>

    </div>

</div>

@endsection