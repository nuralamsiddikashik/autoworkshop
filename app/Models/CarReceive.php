<?php

namespace App\Models;

use App\Models\JobCard;
use Illuminate\Database\Eloquent\Model;

class CarReceive extends Model {

    protected $fillable = [
        'receive_no',
        'customer_id',
        'customer_car_id',
        'odometer',
        'note',
    ];

    public function customer() {
        return $this->belongsTo( \App\Models\Customer::class );
    }

    public function car() {
        return $this->belongsTo( \App\Models\CustomerCar::class, 'customer_car_id' );
    }

    public function jobCard() {
        return $this->hasOne( JobCard::class );
    }
}