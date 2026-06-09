<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'invoice_no',
        'amount',
        'paid_amount',
        'due_amount',
        'due_date',
        'status',
        'fee_type',
        'session',
        'semester',
        'remarks'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}