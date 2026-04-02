<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model {
    protected $fillable = [
        'invoice_id', 'type', 'name', 'buy_price', 'qty', 'unit',
        'unit_price', 'sell_price', 'total', 'profit',
    ];
}
