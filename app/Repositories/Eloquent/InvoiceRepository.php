<?php

namespace App\Repositories\Eloquent;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface {

    public function create( array $data ) {
        return DB::transaction( function () use ( $data ) {

            $allItems = [];

            // 🔥 merge + filter
            foreach ( ['parts', 'works', 'services'] as $section ) {

                if ( empty( $data[$section] ) ) {
                    continue;
                }

                foreach ( $data[$section] as $item ) {

                    if (
                        empty( $item['name'] ) ||
                        empty( $item['qty'] ) ||
                        empty( $item['sell_price'] )
                    ) {
                        continue;
                    }

                    $type = rtrim( $section, 's' );

                    $qty  = (float) $item['qty'];
                    $buy  = (float) ( $item['buy_price'] ?? 0 );
                    $sell = (float) $item['sell_price'];

                    $total  = $qty * $sell;
                    $profit = ( $sell - $buy ) * $qty;

                    $allItems[] = [
                        'type'       => $type,
                        'name'       => $item['name'],
                        'qty'        => $qty,
                        'buy_price'  => $buy,
                        'unit'       => $item['unit'] ?? null,
                        'unit_price' => (float) ( $item['unit_price'] ?? 0 ),
                        'sell_price' => $sell,
                        'total'      => $total,
                        'profit'     => $profit,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // ❗ validation
            if ( empty( $allItems ) ) {
                throw new \Exception( 'At least one item required' );
            }

            // 🔥 totals (fast reduce)
            $partsTotal   = 0;
            $worksTotal   = 0;
            $serviceTotal = 0;
            $totalProfit  = 0;

            foreach ( $allItems as $item ) {

                if ( $item['type'] === 'part' ) {
                    $partsTotal += $item['total'];
                } elseif ( $item['type'] === 'work' ) {
                    $worksTotal += $item['total'];
                } else {
                    $serviceTotal += $item['total'];
                }

                $totalProfit += $item['profit'];
            }

            $grandTotal = $partsTotal + $worksTotal + $serviceTotal;
            $vat        = $grandTotal * 0.10;
            $billAmount = $grandTotal + $vat;

            // 🔥 words
            $billWords = numberToWords( $billAmount );

            // ✅ create invoice
            $invoice = Invoice::create( [
                'job_card_id'          => $data['job_card_id'],
                'parts_total'          => $partsTotal,
                'works_total'          => $worksTotal,
                'service_total'        => $serviceTotal,
                'grand_total'          => $grandTotal,
                'vat'                  => $vat,
                'bill_amount'          => $billAmount,
                'total_profit'         => $totalProfit,
                'bill_amount_in_words' => $billWords,
            ] );

            // 🔥 BULK INSERT (VERY IMPORTANT 🚀)
            foreach ( $allItems as &$item ) {
                $item['invoice_id'] = $invoice->id;
            }

            DB::table( 'invoice_items' )->insert( $allItems );

            return $invoice;
        } );
    }

    public function getAll() {
        return Invoice::with( [
            'job.receive.customer',
            'job.receive.car.brand',
            'job.receive.car.model',
        ] )->latest()->paginate( 10 );
    }

    public function findById( int $id ) {
        return Invoice::with( [
            'items',
            'job.receive.customer',
            'job.receive.car.brand',
            'job.receive.car.model',
        ] )->findOrFail( $id );
    }

}