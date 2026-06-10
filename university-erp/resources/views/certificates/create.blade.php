@extends('layouts.app')

@section('title','Generate Certificate')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">

    Generate Certificate

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('certificates.store') }}">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

<label>Student</label>

<select name="student_id"
        class="form-select"
        required>

@foreach($students as $student)

<option value="{{ $student->id }}">

{{ $student->name }}
({{ $student->student_id }})

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Certificate Type</label>

<select name="certificate_type"
        class="form-select"
        required>

<option value="Transcript">
    Transcript
</option>

<option value="Completion">
    Completion
</option>

<option value="Character">
    Character
</option>

<option value="Provisional">
    Provisional
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Issue Date</label>

<input type="date"
       name="issue_date"
       class="form-control"
       required>

</div>

<div class="col-md-6 mb-3">

<label>Remarks</label>

<input type="text"
       name="remarks"
       class="form-control">

</div>

</div>

<button class="btn btn-success">

Generate Certificate

</button>

<a href="{{ route('certificates.index') }}"
   class="btn btn-secondary">

    Back

</a>

</form>

</div>

</div>

@endsection