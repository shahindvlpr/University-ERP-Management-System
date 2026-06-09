<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_invoice_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'remarks'
    ];

    protected $casts = [
        'payment_date' => 'date'
    ];

    public function feeInvoice()
    {
        return $this->belongsTo(FeeInvoice::class);
    }
}