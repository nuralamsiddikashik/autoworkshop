<?php

namespace App\Models;

use App\Models\CarBrand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model {
    use SoftDeletes;

    protected $fillable = [
        'car_brand_id',
        'name',
        'slug',
        'is_active',
    ];

    /**
     * Relationship: Model belongs to Brand
     */
    public function brand() {
        return $this->belongsTo( CarBrand::class, 'car_brand_id' );
    }
}