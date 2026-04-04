<?php

namespace App\Models;

use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = [
        'customer_id',
        'total_paid',
        'total_discount',
        'payment_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
     */

    // Payment → Customer
    public function customer() {
        return $this->belongsTo( Customer::class );
    }

    // Payment → Payment Details
    public function details() {
        return $this->hasMany( PaymentDetail::class );
    }
}