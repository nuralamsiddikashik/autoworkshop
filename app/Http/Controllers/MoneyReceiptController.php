<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyReceipt\StoreMoneyReceiptRequest;
use App\Repositories\Contracts\MoneyReceiptRepositoryInterface;

class MoneyReceiptController extends Controller {
    protected $repo;

    public function __construct( MoneyReceiptRepositoryInterface $repo ) {
        $this->repo = $repo;
    }

    public function index() {
        $moneyReceipts = $this->repo->getMoneyReceiptsByCustomer( $perPage = 15 );

        return view( 'admin.money_receipts.index', compact( 'moneyReceipts' ) );
    }

    public function show( $id ) {
        $receipt = $this->repo->findReceiptById( $id );

        return view( 'admin.money_receipts.show', compact( 'receipt' ) );
    }

    public function create() {
        $customers = app( \App\Repositories\Contracts\CustomerRepositoryInterface::class )->all();

        return view( 'admin.money_receipts.create', compact( 'customers' ) );
    }

    public function getCustomerDueInvoices( $id ) {
        $invoices = $this->repo->getDueInvoicesByCustomer( $id );

        return response()->json( $invoices );
    }

    public function store( StoreMoneyReceiptRequest $request ) {
        $this->repo->store( $request->validated() );

        return redirect()->route( 'money.receipts.index' )
            ->with( 'success', 'Money receipt created successfully' );
    }
}
