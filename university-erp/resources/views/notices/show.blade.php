@extends('layouts.app')

@section('title','Notice Details')

@section('content')

<div class="card shadow-sm">

<div class="card-header bg-info text-white">

    <h5 class="mb-0">
        Notice Details
    </h5>

</div>

<div class="card-body">

    <h3>{{ $notice->title }}</h3>

    <hr>

    <p>

        <strong>Category:</strong>

        <span class="badge bg-primary">
            {{ ucfirst($notice->category) }}
        </span>

    </p>

    <p>

        <strong>Audience:</strong>

        {{ ucfirst($notice->audience) }}

    </p>

    <p>

        <strong>Publish Date:</strong>

        {{ $notice->publish_date->format('d M Y') }}

    </p>

    <p>

        <strong>Expire Date:</strong>

        {{ $notice->expire_date ? $notice->expire_date->format('d M Y') : 'N/A' }}

    </p>

    <hr>

    <h5>Notice Content</h5>

    <p>{{ $notice->content }}</p>

    <a href="{{ route('notices.index') }}"
       class="btn btn-secondary">

        Back

    </a>

</div>

</div>

@endsection