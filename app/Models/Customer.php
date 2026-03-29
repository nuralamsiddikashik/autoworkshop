<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {
    use SoftDeletes;

    protected $fillable = [
        'account_name',
        'customer_name',
        'address',
        'owner_phone',
        'transport_phone',
        'driver_phone',
        'office_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // 🔥 Active Scope
    public function scopeActive( $query ) {
        return $query->where( 'is_active', true );
    }
}