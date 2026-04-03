<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
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

    public function index() {
        $invoices = $this->repo->getAll();

        return view( 'admin.invoices.index', compact( 'invoices' ) );
    }

    public function show( $id ) {
        $invoice = $this->repo->findById( $id );

        return view( 'admin.invoices.show', compact( 'invoice' ) );
    }

    // ✅ Create Page
    public function create() {
        $units = config( 'invoice.units' );
        return view( 'admin.invoices.create', compact( 'units' ) );
    }

    // ✅ Store Invoice
    public function store( StoreInvoiceRequest $request ) {
        try {

            $this->repo->create( $request->validated() );

            return back()->with( 'success', '✅ Invoice Created Successfully' );

        } catch ( \Throwable $e ) {

            report( $e ); // 🔥 log error

            return back()->withErrors( [
                'error' => '⚠️ Something went wrong, please try again!',
            ] )->withInput();
        }
    }

    // ✅ Job No → Fetch
    public function find( Request $request ) {
        $job = $this->jobRepo->findByJobNo( $request->job_no );

        if ( !$job ) {
            return response()->json( ['error' => 'Not found'], 404 );
        }

        return response()->json( $job );
    }

    public function pdf( $id ) {
        $invoice = $this->repo->findById( $id );

        $pdf = Pdf::loadView( 'admin.invoices.pdf', compact( 'invoice' ) )
            ->setPaper( 'a4', 'portrait' );

        $action = request( 'action' );

        // 🔥 Download
        if ( $action === 'download' ) {
            return $pdf->download( 'invoice-' . $invoice->id . '.pdf' );
        }

        // 🔥 Default = View (Stream)
        return $pdf->stream( 'invoice-' . $invoice->id . '.pdf' );
    }
}