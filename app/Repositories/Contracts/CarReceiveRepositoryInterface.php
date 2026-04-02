<?php
namespace App\Repositories\Contracts;

interface CarReceiveRepositoryInterface {
    public function store( array $data );
    public function findByCustomerAndModel( $customerId, $modelId );
    public function findByRegistration( $customerId, $registrationNo );
    public function getList( array $filters = [] );

}
