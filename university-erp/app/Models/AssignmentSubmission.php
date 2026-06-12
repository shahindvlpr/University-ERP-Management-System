<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_date',
        'file_path',
        'comments',
        'marks',
        'feedback',
        'status',
        'graded_by',
        'graded_at'
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'graded_at' => 'datetime',
    ];

    // Relationship with Assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Teacher who graded
    public function grader()
    {
        return $this->belongsTo(Teacher::class, 'graded_by');
    }

    // Check if submission is late
    public function getIsLateAttribute()
    {
        return $this->submission_date && $this->submission_date->gt($this->assignment->due_date);
    }

    // Get grade letter based on marks
    public function getGradeLetterAttribute()
    {
        $marks = $this->marks;
        if ($marks >= 80) return 'A+';
        if ($marks >= 75) return 'A';
        if ($marks >= 70) return 'A-';
        if ($marks >= 65) return 'B+';
        if ($marks >= 60) return 'B';
        if ($marks >= 55) return 'B-';
        if ($marks >= 50) return 'C+';
        if ($marks >= 45) return 'C';
        if ($marks >= 40) return 'D';
        return 'F';
    }
}