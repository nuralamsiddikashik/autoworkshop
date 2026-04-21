<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

@if($showHeader ?? true)
@page {
    size: A4;
    margin-top: 0;
    margin-bottom: 15mm; 
    margin-left: 12mm;   
    margin-right: 12mm;
}
@else
@page {
    size: A4;
    margin-top: 0;
    margin-bottom: 15mm;
    margin-left: 12mm;
    margin-right: 12mm;
}
@endif

body {
    font-family: 'Arial Narrow', Arial, sans-serif;
    font-size: 14px; /* Updated to 14px */
    color: #1a1a1a;
    background: #fff;
    line-height: 1.2;
    padding-left: 10px;  
    padding-right: 10px; 
    
    @if($showHeader ?? true)
    margin-top: 20px;
    @else
    padding-top: 150px; 
    @endif
}

.w100 { 
    width: 100%; 
}
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial Narrow', Arial, sans-serif; }

.cf   { clear: both; }
.fl   { float: left; }
.fr   { float: right; }
.r    { text-align: right; }

.fixed-spacer {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    @if($showHeader ?? true)
        height: 0;
    @else
        height: 150px;
    @endif
    background: #fff;
    z-index: -1; 
}

/* ════ REAL HEADER ════ */
.inv-header {
    width: 100%;
    border-bottom: 2px solid #1a1a1a;
    padding-bottom: 11px;
    margin-bottom: 10px;
    overflow: hidden;
    @if(!($showHeader ?? true))
    display: none;
    @endif
}

.brand-name {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.3px;
    line-height: 1;
}

.brand-tagline {
    font-size: 9px;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #777;
    margin-top: 3px;
}

.company-addr {
    text-align: right;
    font-size: 12px;
    line-height: 1.8;
    color: #444;
}

/* ════ TITLE ════ */
.doc-title {
    text-align: center;
    font-size: 14px; /* Updated to 14px */
    font-weight: 700;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #ccc;
}

/* ════ REFERENCE STRIPS ════ */
.ref-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #d0d0d0;
    table-layout: fixed;
}

.ref-table.no-top { border-top: none; margin-bottom: 15px; }

.ref-table td {
    padding: 7px 12px;
    font-size: 13px;
    border-right: 1px solid #d0d0d0;
    width: 33.33%;
}

.ref-table td:last-child { border-right: none; }

.rk { font-weight: 700; color: #111; }
.rv { font-size: 13px; color: #1a1a1a; }

/* ════ META INFO ════ */
.meta-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #d0d0d0;
    margin-bottom: 15px;
    table-layout: fixed;
}

.meta-box {
    width: 50%;
    padding: 12px 15px;
    vertical-align: top;
    border-right: 1px solid #d0d0d0;
}

.meta-box:last-child { border-right: none; }

.meta-box-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    padding-bottom: 4px;
    margin-bottom: 5px;
    border-bottom: 1px solid #eee;
}

.mr { width: 100%; margin-bottom: 3px; font-size: 14px; overflow: hidden; }

.mr .mk {
    float: left;
    width: 110px;
    font-weight: 600;
    color: #555;
    font-size: 13px;
}

.mr .mv {
    display: block;
    margin-left: 115px;
    color: #111;
}

.mv-mono { font-size: 13px; }

/* ════ ITEMS TABLE ════ */
table.items-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    border: 1px solid #d0d0d0;
}

table.items-table thead th {
    background: transparent;
    color: #1a1a1a;
    border: 1px solid #d0d0d0;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 2px 10px;
    text-align: left;
}

table.items-table thead th.r { text-align: right; }

table.items-table tbody td {
    padding: 2px 10px;
    border: 1px solid #d0d0d0;
    color: #222;
    vertical-align: middle;
    font-size: 14px; /* Updated to 14px */
}

table.items-table tbody td.r {
    text-align: right;
    font-size: 13px;
}

