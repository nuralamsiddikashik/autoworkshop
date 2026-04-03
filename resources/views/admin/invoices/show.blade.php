@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap');

* { margin: 0; padding: 0; box-sizing: border-box; }

.invoice-wrap {
    font-family: 'IBM Plex Sans', sans-serif;
    color: #1a1a1a;
    max-width: 900px;
    margin: 0 auto;
    padding: 32px 36px;
    background: #fff;
}

/* ── Header ── */
.inv-header {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 24px;
    align-items: start;
    border-bottom: 2.5px solid #1a1a1a;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.5px;
    line-height: 1;
}

.brand-tagline {
    font-size: 10px;
    font-weight: 300;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #555;
    margin-top: 4px;
}

.company-addr {
    text-align: right;
    font-size: 11px;
    line-height: 1.8;
    color: #444;
}

/* ── Doc Title ── */
.doc-title {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.doc-label {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.doc-line {
    flex: 1;
    height: 1px;
    background: #ccc;
}

/* ── Reference Strips ── */
.ref-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    border: 1px solid #ddd;
    border-bottom: none;
}

.ref-strip-bottom {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.ref-item {
    padding: 10px 16px;
    border-right: 1px solid #ddd;
    font-size: 11.5px;
}

.ref-item:last-child { border-right: none; }

.ref-k {
    font-weight: 600;
    color: #444;
    margin-right: 6px;
}

.ref-v {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 10.5px;
}

/* ── Meta Info Grid ── */
.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.meta-box {
    padding: 16px 20px;
    border-right: 1px solid #ddd;
}

.meta-box:last-child { border-right: none; }

.meta-box-title {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid #eee;
}

.meta-row {
    display: flex;
    gap: 8px;
    margin-bottom: 5px;
    font-size: 12px;
    line-height: 1.5;
}

.meta-key {
    font-weight: 500;
    color: #555;
    min-width: 90px;
    flex-shrink: 0;
}

.meta-val { color: #1a1a1a; font-weight: 400; }
.meta-val.mono { font-family: 'IBM Plex Mono', monospace; font-size: 11px; }

/* ── Section Tag ── */
.section-tag {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #555;
    padding: 8px 12px 6px;
    border-left: 2.5px solid #1a1a1a;
    margin: 12px 0 0;
}

/* ── Items Table ── */
table.items-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
}

table.items-table thead th {
    background: #1a1a1a;
    color: #fff;
    font-size: 9.5px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 9px 12px;
    text-align: left;
}

table.items-table thead th:nth-child(n+3) { text-align: right; }

table.items-table tbody td {
    padding: 9px 12px;
    border-bottom: 1px solid #eee;
    color: #222;
    vertical-align: middle;
}

table.items-table tbody td:nth-child(n+3) {
    text-align: right;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11.5px;
}

.sl-cell {
    color: #999;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11px;
}

.desc-cell { font-weight: 500; }

.subtotal-row td {
    font-weight: 600;
    border-top: 1.5px solid #1a1a1a;
    border-bottom: 2px solid #1a1a1a;
    background: #f7f7f7;
    font-size: 11px;
    letter-spacing: 0.5px;
}

/* ── Bottom Section ── */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 24px;
    margin-top: 24px;
    align-items: start;
}

.words-box {
    padding: 16px 20px;
    border: 1px solid #ddd;
    border-left: 3px solid #1a1a1a;
}

.words-label {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 6px;
}

.words-text {
    font-style: italic;
    font-family: 'Playfair Display', serif;
    font-size: 13px;
    line-height: 1.6;
}

.note-box {
    margin-top: 12px;
    padding: 12px 20px;
    border: 1px dashed #ccc;
    font-size: 11px;
    color: #777;
    min-height: 60px;
}

.note-label {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 4px;
}

/* ── Summary Table ── */
table.summary-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

table.summary-table tr td {
    padding: 9px 14px;
    font-size: 12px;
    border-bottom: 1px solid #eee;
}

table.summary-table tr td:last-child {
    text-align: right;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11.5px;
    font-weight: 500;
}

table.summary-table tr.total-due td {
    border-bottom: none;
    font-weight: 700;
    font-size: 13.5px;
    background: #1a1a1a;
    color: #fff;
}

table.summary-table tr.pay-row td { color: #555; }

/* ── Signature ── */
.sig-section {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
    margin-top: 48px;
}

.sig-item {
    text-align: center;
    padding-top: 44px;
    border-top: 1.5px solid #1a1a1a;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #555;
}

/* ── Footer ── */
.invoice-footer {
    margin-top: 28px;
    padding-top: 12px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: #aaa;
    letter-spacing: 0.5px;
}

/* ── Action Buttons (hidden on print) ── */
.action-bar {
    max-width: 900px;
    margin: 24px auto 12px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-inv {
    padding: 9px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'IBM Plex Sans', sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: opacity 0.15s;
}

.btn-inv:hover { opacity: 0.8; }
.btn-back-inv { background: #fff; color: #444; border: 1px solid #ccc; }
.btn-print-inv { background: #1a1a1a; color: #fff; border: none; }

/* ── Print Overrides ── */
@media print {
    .action-bar { display: none; }
    .invoice-wrap { padding: 16px 20px; max-width: 100%; }
    body { background: #fff !important; }
}
</style>

{{-- Action Buttons --}}
<div class="action-bar">
    <a href="{{ route('invoices.index') }}" class="btn-inv btn-back-inv">← Back</a>
    <a href="{{ route('invoices.pdf', $invoice->id) }}" target="_blank" class="btn-inv btn-print-inv">👁️ View PDF</a>
    <a href="{{ route('invoices.pdf', $invoice->id) }}?action=download" class="btn-inv btn-print-inv">⬇️ Download</a>
    <button onclick="window.print()" class="btn-inv btn-print-inv">🖨️ Print</button>
</div>

<div class="invoice-wrap">

    {{-- Header --}}
    <div class="inv-header">
        <div>
            <div class="brand-name">Ashis Auto Solution</div>
            <div class="brand-tagline">Experiences of Auto Solution</div>
        </div>
        <div class="company-addr">
            100 Feet | Madani Avenue | Beraid | Dhaka 1212<br>
            01712287659 &nbsp;|&nbsp; 01971287659 &nbsp;|&nbsp; 01678094899
        </div>
    </div>

    {{-- Document Title --}}
    <div class="doc-title">
        <div class="doc-label">Customer Bill</div>
        <div class="doc-line"></div>
    </div>

    {{-- Reference Strip Top --}}
    <div class="ref-strip">
        <div class="ref-item">
            <span class="ref-k">Registration</span>
            <span class="ref-v">{{ $invoice->job->receive->car->registration_no }}</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Job Order No</span>
            <span class="ref-v">{{ $invoice->job->job_no }}</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Receive No</span>
            <span class="ref-v">{{ $invoice->job->receive->receive_no ?? '—' }}</span>
        </div>
    </div>

    {{-- Reference Strip Bottom --}}
    <div class="ref-strip-bottom">
        <div class="ref-item">
            <span class="ref-k">VAT Reg No</span>
            <span class="ref-v">006191423-0101</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Date</span>
            <span class="ref-v">{{ $invoice->created_at->format('d-m-Y') }}</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Bill No</span>
            <span class="ref-v">{{ $invoice->bill_no }}</span>
        </div>
    </div>

    {{-- Customer & Vehicle Info --}}
    <div class="meta-grid">
        <div class="meta-box">
            <div class="meta-box-title">Customer Information</div>
            <div class="meta-row">
                <span class="meta-key">Account Name</span>
                <span class="meta-val">{{ $invoice->job->receive->customer->account_name ?? $invoice->job->receive->customer->customer_name }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Customer Name</span>
                <span class="meta-val">{{ $invoice->job->receive->customer->customer_name }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Owner Phone</span>
                <span class="meta-val mono">{{ $invoice->job->receive->customer->owner_phone ?? '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Transport Phone</span>
                <span class="meta-val">
                    @if($invoice->job->receive->customer->transport_phone)
                        <span class="mono">&nbsp;({{ $invoice->job->receive->customer->transport_phone }})</span>
                    @endif
                </span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Driver</span>
                <span class="meta-val">
                    @if($invoice->job->receive->customer->driver_phone)
                        <span class="mono">&nbsp;({{ $invoice->job->receive->customer->driver_phone }})</span>
                    @endif
                </span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Address</span>
                <span class="meta-val">{{ $invoice->job->receive->customer->address ?? '—' }}</span>
            </div>
        </div>

        <div class="meta-box">
            <div class="meta-box-title">Vehicle Details</div>
            <div class="meta-row">
                <span class="meta-key">Estimate No</span>
                <span class="meta-val mono">{{ $invoice->estimate_no ?? '0' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">VIN</span>
                <span class="meta-val mono">{{ $invoice->job->receive->car->vin ?? '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Engine No</span>
                <span class="meta-val mono">{{ $invoice->job->receive->car->engine_no ?? '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Brand / Model</span>
                <span class="meta-val">{{ $invoice->job->receive->car->brand->name }} {{ $invoice->job->receive->car->model->name }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">KM</span>
                <span class="meta-val mono">{{ number_format($invoice->job->receive->odometer ?? 0) }}</span>
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    @php
        $partItems    = $invoice->items->where('type', 'part');
        $workItems    = $invoice->items->where('type', 'work');
        $serviceItems = $invoice->items->where('type', 'service');
    @endphp

    <table class="items-table">
        <thead>
            <tr>
                <th width="36">SL</th>
                <th>Description</th>
                <th width="56">Qty</th>
                <th width="60">Unit</th>
                <th width="110">Unit Price</th>
                <th width="120">Amount (TK)</th>
            </tr>
        </thead>
        <tbody>

            {{-- PARTS --}}
            @if($partItems->count())
                <tr>
                    <td colspan="6" style="padding: 0; border-bottom: none;">
                        <div class="section-tag">Parts</div>
                    </td>
                </tr>
                @foreach($partItems as $i => $item)
                    <tr>
                        <td class="sl-cell">{{ $i + 1 }}</td>
                        <td class="desc-cell">{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td style="color:#888; font-size:11px;">{{ $item->unit ?? 'Pc' }}</td>
                        <td>{{ number_format($item->sell_price, 2) }}</td>
                        <td style="font-weight:600;">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal-row">
                    <td colspan="5" style="text-align:right; letter-spacing:1px; text-transform:uppercase;">Sub Total Tk.</td>
                    <td>{{ number_format($invoice->parts_total, 2) }}</td>
                </tr>
            @endif

            {{-- SERVICE WORKS --}}
            @if($workItems->count())
                <tr>
                    <td colspan="6" style="padding: 0; border-bottom: none;">
                        <div class="section-tag">Service Works</div>
                    </td>
                </tr>
                @foreach($workItems as $i => $item)
                    <tr>
                        <td class="sl-cell">{{ $i + 1 }}</td>
                        <td class="desc-cell">{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td style="color:#888; font-size:11px;">{{ $item->unit ?? 'Unit' }}</td>
                        <td>{{ number_format($item->sell_price, 2) }}</td>
                        <td style="font-weight:600;">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal-row">
                    <td colspan="5" style="text-align:right; letter-spacing:1px; text-transform:uppercase;">Sub Total Tk.</td>
                    <td>{{ number_format($invoice->works_total, 2) }}</td>
                </tr>
            @endif

            {{-- SERVICE CHARGES --}}
            @if($serviceItems->count())
                <tr>
                    <td colspan="6" style="padding: 0; border-bottom: none;">
                        <div class="section-tag">Service Charges</div>
                    </td>
                </tr>
                @foreach($serviceItems as $i => $item)
                    <tr>
                        <td class="sl-cell">{{ $i + 1 }}</td>
                        <td class="desc-cell">{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td style="color:#888; font-size:11px;">{{ $item->unit ?? 'Unit' }}</td>
                        <td>{{ number_format($item->sell_price, 2) }}</td>
                        <td style="font-weight:600;">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal-row">
                    <td colspan="5" style="text-align:right; letter-spacing:1px; text-transform:uppercase;">Sub Total Tk.</td>
                    <td>{{ number_format($invoice->service_total, 2) }}</td>
                </tr>
            @endif

        </tbody>
    </table>

    {{-- Bottom Section --}}
    <div class="bottom-grid">

        <div>
            <div class="words-box">
                <div class="words-label">In Words</div>
                <div class="words-text">
                    {{ numberToWords($invoice->bill_amount) ?? '—' }}
                </div>
            </div>
            <div class="note-box">
                <div class="note-label">Note</div>
                {{ $invoice->note ?? '' }}
            </div>
        </div>

        <table class="summary-table">
            <tr>
                <td>Total Tk.</td>
                <td>{{ number_format($invoice->parts_total + $invoice->works_total + ($invoice->service_total ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td>VAT Total (10%)</td>
                <td>{{ number_format($invoice->vat, 2) }}</td>
            </tr>
            <tr>
                <td style="font-weight:600;">Bill Amount</td>
                <td>{{ number_format($invoice->bill_amount, 2) }}</td>
            </tr>
            <tr class="pay-row">
                <td>Pay</td>
                <td>{{ number_format($invoice->paid ?? 0, 2) }}</td>
            </tr>
            <tr class="total-due">
                <td>Due Amount</td>
                <td>{{ number_format($invoice->due_amount ?? $invoice->bill_amount, 2) }}</td>
            </tr>
        </table>

    </div>

    {{-- Signatures --}}
    <div class="sig-section">
        <div class="sig-item">Received By</div>
        <div class="sig-item">Checked By</div>
        <div class="sig-item">Authorized Signature</div>
    </div>
</div>

@endsection