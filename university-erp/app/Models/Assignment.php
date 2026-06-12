<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'teacher_id',
        'due_date',
        'total_marks',
        'status',
        'attachment',
        'instructions'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relationship with Submissions
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // Get total submissions count
    public function getSubmissionsCountAttribute()
    {
        return $this->submissions()->count();
    }

    // Get pending submissions count
    public function getPendingSubmissionsAttribute()
    {
        return $this->submissions()->where('status', 'pending')->count();
    }

    // Get graded submissions count
    public function getGradedSubmissionsAttribute()
    {
        return $this->submissions()->where('status', 'graded')->count();
    }

    // Check if assignment is overdue
    public function getIsOverdueAttribute()
    {
        return now()->gt($this->due_date);
    }

    // Get submission rate percentage
    public function getSubmissionRateAttribute()
    {
        $totalStudents = $this->course->enrollments()->count();
        if ($totalStudents == 0) return 0;
        
        return round(($this->submissions_count / $totalStudents) * 100);
    }
}