<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model {
    protected $fillable = [
        'payment_id',
        'invoice_id',
        'pay_amount',
        'discount_amount',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
     */

    // Detail → Payment
    public function payment() {
        return $this->belongsTo( Payment::class );
    }

    // Detail → Invoice
    public function invoice() {
        return $this->belongsTo( Invoice::class );
    }
}
