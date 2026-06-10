<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'marks',
        'remarks'
    ];

   public function exam()
{
    return $this->belongsTo(
        Exam::class
    );
}

public function student()
{
    return $this->belongsTo(
        Student::class
    );
}
}