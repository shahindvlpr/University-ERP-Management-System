@extends('layouts.app')

@section('content')

<div class="card p-4">
    <h3>Add Department</h3>

    <form method="POST" action="{{ route('departments.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">
            Save
        </button>

    </form>
</div>

@endsection