<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'teacher_id',
        'name',
        'code',
        'description',
        'credit_hours',
        'semester',
        'status'
    ];

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relationship with Enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relationship with Attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relationship with Results
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    // Relationship with Routines
    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    // Relationship with Exams
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Relationship with Exam Marks
    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }

    // ========== ADD THESE MISSING RELATIONSHIPS ==========

    // Relationship with Assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Relationship with Students through Enrollments
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->withTimestamps();
    }

    // ========== HELPER METHODS ==========

    // Get total enrolled students count
    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'enrolled')->count();
    }

    // Get total active students count
    public function getActiveStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    // Calculate attendance rate for this course
    public function getAttendanceRateAttribute()
    {
        $totalClasses = $this->attendances()->distinct('date')->count('date');
        if ($totalClasses == 0) return 0;
        
        $totalStudents = $this->enrollments()->count();
        if ($totalStudents == 0) return 0;
        
        $presentCount = $this->attendances()->where('status', 'present')->count();
        return round(($presentCount / ($totalClasses * $totalStudents)) * 100);
    }

    // Calculate average performance for this course
    public function getAveragePerformanceAttribute()
    {
        $avgMarks = $this->results()->avg('marks');
        return round($avgMarks ?? 0, 2);
    }

    // Get course progress percentage (based on syllabus completion)
    public function getProgressAttribute()
    {
        // You can implement this based on your syllabus/topic structure
        // For now, returning a default value
        return 50;
    }

    // Get assignment count
    public function getAssignmentsCountAttribute()
    {
        return $this->assignments()->count();
    }

    // Get pending assignments count
    public function getPendingAssignmentsCountAttribute()
    {
        return $this->assignments()->where('status', 'pending')
            ->where('due_date', '>=', now())
            ->count();
    }

    // Check if course is active
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    // Get course completion percentage
    public function getCompletionPercentageAttribute()
    {
        $totalTopics = 0; // Get from syllabus table
        $completedTopics = 0; // Get from syllabus table
        return $totalTopics > 0 ? round(($completedTopics / $totalTopics) * 100) : 0;
    }
}