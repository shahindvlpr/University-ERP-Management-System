@extends('layouts.teacher_app')

@section('title','Results Management')

@section('content')

<div class="card">

    <div class="card-header">
        Result Management
    </div>

    <div class="card-body">

        <div class="alert alert-success">
            Manage student results from here.
        </div>

        <a href="{{ route('results.index') }}"
           class="btn btn-success">
            Open Results Module
        </a>

    </div>

</div>

@endsection