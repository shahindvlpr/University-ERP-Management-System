<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'student_id',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'photo',
        'session',
        'semester',
        'status',
        'blood_group'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }
    
    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }
    
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    
    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->name;
    }
    
    // Accessor for blood group display
    public function getBloodGroupDisplayAttribute()
    {
        $bloodGroups = [
            'A+' => 'A Positive',
            'A-' => 'A Negative',
            'B+' => 'B Positive',
            'B-' => 'B Negative',
            'O+' => 'O Positive',
            'O-' => 'O Negative',
            'AB+' => 'AB Positive',
            'AB-' => 'AB Negative',
        ];
        return $bloodGroups[$this->blood_group] ?? $this->blood_group ?? 'N/A';
    }
}