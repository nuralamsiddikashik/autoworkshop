<?php

namespace App\Repositories\Eloquent;

use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface {

    public function create( array $data ) {
        $invoice = Invoice::create( $data );

        foreach ( $data['items'] as $item ) {
            $invoice->items()->create( $item );
        }

        return $invoice;
    }
}