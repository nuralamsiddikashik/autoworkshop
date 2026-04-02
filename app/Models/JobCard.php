<?php

namespace App\Models;

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
}