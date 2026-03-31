<?php

use App\Models\Customer;
use App\Models\CustomerCar;
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
        return $this->belongsTo( Customer::class );
    }

    public function car() {
        return $this->belongsTo( CustomerCar::class, 'customer_car_id' );
    }
}