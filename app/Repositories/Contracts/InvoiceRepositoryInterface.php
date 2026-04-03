<?php
namespace App\Repositories\Contracts;

interface InvoiceRepositoryInterface {
    public function create( array $data );

    public function getAll();

    public function findById( int $id );
}
