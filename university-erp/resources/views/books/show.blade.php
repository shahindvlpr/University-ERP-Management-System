@extends('layouts.app')

@section('title','Book Details')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-info text-white">

        Book Details

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>Book Name</th>
                <td>{{ $book->book_name }}</td>
            </tr>

            <tr>
                <th>Book Code</th>
                <td>{{ $book->book_code }}</td>
            </tr>

            <tr>
                <th>Author</th>
                <td>{{ $book->author }}</td>
            </tr>

            <tr>
                <th>Publisher</th>
                <td>{{ $book->publisher }}</td>
            </tr>

            <tr>
                <th>Quantity</th>
                <td>{{ $book->quantity }}</td>
            </tr>

            <tr>
                <th>Available</th>
                <td>{{ $book->available_quantity }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $book->status }}</td>
            </tr>

        </table>

        <a href="{{ route('books.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

@endsection