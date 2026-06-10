<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [

        'student_id',
        'certificate_no',
        'certificate_type',
        'issue_date',
        'remarks'

    ];

    public function student()
    {
        return $this->belongsTo(
            Student::class
        );
    }
}