<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class JobCard extends Model {
    protected $fillable = [
        'job_no',
        'car_receive_id',
        'problem_note',
        'work_note',
        'status',
    ];

    public function receive() {
        return $this->belongsTo( CarReceive::class, 'car_receive_id' );
    }

    public function customer() {
        return $this->belongsTo( Customer::class );
    }

    public function carReceive() {
        return $this->belongsTo( CarReceive::class, 'car_receive_id' );
    }
}