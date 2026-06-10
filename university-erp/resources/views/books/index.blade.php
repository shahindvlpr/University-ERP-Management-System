@extends('layouts.app')

@section('title','Library Books')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-book-half"></i>
            Library Books
        </h5>

        <a href="{{ route('books.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Book

        </a>

    </div>

    <div class="card-body">

        <form method="GET" class="mb-3">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search Book">

        </form>

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>Book Code</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Available</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($books as $book)

            <tr>

                <td>{{ $book->book_code }}</td>

                <td>{{ $book->book_name }}</td>

                <td>{{ $book->author }}</td>

                <td>
                    {{ $book->available_quantity }}
                    /
                    {{ $book->quantity }}
                </td>

                <td>

                    <span class="badge bg-success">
                        {{ $book->status }}
                    </span>

                </td>

                <td>

                    <a href="{{ route('books.show',$book->id) }}"
                       class="btn btn-info btn-sm">

                        View

                    </a>

                    <a href="{{ route('books.edit',$book->id) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('books.destroy',$book->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="text-center">

                    No Books Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        {{ $books->links() }}

    </div>

</div>

@endsection