<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'exam_name',
        'exam_date',
        'marks',
        'total_marks',
        'grade',
        'gpa',
        'teacher_id'
    ];

    protected $casts = [
        'exam_date' => 'date',
        'marks' => 'float',
        'total_marks' => 'integer',
        'gpa' => 'float'
    ];

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Get grade letter based on percentage
    public function getGradeLetterAttribute()
    {
        $percentage = ($this->marks / $this->total_marks) * 100;
        
        if ($percentage >= 80) return 'A+';
        if ($percentage >= 75) return 'A';
        if ($percentage >= 70) return 'A-';
        if ($percentage >= 65) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 55) return 'B-';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 45) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }
}