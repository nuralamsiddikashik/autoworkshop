<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarBrand\StoreCarBrandRequest;
use App\Http\Requests\CarBrand\UpdateCarBrandRequest;
use App\Repositories\Contracts\CarBrandRepositoryInterface;

class CarBrandController extends Controller {
    protected $brandRepo;

    public function __construct( CarBrandRepositoryInterface $brandRepo ) {
        $this->brandRepo = $brandRepo;
    }

    public function index() {
        $brands = $this->brandRepo->all();
        return view( 'admin.cars.brands.index', compact( 'brands' ) );
    }

    public function store( StoreCarBrandRequest $request ) {
        $this->brandRepo->store( $request->validated() );
        return back()->with( 'success', 'Brand Created' );
    }

    public function update( UpdateCarBrandRequest $request, $id ) {
        $this->brandRepo->update( $id, $request->validated() );
        return back()->with( 'success', 'Brand Updated' );
    }

    public function destroy( $id ) {
        $this->brandRepo->delete( $id );
        return back()->with( 'success', 'Brand Deleted' );
    }
}