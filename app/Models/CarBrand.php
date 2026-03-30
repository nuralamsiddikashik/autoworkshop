<?php

namespace App\Models;

use App\Models\CarModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarBrand extends Model {
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * Relationship: Brand has many Models
     */
    public function models() {
        return $this->hasMany( CarModel::class, 'car_brand_id' );
    }
}