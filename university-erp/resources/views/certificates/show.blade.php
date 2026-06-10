@extends('layouts.app')

@section('title','Certificate')

@section('content')

<div class="card shadow-lg border-0">

<div class="card-body p-5">

<div class="text-center mb-4">

    <h2 class="fw-bold">

        UNIVERSITY ERP MANAGEMENT SYSTEM

    </h2>

    <h4>

        Certificate

    </h4>

</div>

<hr>

<div class="mt-4">

    <p>

        Certificate No:

        <strong>
            {{ $certificate->certificate_no }}
        </strong>

    </p>

    <p>

        This is to certify that

        <strong>
            {{ $certificate->student->name }}
        </strong>

        bearing Student ID

        <strong>
            {{ $certificate->student->student_id }}
        </strong>

        is hereby awarded the

        <strong>
            {{ $certificate->certificate_type }}
        </strong>

        Certificate.

    </p>

    <p>

        Issue Date:

        <strong>
            {{ $certificate->issue_date }}
        </strong>

    </p>

    <p>

        Remarks:

        {{ $certificate->remarks ?? 'N/A' }}

    </p>

</div>

<div class="row mt-5">

    <div class="col-6 text-start">

        ______________________

        <br>

        Registrar

    </div>

    <div class="col-6 text-end">

        ______________________

        <br>

        Vice Chancellor

    </div>

</div>

<div class="text-center mt-5">

    <button onclick="window.print()"
            class="btn btn-success">

        <i class="bi bi-printer"></i>

        Print Certificate

    </button>

</div>

</div>

</div>

@endsection