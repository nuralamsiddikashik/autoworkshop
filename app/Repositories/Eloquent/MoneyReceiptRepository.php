<?php
namespace App\Repositories\Eloquent;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Repositories\Contracts\MoneyReceiptRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MoneyReceiptRepository implements MoneyReceiptRepositoryInterface {
    public function getDueInvoicesByCustomer( int $customerId ) {
        return Invoice::whereHas( 'job.carReceive', function ( $q ) use ( $customerId ) {
            $q->where( 'customer_id', $customerId );
        } )
            ->where( 'due_amount', '>', 0 )
            ->get();
    }

    public function getMoneyReceiptsByCustomer( $perPage = 15 ) {
        return Payment::with( 'customer' )
            ->latest()
            ->paginate( $perPage );
    }

    public function findReceiptById( int $id ) {
        return Payment::query()
            ->select( 'id', 'customer_id', 'total_paid', 'payment_date' )
            ->with( [
                'customer:id,customer_name,owner_phone',

                'details:id,payment_id,invoice_id,pay_amount,discount_amount',

                // ✅ no assumption
                'details.invoice',
            ] )
            ->findOrFail( $id );
    }

    public function store( array $data ) {
        DB::transaction( function () use ( $data ) {

            $payment = Payment::create( [
                'customer_id'    => $data['customer_id'],
                'total_paid'     => collect( $data['payments'] )->sum( 'pay' ),
                'total_discount' => collect( $data['payments'] )->sum( 'discount' ),
                'payment_date'   => now(),
            ] );

            foreach ( $data['payments'] as $item ) {

                $pay      = $item['pay'] ?? 0;
                $discount = $item['discount'] ?? 0;

                if ( $pay == 0 && $discount == 0 ) {
                    continue;
                }

                $invoice = Invoice::findOrFail( $item['invoice_id'] );

                // 🔥 VALIDATION (pay + discount <= due)
                if ( ( $pay + $discount ) > $invoice->due_amount ) {
                    throw new \Exception( "Payment exceeds due for invoice ID: {$invoice->id}" );
                }

                // ✅ ONLY CASH ADD হবে
                $newPaid = $invoice->paid_amount + $pay;

                // ✅ discount আলাদা treat হবে
                $newDue = $invoice->bill_amount - ( $newPaid + $discount );

                // 🔥 NEVER NEGATIVE
                $newDue = max( 0, $newDue );

                // 🔥 STATUS LOGIC
                $status = 'unpaid';

                if ( $newDue == 0 ) {
                    $status = 'paid';
                } elseif ( $newPaid > 0 ) {
                    $status = 'partial';
                }

                $invoice->update( [
                    'paid_amount' => $newPaid, // 🔥 ONLY CASH
                    'due_amount'  => $newDue,
                    'status'      => $status,
                ] );

                PaymentDetail::create( [
                    'payment_id'      => $payment->id,
                    'invoice_id'      => $invoice->id,
                    'pay_amount'      => $pay,
                    'discount_amount' => $discount,
                ] );
            }
        } );
    }
}