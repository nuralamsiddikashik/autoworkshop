<?php
namespace App\Repositories\Contracts;

interface CarReceiveRepositoryInterface {
    public function store( array $data );
    public function findByCustomerAndModel( $customerId, $modelId );

    // 🔥 ADD THIS
    public function findByRegistration( $customerId, $registrationNo );
}