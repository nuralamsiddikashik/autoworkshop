<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\JobCardRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
    protected $repo;
    protected $jobRepo;

    public function __construct(
        InvoiceRepositoryInterface $repo,
        JobCardRepositoryInterface $jobRepo
    ) {
        $this->repo    = $repo;
        $this->jobRepo = $jobRepo;
    }

    // ✅ Create Page
    public function create() {
        return view( 'admin.invoices.create' );
    }

    // ✅ Store Invoice
    public function store( StoreInvoiceRequest $request ) {
        $data = $request->validated();

        $allItems = [];

        // 🔥 Merge all sections
        foreach ( ['parts', 'works', 'services'] as $section ) {

            if ( !empty( $data[$section] ) ) {

                foreach ( $data[$section] as $item ) {

                    // ❗ skip empty row
                    if (
                        empty( $item['name'] ) &&
                        empty( $item['qty'] ) &&
                        empty( $item['sell_price'] )
                    ) {
                        continue;
                    }

                    // ❗ skip half-filled row (no error now)
                    if (
                        empty( $item['name'] ) ||
                        empty( $item['qty'] ) ||
                        empty( $item['sell_price'] )
                    ) {
                        continue;
                    }

                    $item['type'] = rtrim( $section, 's' );

                    $item['total']  = $item['qty'] * $item['sell_price'];
                    $item['profit'] = ( $item['sell_price'] - ( $item['buy_price'] ?? 0 ) ) * $item['qty'];

                    $allItems[] = $item;
                }
            }
        }

        // ❗ No item added
        if ( count( $allItems ) === 0 ) {
            return back()->withErrors( [
                'error' => '⚠️ At least one item required',
            ] )->withInput();
        }

        // 🔥 Totals
        $partsTotal   = 0;
        $worksTotal   = 0;
        $serviceTotal = 0;
        $totalProfit  = 0;

        foreach ( $allItems as $item ) {

            if ( $item['type'] === 'part' ) {
                $partsTotal += $item['total'];
            }

            if ( $item['type'] === 'work' ) {
                $worksTotal += $item['total'];
            }

            if ( $item['type'] === 'service' ) {
                $serviceTotal += $item['total'];
            }

            $totalProfit += $item['profit'];
        }

        $grandTotal = $partsTotal + $worksTotal + $serviceTotal;
        $vat        = $grandTotal * 0.10;
        $billAmount = $grandTotal + $vat;

        // ✅ Save via Repository
        $this->repo->create( [
            'job_card_id'   => $data['job_card_id'],
            'parts_total'   => $partsTotal,
            'works_total'   => $worksTotal,
            'service_total' => $serviceTotal,
            'grand_total'   => $grandTotal,
            'vat'           => $vat,
            'bill_amount'   => $billAmount,
            'total_profit'  => $totalProfit,
            'items'         => $allItems,
        ] );

        return back()->with( 'success', '✅ Invoice Created Successfully' );
    }

    // ✅ Job No → Fetch
    public function find( Request $request ) {
        $job = $this->jobRepo->findByJobNo( $request->job_no );

        if ( !$job ) {
            return response()->json( ['error' => 'Not found'], 404 );
        }

        return response()->json( $job );
    }
}