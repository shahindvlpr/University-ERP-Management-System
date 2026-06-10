<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_name',
        'book_code',
        'author',
        'publisher',
        'quantity',
        'available_quantity',
        'status'
    ];

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}