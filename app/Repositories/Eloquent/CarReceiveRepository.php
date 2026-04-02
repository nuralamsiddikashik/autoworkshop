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

    public function getList( array $filters = [] ) {
        $query = CarReceive::with( [
            'customer:id,customer_name,owner_phone,transport_phone,driver_phone,office_phone',

            'car:id,customer_id,car_brand_id,car_model_id,registration_no,vin,odometer',

            'car.brand:id,name',
            'car.model:id,name',
        ] );

        // 🔍 Search
        if ( !empty( $filters['search'] ) ) {
            $search = $filters['search'];

            $query->where( function ( $q ) use ( $search ) {
                $q->where( 'receive_no', 'like', "%$search%" )
                    ->orWhereHas( 'car', function ( $q2 ) use ( $search ) {
                        $q2->where( 'registration_no', 'like', "%$search%" );
                    } )
                    ->orWhereHas( 'customer', function ( $q3 ) use ( $search ) {
                        $q3->where( 'customer_name', 'like', "%$search%" );
                    } );
            } );
        }

        return $query->latest()->paginate( 10 );
    }
}
