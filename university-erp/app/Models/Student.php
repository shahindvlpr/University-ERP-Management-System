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
        'status'
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
}