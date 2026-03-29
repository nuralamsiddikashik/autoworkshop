<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerController extends Controller {
    protected $customerRepo;

    public function __construct( CustomerRepositoryInterface $customerRepo ) {
        $this->customerRepo = $customerRepo;
    }

    public function index() {
        $customers = $this->customerRepo->all();

        return view( 'admin.customers.index', compact( 'customers' ) );
    }

    public function store( StoreCustomerRequest $request ) {
        $this->customerRepo->store( $request->validated() );

        return redirect()->route( 'customers.index' )
            ->with( 'success', 'Customer Created Successfully' );
    }

    public function edit( $id ) {
        $editCustomer = $this->customerRepo->find( $id );
        $customers    = $this->customerRepo->all();

        return view( 'admin.customers.edit', compact( 'customers', 'editCustomer' ) );
    }

    public function update( StoreCustomerRequest $request, $id ) {
        $this->customerRepo->update( $id, $request->validated() );

        return redirect()->route( 'customers.index' )
            ->with( 'success', 'Customer Updated Successfully' );
    }

    public function destroy( $id ) {
        $this->customerRepo->delete( $id );

        return redirect()->route( 'customers.index' )
            ->with( 'success', 'Customer Deleted Successfully' );
    }
}