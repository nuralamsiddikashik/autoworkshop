<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\JobCardRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
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

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
     */
    public function index() {
        $invoices = $this->repo->getAll(); // light query

        return view( 'admin.invoices.index', compact( 'invoices' ) );
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
     */
    public function show( $id ) {
        $invoice = $this->repo->findById( $id, [
            'items',
            'job.receive.customer',
        ] );

        return view( 'admin.invoices.show', compact( 'invoice' ) );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
     */
    public function create() {
        $units = config( 'invoice.units' );

        return view( 'admin.invoices.create', compact( 'units' ) );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
     */
    public function store( StoreInvoiceRequest $request ) {

        try {

            $this->repo->create( $request->validated() );

            return back()->with( 'success', '✅ Invoice Created Successfully' );

        } catch ( \Throwable $e ) {

            report( $e );

            return back()->withErrors( [
                'error' => '⚠️ Something went wrong, please try again!',
            ] )->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
     */
    public function edit( $id ) {
        $invoice = $this->repo->findById( $id, [
            'parts',
            'works',
            'services',
        ] );

        return view( 'admin.invoices.edit', compact( 'invoice' ) );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
     */

    public function update( UpdateInvoiceRequest $request, $id ) {

        try {

            $this->repo->update( $id, $request->validated() );

            return redirect()->route( 'invoices.index' )
                ->with( 'success', 'Invoice Updated' );

        } catch ( \Throwable $e ) {

            return back()->withErrors( [
                'error' => $e->getMessage(),
            ] );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete (optional)
    |--------------------------------------------------------------------------
     */
    public function destroy( $id ) {
        try {

            $this->repo->delete( $id );

            return back()->with( 'success', '✅ Invoice Deleted' );

        } catch ( \Throwable $e ) {

            report( $e );

            return back()->withErrors( [
                'error' => '⚠️ Delete failed!',
            ] );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Job No → Fetch (AJAX)
    |--------------------------------------------------------------------------
     */
    public function find( Request $request ) {
        $job = $this->jobRepo->findByJobNo( $request->job_no );

        if ( !$job ) {
            return response()->json( ['error' => 'Not found'], 404 );
        }

        return response()->json( $job );
    }

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
     */
    public function pdf( $id ) {
        $invoice = $this->repo->findById( $id, [
            'items',
            'job.receive.customer',
            'job.receive.car.brand',
            'job.receive.car.model',
        ] );

        $showHeader = request( 'header', 'true' ) !== 'false';

        $pdf = Pdf::loadView( 'admin.invoices.pdf', [
            'invoice'    => $invoice,
            'showHeader' => $showHeader,
        ] )
            ->setPaper( 'a4', 'portrait' );

        return request( 'action' ) === 'download'
        ? $pdf->download( 'invoice-' . $invoice->id . '.pdf' )
        : $pdf->stream( 'invoice-' . $invoice->id . '.pdf' );
    }

}