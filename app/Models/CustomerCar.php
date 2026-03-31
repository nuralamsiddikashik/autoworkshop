<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCar extends Model {
    protected $fillable = [
        'customer_id',
        'car_brand_id',
        'car_model_id',
        'vin',
        'registration_no',
        'odometer',
    ];

    public function customer() {
        return $this->belongsTo( Customer::class );
    }

    public function brand() {
        return $this->belongsTo( CarBrand::class, 'car_brand_id' );
    }

    public function model() {
        return $this->belongsTo( CarModel::class, 'car_model_id' );
    }
}
