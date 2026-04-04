<?php

namespace App\Repositories\Contracts;

interface MoneyReceiptRepositoryInterface {
    public function getDueInvoicesByCustomer( int $customerId );
    public function store( array $data );
}
