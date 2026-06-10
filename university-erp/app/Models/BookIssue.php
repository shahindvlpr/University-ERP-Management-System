<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'book_id',
        'issue_date',
        'return_date',
        'actual_return_date',
        'fine',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}