<?php

namespace App\Repositories\Eloquent;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface {
    /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
     */
    public function query( array $relations = [] ) {
        return Invoice::query()->with( $relations );
    }

    /*
    |--------------------------------------------------------------------------
    | Find By ID (Flexible)
    |--------------------------------------------------------------------------
     */
    public function findById( int $id, array $relations = [], array $columns = ['*'] ) {
        return $this->query( $relations )
            ->select( $columns )
            ->findOrFail( $id );
    }

    /*
    |--------------------------------------------------------------------------
    | Get All (Index ব্যবহার করার জন্য)
    |--------------------------------------------------------------------------
     */
    public function getAll( array $relations = [], int $paginate = 10 ) {
        return $this->query( $relations )
            ->latest()
            ->paginate( $paginate );
    }

    /*
    |--------------------------------------------------------------------------
    | Create (Invoice Create)
    |--------------------------------------------------------------------------
     */

    public function create( array $data ) {
        DB::beginTransaction();

        try {

            // 🔥 calculate totals
            $parts_total   = 0;
            $works_total   = 0;
            $service_total = 0;
            $total_profit  = 0;

            foreach ( $data['parts'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $parts_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            foreach ( $data['works'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $works_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            foreach ( $data['services'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $service_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            $grand_total = $parts_total + $works_total + $service_total;
            $vat         = $data['vat'] ?? 0;
            $bill_amount = $grand_total + $vat;

            // 🔥 create invoice
            $invoice = Invoice::create( [
                'job_card_id'   => $data['job_card_id'],
                'parts_total'   => $parts_total,
                'works_total'   => $works_total,
                'service_total' => $service_total,
                'grand_total'   => $grand_total,
                'vat'           => $vat,
                'bill_amount'   => $bill_amount,
                'total_profit'  => $total_profit,
            ] );

            // 🔥 items save
            $this->syncItems( $invoice, $data );

            DB::commit();

            return $invoice;

        } catch ( \Throwable $e ) {

            DB::rollBack();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
     */

    public function update( int $id, array $data ) {
        DB::beginTransaction();

        try {

            $invoice = $this->findById( $id );

            // 🔥 calculate totals
            $parts_total   = 0;
            $works_total   = 0;
            $service_total = 0;
            $total_profit  = 0;

            foreach ( $data['parts'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $parts_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            foreach ( $data['works'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $works_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            foreach ( $data['services'] ?? [] as $item ) {
                if ( !empty( $item['name'] ) ) {
                    $qty        = $item['qty'] ?? 0;
                    $unit_price = $item['unit_price'] ?? 0;
                    $buy        = $item['buy_price'] ?? 0;
                    $sell       = $item['sell_price'] ?? 0;

                    $service_total += $qty * $unit_price;
                    $total_profit += ( $sell - $buy ) * $qty;
                }
            }

            $grand_total = $parts_total + $works_total + $service_total;
            $vat         = $data['vat'] ?? 0;
            $bill_amount = $grand_total + $vat;

            // 🔥 UPDATE invoice
            $invoice->update( [
                'job_card_id'   => $data['job_card_id'],
                'parts_total'   => $parts_total,
                'works_total'   => $works_total,
                'service_total' => $service_total,
                'grand_total'   => $grand_total,
                'vat'           => $vat,
                'bill_amount'   => $bill_amount,
                'total_profit'  => $total_profit,
            ] );

            // 🔥 update items
            $this->syncItems( $invoice, $data );

            DB::commit();

            return true;

        } catch ( \Throwable $e ) {
            DB::rollBack();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
     */
    public function delete( int $id ) {
        $invoice = $this->findById( $id );

        DB::beginTransaction();

        try {

            $invoice->parts()->delete();
            $invoice->works()->delete();
            $invoice->services()->delete();

            $invoice->delete();

            DB::commit();

            return true;

        } catch ( \Exception $e ) {
            DB::rollBack();
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Items (🔥 MAIN MAGIC)
    |--------------------------------------------------------------------------
     */
    private function syncItems( $invoice, array $data ) {
        $invoice->items()->delete();

        foreach ( $data['parts'] ?? [] as $item ) {
            if ( !empty( $item['name'] ) ) {

                $qty        = $item['qty'] ?? 0;
                $buy        = $item['buy_price'] ?? 0;
                $unit_price = $item['unit_price'] ?? 0;
                $sell       = $item['sell_price'] ?? 0;

                $total  = $qty * $unit_price;
                $profit = ( $sell - $buy ) * $qty; // 🔥 FIX

                $invoice->items()->create( [
                    'type'       => 'part',
                    'name'       => $item['name'],
                    'qty'        => $qty,
                    'buy_price'  => $buy,
                    'unit'       => $item['unit'] ?? null,
                    'unit_price' => $unit_price,
                    'sell_price' => $sell,
                    'total'      => $total,
                    'profit'     => $profit, // 🔥 MUST
                ] );
            }
        }

        // works
        foreach ( $data['works'] ?? [] as $item ) {
            if ( !empty( $item['name'] ) ) {

                $qty        = $item['qty'] ?? 0;
                $buy        = $item['buy_price'] ?? 0;
                $unit_price = $item['unit_price'] ?? 0;
                $sell       = $item['sell_price'] ?? 0;

                $total  = $qty * $unit_price;
                $profit = ( $sell - $buy ) * $qty;

                $invoice->items()->create( [
                    'type'       => 'work',
                    'name'       => $item['name'],
                    'qty'        => $qty,
                    'buy_price'  => $buy,
                    'unit'       => $item['unit'] ?? null,
                    'unit_price' => $unit_price,
                    'sell_price' => $sell,
                    'total'      => $total,
                    'profit'     => $profit,
                ] );
            }
        }

        // services
        foreach ( $data['services'] ?? [] as $item ) {
            if ( !empty( $item['name'] ) ) {

                $qty        = $item['qty'] ?? 0;
                $buy        = $item['buy_price'] ?? 0;
                $unit_price = $item['unit_price'] ?? 0;
                $sell       = $item['sell_price'] ?? 0;

                $total  = $qty * $unit_price;
                $profit = ( $sell - $buy ) * $qty;

                $invoice->items()->create( [
                    'type'       => 'service',
                    'name'       => $item['name'],
                    'qty'        => $qty,
                    'buy_price'  => $buy,
                    'unit'       => $item['unit'] ?? null,
                    'unit_price' => $unit_price,
                    'sell_price' => $sell,
                    'total'      => $total,
                    'profit'     => $profit,
                ] );
            }
        }
    }
}