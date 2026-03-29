<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface {
    public function all() {
        return Customer::active()->latest()->get();
    }

    public function store( array $data ) {
        return Customer::create( $data );
    }

    public function find( int $id ) {
        return Customer::findOrFail( $id );
    }

    public function update( int $id, array $data ) {
        $customer = $this->find( $id );
        $customer->update( $data );

        return $customer;
    }

    public function delete( int $id ) {
        $customer = $this->find( $id );
        return $customer->delete();
    }
}