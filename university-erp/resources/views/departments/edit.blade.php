@extends('layouts.app')

@section('content')

<div class="card p-4">

<form method="POST"
      action="{{ route('departments.update',$department->id) }}">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text"
               name="name"
               value="{{ $department->name }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Code</label>
        <input type="text"
               name="code"
               value="{{ $department->code }}"
               class="form-control">
    </div>

    <button class="btn btn-success">
        Update
    </button>

</form>

</div>

@endsection