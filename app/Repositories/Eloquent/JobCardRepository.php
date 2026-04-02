<?php

namespace App\Repositories\Eloquent;

use App\Models\JobCard;
use App\Repositories\Contracts\JobCardRepositoryInterface;

class JobCardRepository implements JobCardRepositoryInterface {
    public function create( array $data ) {
        return JobCard::create( $data );
    }

    public function getAll() {
        return JobCard::with( [
            'receive.customer',
            'receive.car.brand',
            'receive.car.model',
        ] )->latest()->paginate( 10 );
    }

    public function findByReceiveNo( string $receiveNo ) {
        return \App\Models\CarReceive::with( [
            'customer:id,customer_name',
            'car:id,car_brand_id,car_model_id,registration_no,vin',
            'car.brand:id,name',
            'car.model:id,name',
        ] )
            ->where( 'receive_no', $receiveNo )
            ->first();
    }

    public function findByJobNo( string $jobNo ) {
        return JobCard::with( [
            'receive.customer:id,customer_name,owner_phone,transport_phone,driver_phone,office_phone',

            'receive.car:id,registration_no,vin,car_brand_id,car_model_id',

            'receive.car.brand:id,name',
            'receive.car.model:id,name',
        ] )
            ->where( 'job_no', $jobNo )
            ->first();
    }

}