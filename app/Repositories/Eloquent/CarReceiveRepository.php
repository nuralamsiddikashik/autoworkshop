<?php
namespace App\Repositories\Eloquent;

use App\Models\CarReceive;
use App\Models\CustomerCar;
use App\Repositories\Contracts\CarReceiveRepositoryInterface;

class CarReceiveRepository implements CarReceiveRepositoryInterface {
    public function store( array $data ) {
        // 1. find or create car
        $car = CustomerCar::firstOrCreate(
            [
                'customer_id'  => $data['customer_id'],
                'car_model_id' => $data['car_model_id'],
            ],
            [
                'car_brand_id'    => $data['car_brand_id'],
                'vin'             => $data['vin'] ?? null,
                'registration_no' => $data['registration_no'] ?? null,
                'odometer'        => $data['odometer'] ?? null,
            ]
        );

        // 2. update odometer
        if ( !empty( $data['odometer'] ) ) {
            $car->update( [
                'odometer' => $data['odometer'],
            ] );
        }

        // 3. create receive
        return CarReceive::create( [
            'receive_no'      => $this->generateReceiveNo(),
            'customer_id'     => $data['customer_id'],
            'customer_car_id' => $car->id,
            'odometer'        => $data['odometer'] ?? null,
            'note'            => $data['note'] ?? null,
        ] );
    }

    private function generateReceiveNo() {
        return 'AAS-' . str_pad( rand( 0, 99999 ), 5, '0', STR_PAD_LEFT );
    }

    public function findByCustomerAndModel( $customerId, $modelId ) {
        return CarReceive::where(
            [
                'customer_id'  => $customerId,
                'car_model_id' => $modelId,
            ]
        )->first();
    }
}
