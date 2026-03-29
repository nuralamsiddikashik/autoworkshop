<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarModel\StoreCarModelRequest;
use App\Http\Requests\CarModel\UpdateCarModelRequest;
use App\Repositories\Contracts\CarBrandRepositoryInterface;
use App\Repositories\Contracts\CarModelRepositoryInterface;

class CarModelController extends Controller {
    protected $modelRepo;
    protected $brandRepo;

    public function __construct(
        CarModelRepositoryInterface $modelRepo,
        CarBrandRepositoryInterface $brandRepo
    ) {
        $this->modelRepo = $modelRepo;
        $this->brandRepo = $brandRepo;
    }

    public function index() {
        $models = $this->modelRepo->all();
        $brands = $this->brandRepo->all();

        return view( 'admin.cars.models.index', compact( 'models', 'brands' ) );
    }

    public function store( StoreCarModelRequest $request ) {
        $this->modelRepo->store( $request->validated() );
        return back()->with( 'success', 'Model Created' );
    }

    public function update( UpdateCarModelRequest $request, $id ) {
        $this->modelRepo->update( $id, $request->validated() );
        return back()->with( 'success', 'Model Updated' );
    }

    public function destroy( $id ) {
        $this->modelRepo->delete( $id );
        return back()->with( 'success', 'Model Deleted' );
    }
}
