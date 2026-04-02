<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCard\StoreJobCardRequest;
use App\Repositories\Contracts\CarReceiveRepositoryInterface;
use App\Repositories\Contracts\JobCardRepositoryInterface;
use Illuminate\Http\Request;

class JobCardController extends Controller {

    protected $repo;
    protected $receiveRepo;

    public function __construct(
        JobCardRepositoryInterface $repo,
        CarReceiveRepositoryInterface $receiveRepo
    ) {
        $this->repo        = $repo;
        $this->receiveRepo = $receiveRepo;
    }

    public function create() {
        return view( 'admin.job-cards.create' );
    }

    public function store( StoreJobCardRequest $request ) {

        $data = $request->validated();

        $data['job_no'] = 'JOB-' . time();

        $this->repo->create( $data );
        return response()->json( ['success' => 'Job Card Created Successfully'] );
    }

    public function find( Request $request ) {

        $jobCard = $this->repo->findByReceiveNo( $request->receive_no );

        if ( !$jobCard ) {
            return response()->json( ['error' => 'Not found'], 404 );
        }

        return response()->json( $jobCard );
    }
}