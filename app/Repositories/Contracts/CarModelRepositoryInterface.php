<?php

namespace App\Repositories\Contracts;

interface CarModelRepositoryInterface {
    public function all();
    public function find( $id );
    public function store( array $data );
    public function update( $id, array $data );
    public function delete( $id );
}