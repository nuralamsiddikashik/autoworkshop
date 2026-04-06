<?php

namespace App\Repositories\Contracts;

interface MoneyReceiptRepositoryInterface {

    public function findReceiptById( int $id );
    public function getMoneyReceiptsByCustomer( int $customerId );
    public function getDueInvoicesByCustomer( int $customerId );
    public function store( array $data );
}
