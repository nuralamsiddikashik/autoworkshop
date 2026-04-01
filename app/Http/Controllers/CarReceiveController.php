<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarReceive\StoreCarReceiveRequest;
use App\Repositories\Contracts\CarBrandRepositoryInterface;
use App\Repositories\Contracts\CarModelRepositoryInterface;
use App\Repositories\Contracts\CarReceiveRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class CarReceiveController extends Controller {
    protected $repo;
    protected $customerRepo;
    protected $brandRepo;
    protected $modelRepo;

    public function __construct(
        CarReceiveRepositoryInterface $repo,
        CustomerRepositoryInterface $customerRepo,
        CarBrandRepositoryInterface $brandRepo,
        CarModelRepositoryInterface $modelRepo
    ) {
        $this->repo         = $repo;
        $this->customerRepo = $customerRepo;
        $this->brandRepo    = $brandRepo;
        $this->modelRepo    = $modelRepo;
    }

    // ================= INDEX =================
    public function index() {
        $customers = $this->customerRepo->all();
        $brands    = $this->brandRepo->all();
        $models    = $this->modelRepo->all();

        return view( 'admin.car-receives.index', compact( 'customers', 'brands', 'models' ) );
    }

    // ================= STORE =================
    public function store( StoreCarReceiveRequest $request ) {
        $this->repo->store( $request->validated() );

        return back()->with( 'success', 'Car Received Successfully' );
    }

    // ================= AJAX =================
    public function getCustomer( $id ) {
        $customer = $this->customerRepo->find( $id );

        return response()->json( $customer );
    }

    public function getCustomerCar( Request $request ) {
        // 👇 IMPORTANT: repo use করবো (no direct model)
        $car = $this->repo->findByCustomerAndModel(
            $request->customer_id,
            $request->car_model_id
        );

        return response()->json( $car );
    }

    public function findByRegistration( Request $request ) {
        $car = $this->repo->findByRegistration(
            $request->customer_id,
            $request->registration_no
        );

        return response()->json( $car ); // ✅ MUST RETURN JSON
    }
}