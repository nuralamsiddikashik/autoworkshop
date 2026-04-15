<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\JobCardRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    protected $repo;

    protected $jobRepo;

    public function __construct(
        InvoiceRepositoryInterface $repo,
        JobCardRepositoryInterface $jobRepo
    ) {
        $this->repo = $repo;
        $this->jobRepo = $jobRepo;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
     */
    public function index()
    {
        $invoices = $this->repo->getAll($this->invoiceListRelations());

        return view('admin.invoices.index', compact('invoices'));
    }

    /*
    |--------------------------------------------------------------------------
    | Hidden Index
    |--------------------------------------------------------------------------
     */
    public function hiddenIndex(Request $request): View
    {
        if (! $request->session()->get(config('invoice.hidden_list_session_key'), false)) {
            return view('admin.invoices.hidden-password');
        }

        $invoices = $this->repo->getHidden($this->invoiceListRelations());

        return view('admin.invoices.hidden', compact('invoices'));
    }

    /*
    |--------------------------------------------------------------------------
    | Unlock Hidden Invoices
    |--------------------------------------------------------------------------
     */
    public function unlockHiddenIndex(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
        ]);

        if ($validated['password'] !== config('invoice.hidden_list_password')) {
            return back()->withErrors([
                'password' => 'Incorrect password. Please try again.',
            ]);
        }

        $request->session()->put(
            config('invoice.hidden_list_session_key'),
            true
        );
        $request->session()->regenerate();

        return redirect()->route('invoices.hidden.index')
            ->with('success', 'Hidden invoice list unlocked.');
    }

    /*
    |--------------------------------------------------------------------------
    | Lock Hidden Invoices
    |--------------------------------------------------------------------------
     */
    public function lockHiddenIndex(Request $request): RedirectResponse
    {
        $request->session()->forget(config('invoice.hidden_list_session_key'));

        return redirect()->route('invoices.hidden.index')
            ->with('success', 'Hidden invoice list locked.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
     */
    public function show(Request $request, $id)
    {
        $invoice = $this->repo->findById($id, [
            'items',
            'job.receive.customer',
        ]);

        if ($redirect = $this->hiddenInvoiceRedirect($invoice->is_hidden, $request)) {
            return $redirect;
        }

        return view('admin.invoices.show', compact('invoice'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
     */
    public function create()
    {
        $units = config('invoice.units');

        return view('admin.invoices.create', compact('units'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
     */
    public function store(StoreInvoiceRequest $request)
    {

        try {

            $this->repo->create($request->validated());

            return back()->with('success', '✅ Invoice Created Successfully');

        } catch (\Throwable $e) {

            report($e);

            return back()->withErrors([
                'error' => '⚠️ Something went wrong, please try again!',
            ])->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
     */
    public function edit(Request $request, $id)
    {
        $invoice = $this->repo->findById($id, [
            'parts',
            'works',
            'services',
        ]);

        if ($redirect = $this->hiddenInvoiceRedirect($invoice->is_hidden, $request)) {
            return $redirect;
        }

        return view('admin.invoices.edit', compact('invoice'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
     */

    public function update(UpdateInvoiceRequest $request, $id)
    {

        try {

            $this->repo->update($id, $request->validated());

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice Updated');

        } catch (\Throwable $e) {

            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete (optional)
    |--------------------------------------------------------------------------
     */
    public function destroy($id)
    {
        try {

            $this->repo->delete($id);

            return back()->with('success', '✅ Invoice Deleted');

        } catch (\Throwable $e) {

            report($e);

            return back()->withErrors([
                'error' => '⚠️ Delete failed!',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Hide Invoice
    |--------------------------------------------------------------------------
     */
    public function hide(int $id): RedirectResponse
    {
        try {
            $this->repo->setHiddenStatus($id, true);

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice hidden successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'error' => 'Unable to hide this invoice right now.',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Show Invoice
    |--------------------------------------------------------------------------
     */
    public function restore(Request $request, int $id): RedirectResponse
    {
        try {
            if (! $request->session()->get(config('invoice.hidden_list_session_key'), false)) {
                return redirect()->route('invoices.hidden.index')
                    ->withErrors([
                        'error' => 'Unlock hidden invoices first to show them again.',
                    ]);
            }

            $this->repo->setHiddenStatus($id, false);

            return redirect()->route('invoices.hidden.index')
                ->with('success', 'Invoice is visible in the invoice list again.');
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'error' => 'Unable to show this invoice right now.',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Job No → Fetch (AJAX)
    |--------------------------------------------------------------------------
     */
    public function find(Request $request)
    {
        $job = $this->jobRepo->findByJobNo($request->job_no);

        if (! $job) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($job);
    }

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
     */
    public function pdf(Request $request, $id)
    {
        $invoice = $this->repo->findById($id, [
            'items',
            'job.receive.customer',
            'job.receive.car.brand',
            'job.receive.car.model',
        ]);

        if ($redirect = $this->hiddenInvoiceRedirect($invoice->is_hidden, $request)) {
            return $redirect;
        }

        $showHeader = $request->boolean('header', true);

        $pdf = Pdf::loadView('admin.invoices.pdf', [
            'invoice' => $invoice,
            'showHeader' => $showHeader,
        ])
            ->setPaper('a4', 'portrait');

        return $request->query('action') === 'download'
        ? $pdf->download('invoice-'.$invoice->id.'.pdf')
        : $pdf->stream('invoice-'.$invoice->id.'.pdf');
    }

    private function invoiceListRelations(): array
    {
        return [
            'job.receive.customer',
            'job.receive.car.brand',
            'job.receive.car.model',
        ];
    }

    private function hiddenInvoiceRedirect(bool $isHidden, Request $request): ?RedirectResponse
    {
        if (
            ! $isHidden ||
            $request->session()->get(config('invoice.hidden_list_session_key'), false)
        ) {
            return null;
        }

        return redirect()->route('invoices.hidden.index')
            ->withErrors([
                'error' => 'This invoice is hidden. Enter the password to access it.',
            ]);
    }
}
