<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
    protected $fillable = [
        'job_card_id',
        'parts_total', 'works_total', 'service_total',
        'grand_total', 'vat', 'bill_amount', 'total_profit',
    ];

    public function items() {
        return $this->hasMany( InvoiceItem::class );
    }

    public function job() {
        return $this->belongsTo( JobCard::class, 'job_card_id' );
    }
}