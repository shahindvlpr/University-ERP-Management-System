<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::when($request->search, function ($query) use ($request) {

            $query->where('book_name', 'like', '%' . $request->search . '%')
                  ->orWhere('book_code', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');

        })
        ->latest()
        ->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_name' => 'required',
            'book_code' => 'required|unique:books',
            'author' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        Book::create([
            'book_name' => $request->book_name,
            'book_code' => $request->book_code,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'quantity' => $request->quantity,
            'available_quantity' => $request->quantity,
            'status' => 'available',
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book Added Successfully');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'book_name' => 'required',
            'author' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $book->update([
            'book_name' => $request->book_name,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book Updated Successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book Deleted Successfully');
    }
}