.sl-num    { color: #bbb; font-size: 12px; }
.item-name { font-weight: 400; } 
.item-unit { color: #999; font-size: 13px; }

.section-tag-cell { padding: 0 !important; border: 1px solid #d0d0d0 !important; background: #f7f7f7; }

.section-tag {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #555;
    padding: 2px 10px;
    border-left: 2.5px solid #1a1a1a;
}

tr.sub-row td {
    background: transparent;
    border: 1px solid #d0d0d0;
    border-bottom: 1.5px solid #1a1a1a;
    font-weight: 700;
    font-size: 14px; /* Consistent with request */
    letter-spacing: 0.5px;
    padding: 3px 10px;
    text-transform: uppercase;
}

/* ════ BOTTOM ════ */
.bottom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    table-layout: fixed;
}

.bottom-table td { vertical-align: top; }
.bottom-table .bl { width: 55%; padding-right: 15px; }
.bottom-table .br { width: 45%; }

.words-box {
    border: 1px solid #d0d0d0;
    border-left: 2.5px solid #1a1a1a;
    padding: 10px 12px;
    margin-bottom: 8px;
}

.words-lbl {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 4px;
}

.words-txt { font-style: italic; font-size: 14px; line-height: 1.5; color: #111; }

.note-box { border: 1px dashed #d0d0d0; padding: 10px 12px; min-height: 34px; }

.note-lbl {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #ccc;
    margin-bottom: 3px;
}

table.sum-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #d0d0d0;
    max-width: 180px;       
    margin-left: auto;      
}

table.sum-table tr td {
    padding: 5px 10px;       
    font-size: 13px;         
    border-bottom: 1px solid #eee;
    color: #333;
}

table.sum-table tr td:last-child {
    text-align: right;
    font-size: 13px;
    font-weight: 600;
    color: #111;
}

table.sum-table tr.sum-divider {
    border-top: 1.5px solid #1a1a1a;
}

table.sum-table tr.sum-divider td {
    font-weight: 700;
    font-size: 14px;
}

table.sum-table tr.sum-pay td { color: #999; }

table.sum-table tr.sum-due td {
    background: transparent;
    color: #1a1a1a;
    border-top: 1.5px solid #1a1a1a;
    font-weight: 700;
    font-size: 14px;
    border-bottom: none;
    padding: 6px 10px;
}

table.sum-table tr.sum-due td:last-child {
    color: #1a1a1a;
    font-size: 14px;
}

/* ════ SIGNATURES ════ */
table.sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 35px;
    table-layout: fixed;
    page-break-inside: avoid;
}

table.sig-table td {
    width: 33.33%;
    text-align: center;
    padding: 0 8px;
    vertical-align: bottom;
}

.sig-space { height: 30px; }

.sig-line {
    border-top: 1px solid #1a1a1a;
    padding-top: 5px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #333;
}

.sig-sub { font-size: 9px; color: #aaa; letter-spacing: 0.8px; margin-top: 2px; }

/* ════ FOOTER ════ */
.inv-footer {
    margin-top: 16px;
    padding-top: 8px;
    border-top: 1px solid #eee;
    overflow: hidden;
    font-size: 10px;
    color: #bbb;
}

</style>
</head>
<body>

<div class="fixed-spacer"></div>

<div class="w100">

    <div class="inv-header">
        <div class="fl">
            <div class="brand-name">Ashis Auto Solution</div>
            <div class="brand-tagline">Experiences of Auto Solution</div>
        </div>
        <div class="fr">
            <div class="company-addr">
                100 Feet | Madani Avenue | Beraid | Dhaka 1212<br>
                01712287659 &nbsp;|&nbsp; 01971287659 &nbsp;|&nbsp; 01678094899
            </div>
        </div>
        <div class="cf"></div>
    </div>

    <div class="doc-title">Customer Bill</div>

    <table class="ref-table">
        <tr>
            <td><span class="rk">Registration:</span> <span class="rv">{{ $invoice->job->receive->car->registration_no }}</span></td>
            <td><span class="rk">Job Order No:</span> <span class="rv">{{ $invoice->job->job_no }}</span></td>
            <td><span class="rk">CS No:</span> <span class="rv">{{ $invoice->cs_no ?? '—' }}</span></td>
        </tr>
    </table>

    <table class="ref-table no-top">
        <tr>
            <td><span class="rk">VAT Reg No:</span> <span class="rv">006191423-0101</span></td>
            <td><span class="rk">Date:</span> <span class="rv">{{ $invoice->created_at->format('d-m-Y') }}</span></td>
            <td><span class="rk">Bill No:</span> <span class="rv">{{ $invoice->bill_no }}</span></td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td class="meta-box">
                <div class="meta-box-title">Customer Information</div>
                <div class="mr"><span class="mk">Account Name</span><span class="mv">{{ $invoice->job->receive->customer->account_name ?? $invoice->job->receive->customer->customer_name }}</span></div>
                <div class="mr"><span class="mk">Customer Name</span><span class="mv">{{ $invoice->job->receive->customer->customer_name }}</span></div>
                <div class="mr"><span class="mk">Tel / Phone</span><span class="mv">{{ $invoice->job->receive->customer->owner_phone ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Driver</span><span class="mv">{{ $invoice->job->receive->customer->driver_name ?? '—' }}@if($invoice->job->receive->customer->driver_phone) ({{ $invoice->job->receive->customer->driver_phone }})@endif</span></div>
                <div class="mr"><span class="mk">Address</span><span class="mv">{{ $invoice->job->receive->customer->address ?? '—' }}</span></div>
            </td>
            <td class="meta-box">
                <div class="meta-box-title">Vehicle Details</div>
                <div class="mr"><span class="mk">Estimate No</span><span class="mv">{{ $invoice->estimate_no ?? '0' }}</span></div>
                <div class="mr"><span class="mk">Chassis</span><span class="mv">{{ $invoice->job->receive->car->vin ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Engine No</span><span class="mv">{{ $invoice->job->receive->car->engine_no ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Brand / Model</span><span class="mv">{{ $invoice->job->receive->car->brand->name }} {{ $invoice->job->receive->car->model->name }}</span></div>
                <div class="mr"><span class="mk">KM</span><span class="mv">{{ number_format($invoice->job->receive->km ?? 0) }}</span></div>
            </td>
        </tr>
    </table>

    @php
        $partItems    = $invoice->items->where('type', 'part');
        $workItems    = $invoice->items->where('type', 'work');
        $serviceItems = $invoice->items->where('type', 'service');
    @endphp

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:5%;">SL</th>
                <th style="width:41%;">Description</th>
                <th class="r" style="width:8%;">Qty</th>
                <th style="width:8%;">Unit</th>
                <th class="r" style="width:19%;">Unit Price</th>
                <th class="r" style="width:19%;">Amount (TK)</th>
            </tr>
        </thead>
        <tbody>
            @if($partItems->count())
            <tr><td colspan="6" class="section-tag-cell"><div class="section-tag">Parts</div></td></tr>
            @foreach($partItems as $i => $item)
            <tr>
                <td class="sl-num">{{ $i + 1 }}</td>
                <td class="item-name">{{ $item->name }}</td>
                <td class="r">{{ $item->qty }}</td>
                <td class="item-unit">{{ $item->unit ?? 'Pc' }}</td>
                <td class="r">{{ number_format($item->sell_price, 2) }}</td>
                <td class="r">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="sub-row">
                <td colspan="5" style="text-align:right;">Sub Total Tk.</td>
                <td class="r">{{ number_format($invoice->parts_total, 2) }}</td>
            </tr>
            @endif

            @if($workItems->count())
            <tr><td colspan="6" class="section-tag-cell"><div class="section-tag">Service Works</div></td></tr>
            @foreach($workItems as $i => $item)
            <tr>
                <td class="sl-num">{{ $i + 1 }}</td>
                <td class="item-name">{{ $item->name }}</td>
                <td class="r">{{ $item->qty }}</td>
                <td class="item-unit">{{ $item->unit ?? 'Unit' }}</td>
                <td class="r">{{ number_format($item->sell_price, 2) }}</td>
                <td class="r">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="sub-row">
                <td colspan="5" style="text-align:right;">Sub Total Tk.</td>
                <td class="r">{{ number_format($invoice->works_total, 2) }}</td>
            </tr>
            @endif

            @if($serviceItems->count())
            <tr><td colspan="6" class="section-tag-cell"><div class="section-tag">Service Charges</div></td></tr>
            @foreach($serviceItems as $i => $item)
            <tr>
                <td class="sl-num">{{ $i + 1 }}</td>
                <td class="item-name">{{ $item->name }}</td>
                <td class="r">{{ $item->qty }}</td>
                <td class="item-unit">{{ $item->unit ?? 'Unit' }}</td>
                <td class="r">{{ number_format($item->sell_price, 2) }}</td>
                <td class="r">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="sub-row">
                <td colspan="5" style="text-align:right;">Sub Total Tk.</td>
                <td class="r">{{ number_format($invoice->service_total, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <table class="bottom-table">
        <tr>
            <td class="bl">
                <div class="words-box">
                    <div class="words-lbl">In Words</div>
                    <div class="words-txt">{{ $invoice->bill_amount_in_words ?? '—' }}</div>
                </div>
                <div class="note-box">
                    <div class="note-lbl">Note</div>
                    <div style="font-size:13px; color:#555; margin-top:2px;">{{ $invoice->note ?? '' }}</div>
                </div>
            </td>
            <td class="br">
                <table class="sum-table">
                    <tr>
                        <td>Total Tk.</td>
                        <td>{{ number_format($invoice->parts_total + $invoice->works_total + ($invoice->service_total ?? 0), 2) }}</td>
                    </tr>
                    <tr>
                        <td>VAT Total (10%)</td>
                        <td>{{ number_format($invoice->vat, 2) }}</td>
                    </tr>
                    <tr class="sum-divider">
                        <td>Bill Amount</td>
                        <td>{{ number_format($invoice->bill_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>{{ number_format($invoice->paymentDetails->sum('discount_amount') ?? 0, 2) }}</td>
                    </tr>
                    <tr class="sum-pay">
                        <td>Paid</td>
                        <td>{{ number_format($invoice->paid_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr class="sum-due">
                        <td>Due Amount</td>
                        <td>{{ number_format($invoice->due_amount ?? $invoice->bill_amount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="sig-table">
        <tr>
            <td>
                <div class="sig-space"></div>
                <div class="sig-line">Service Engineer</div>
                <div class="sig-sub">Signature &amp; Date</div>
            </td>
            <td>
                <div class="sig-space"></div>
                <div class="sig-line">Bill Department</div>
                <div class="sig-sub">Signature &amp; Date</div>
            </td>
            <td>
                <div class="sig-space"></div>
                <div class="sig-line">Client Received</div>
                <div class="sig-sub">Signature &amp; Date</div>
            </td>
        </tr>
    </table>

    <div class="inv-footer">
        <span class="fl">Ashis Auto Solution &mdash; 100 Feet, Madani Avenue, Beraid, Dhaka 1212</span>
        <span class="fr">Computer generated invoice</span>
        <div class="cf"></div>
    </div>

</div>
</body>
</html>