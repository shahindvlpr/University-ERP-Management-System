<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function index()
    {
        $issues = BookIssue::with(['student','book'])
                    ->latest()
                    ->paginate(10);

        return view('book_issues.index', compact('issues'));
    }

    public function create()
    {
        $students = Student::all();

        $books = Book::where('available_quantity','>',0)
                    ->get();

        return view(
            'book_issues.create',
            compact('students','books')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'=>'required',
            'book_id'=>'required',
            'issue_date'=>'required',
            'return_date'=>'required'
        ]);

        BookIssue::create([
            'student_id'=>$request->student_id,
            'book_id'=>$request->book_id,
            'issue_date'=>$request->issue_date,
            'return_date'=>$request->return_date,
            'status'=>'issued'
        ]);

        $book = Book::find($request->book_id);

        $book->decrement('available_quantity');

        return redirect()
            ->route('book-issues.index')
            ->with('success','Book Issued Successfully');
    }

    public function show(BookIssue $book_issue)
    {
        //
    }

    public function edit(BookIssue $book_issue)
    {
        return view(
            'book_issues.edit',
            compact('book_issue')
        );
    }

    public function update(Request $request,
                           BookIssue $book_issue)
    {
        $fine = 0;

        if(now()->toDateString() >
           $book_issue->return_date)
        {
            $days = now()
                    ->diffInDays(
                        $book_issue->return_date
                    );

            $fine = $days * 10;
        }

        $book_issue->update([
            'actual_return_date'=>now(),
            'fine'=>$fine,
            'status'=>'returned'
        ]);

        $book = Book::find(
            $book_issue->book_id
        );

        $book->increment(
            'available_quantity'
        );

        return redirect()
            ->route('book-issues.index')
            ->with(
                'success',
                'Book Returned Successfully'
            );
    }

    public function destroy(BookIssue $book_issue)
    {
        $book_issue->delete();

        return back()
            ->with(
                'success',
                'Issue Deleted Successfully'
            );
    }
}