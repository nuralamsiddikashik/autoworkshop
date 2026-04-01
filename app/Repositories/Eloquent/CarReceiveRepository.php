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
                'customer_id'     => $data['customer_id'],
                'registration_no' => strtoupper( trim( $data['registration_no'] ) ),
            ],
            [
                'car_brand_id' => $data['car_brand_id'],
                'car_model_id' => $data['car_model_id'],
                'vin'          => $data['vin'] ?? null,
                'odometer'     => $data['odometer'] ?? null,
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
        return CustomerCar::where( 'customer_id', $customerId )
            ->where( 'car_model_id', $modelId )
            ->orderByDesc( 'id' ) // latest
            ->first();
    }

    public function findByRegistration( $customerId, $registrationNo ) {
        // 🔥 normalize input (user input clean)
        $normalized = strtolower( preg_replace( '/[^a-z0-9]/', '', $registrationNo ) );

        return CustomerCar::where( 'customer_id', $customerId )
            ->get()
            ->first( function ( $car ) use ( $normalized ) {

                // 🔥 normalize DB value
                $db = strtolower( preg_replace( '/[^a-z0-9]/', '', $car->registration_no ) );

                return $db === $normalized;
            } );
    }
}
