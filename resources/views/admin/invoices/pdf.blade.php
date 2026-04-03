<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

@page {
    size: A4;
    margin: 18mm 22mm 18mm 22mm; /* ডানে ও বামে মার্জিন বাড়ানো হয়েছে */
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 10.5px;
    color: #1a1a1a;
    background: #fff;
    line-height: 1.4;
    padding: 0 10px; /* ডানে-বামে অতিরিক্ত প্যাডিং */
}

.w100 { width: 100%; }
.cf   { clear: both; }
.fl   { float: left; }
.fr   { float: right; }
.r    { text-align: right; }

/* ════ HEADER ════ */
.inv-header {
    width: 100%;
    border-bottom: 2px solid #1a1a1a;
    padding-bottom: 11px;
    margin-bottom: 15px;
    overflow: hidden;
}

.brand-name {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -0.3px;
    line-height: 1;
}

.brand-tagline {
    font-size: 7px;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #777;
    margin-top: 3px;
}

.company-addr {
    text-align: right;
    font-size: 8.5px;
    line-height: 1.8;
    color: #444;
}

/* ════ TITLE ════ */
.doc-title {
    text-align: center;
    font-size: 10.5px;
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
    padding: 7px 12px; /* প্যাডিং বাড়ানো হয়েছে */
    font-size: 9px;
    border-right: 1px solid #d0d0d0;
    width: 33.33%;
}

.ref-table td:last-child { border-right: none; }

.rk { font-weight: 700; color: #111; }
.rv { font-family: 'DejaVu Sans Mono', monospace; font-size: 8.5px; color: #1a1a1a; }

/* ════ META INFO ════ */
.meta-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #d0d0d0;
    margin-top: 0;
    margin-bottom: 15px;
    table-layout: fixed;
}

.meta-box {
    width: 50%;
    padding: 12px 15px; /* প্যাডিং বাড়ানো হয়েছে */
    vertical-align: top;
    border-right: 1px solid #d0d0d0;
}

.meta-box:last-child { border-right: none; }

.meta-box-title {
    font-size: 6.5px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    padding-bottom: 4px;
    margin-bottom: 5px;
    border-bottom: 1px solid #eee;
}

.mr { width: 100%; margin-bottom: 3px; font-size: 9.5px; overflow: hidden; }

.mr .mk {
    float: left;
    width: 84px;
    font-weight: 600;
    color: #555;
    font-size: 9px;
}

.mr .mv {
    display: block;
    margin-left: 88px;
    color: #111;
}

.mv-mono { font-family: 'DejaVu Sans Mono', monospace; font-size: 8.5px; }

/* ════ ITEMS TABLE ════ */
table.items-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

table.items-table thead th {
    background: #1a1a1a;
    color: #fff;
    font-size: 7px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 8px 10px;
    text-align: left;
}

table.items-table thead th.r { text-align: right; }

table.items-table tbody td {
    padding: 7px 10px;
    border-bottom: 1px solid #f0f0f0;
    color: #222;
    vertical-align: middle;
    font-size: 9.5px;
}

table.items-table tbody td.r {
    text-align: right;
    font-family: 'DejaVu Sans Mono', monospace;
    font-size: 9px;
}

.sl-num { color: #bbb; font-family: 'DejaVu Sans Mono', monospace; font-size: 8px; }
.item-name { font-weight: 700; }
.item-unit { color: #999; font-size: 8.5px; }

.section-tag-cell { padding: 0 !important; border-bottom: none !important; background: #f7f7f7; }

.section-tag {
    font-size: 6.5px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #555;
    padding: 5px 10px;
    border-left: 2.5px solid #1a1a1a;
}

tr.sub-row td {
    background: transparent; /* ব্যাকগ্রাউন্ড রিমুভ করা হয়েছে */
    border-top: 1px solid #ccc;
    border-bottom: 1.5px solid #1a1a1a;
    font-weight: 700;
    font-size: 8.5px;
    letter-spacing: 0.5px;
    padding: 7px 10px;
    text-transform: uppercase;
}

/* ════ BOTTOM: WORDS + SUMMARY ════ */
.bottom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    table-layout: fixed;
}

.bottom-table td { vertical-align: top; }
.bottom-table .bl { width: 52%; padding-right: 15px; }
.bottom-table .br { width: 48%; }

.words-box {
    border: 1px solid #d0d0d0;
    border-left: 2.5px solid #1a1a1a;
    padding: 10px 12px;
    margin-bottom: 8px;
}

.words-lbl {
    font-size: 6.5px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 4px;
}

.words-txt { font-style: italic; font-size: 9.5px; line-height: 1.5; color: #111; }

.note-box { border: 1px dashed #d0d0d0; padding: 10px 12px; min-height: 34px; }

.note-lbl {
    font-size: 6.5px;
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
}

table.sum-table tr td {
    padding: 6px 10px;
    font-size: 9.5px;
    border-bottom: 1px solid #eee;
    color: #333;
}

table.sum-table tr td:last-child {
    text-align: right;
    font-family: 'DejaVu Sans Mono', monospace;
    font-size: 9px;
    font-weight: 600;
    color: #111;
}

table.sum-table tr.sum-divider td {
    border-top: 1.5px solid #1a1a1a;
    font-weight: 700;
    font-size: 10px;
}

table.sum-table tr.sum-pay td { color: #999; }

table.sum-table tr.sum-due td {
    background: #1a1a1a;
    color: #fff;
    font-weight: 700;
    font-size: 11px;
    border-bottom: none;
    padding: 8px 10px;
}

table.sum-table tr.sum-due td:last-child {
    color: #fff;
    font-family: 'DejaVu Sans Mono', monospace;
    font-size: 10.5px;
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
    font-size: 7.5px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #333;
}

.sig-sub { font-size: 6.5px; color: #aaa; letter-spacing: 0.8px; margin-top: 2px; }

</style>
</head>
<body>
<div class="w100">

    {{-- HEADER --}}
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

    {{-- TITLE --}}
    <div class="doc-title">Customer Bill</div>

    {{-- REF STRIP TOP --}}
    <table class="ref-table">
        <tr>
            <td><span class="rk">Registration:</span> <span class="rv">{{ $invoice->job->receive->car->registration_no }}</span></td>
            <td><span class="rk">Job Order No:</span> <span class="rv">{{ $invoice->job->job_no }}</span></td>
            <td><span class="rk">CS No:</span> <span class="rv">{{ $invoice->cs_no ?? '—' }}</span></td>
        </tr>
    </table>

    {{-- REF STRIP BOTTOM --}}
    <table class="ref-table no-top">
        <tr>
            <td><span class="rk">VAT Reg No:</span> <span class="rv">006191423-0101</span></td>
            <td><span class="rk">Date:</span> <span class="rv">{{ $invoice->created_at->format('d-m-Y') }}</span></td>
            <td><span class="rk">Bill No:</span> <span class="rv">{{ $invoice->bill_no }}</span></td>
        </tr>
    </table>

    {{-- CUSTOMER & VEHICLE --}}
    <table class="meta-table">
        <tr>
            <td class="meta-box">
                <div class="meta-box-title">Customer Information</div>
                <div class="mr"><span class="mk">Account Name</span><span class="mv">{{ $invoice->job->receive->customer->account_name ?? $invoice->job->receive->customer->customer_name }}</span></div>
                <div class="mr"><span class="mk">Customer Name</span><span class="mv">{{ $invoice->job->receive->customer->customer_name }}</span></div>
                <div class="mr"><span class="mk">Tel / Phone</span><span class="mv mv-mono">{{ $invoice->job->receive->customer->owner_phone ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Driver</span><span class="mv">{{ $invoice->job->receive->customer->driver_name ?? '—' }}@if($invoice->job->receive->customer->driver_phone) ({{ $invoice->job->receive->customer->driver_phone }})@endif</span></div>
                <div class="mr"><span class="mk">Address</span><span class="mv">{{ $invoice->job->receive->customer->address ?? '—' }}</span></div>
            </td>
            <td class="meta-box">
                <div class="meta-box-title">Vehicle Details</div>
                <div class="mr"><span class="mk">Estimate No</span><span class="mv mv-mono">{{ $invoice->estimate_no ?? '0' }}</span></div>
                <div class="mr"><span class="mk">Chassis</span><span class="mv mv-mono">{{ $invoice->job->receive->car->vin ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Engine No</span><span class="mv mv-mono">{{ $invoice->job->receive->car->engine_no ?? '—' }}</span></div>
                <div class="mr"><span class="mk">Brand / Model</span><span class="mv">{{ $invoice->job->receive->car->brand->name }} {{ $invoice->job->receive->car->model->name }}</span></div>
                <div class="mr"><span class="mk">KM</span><span class="mv mv-mono">{{ number_format($invoice->job->receive->km ?? 0) }}</span></div>
            </td>
        </tr>
    </table>

    {{-- ITEMS TABLE --}}
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
                <td class="r" style="font-weight:700;">{{ number_format($item->total, 2) }}</td>
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
                <td class="r" style="font-weight:700;">{{ number_format($item->total, 2) }}</td>
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
                <td class="r" style="font-weight:700;">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="sub-row">
                <td colspan="5" style="text-align:right;">Sub Total Tk.</td>
                <td class="r">{{ number_format($invoice->service_total, 2) }}</td>
            </tr>
            @endif

        </tbody>
    </table>

    {{-- BOTTOM --}}
    <table class="bottom-table">
        <tr>
            <td class="bl">
                <div class="words-box">
                    <div class="words-lbl">In Words</div>
                    <div class="words-txt">{{ $invoice->bill_amount_in_words ?? '—' }}</div>
                </div>
                <div class="note-box">
                    <div class="note-lbl">Note</div>
                    <div style="font-size:9px; color:#555; margin-top:2px;">{{ $invoice->note ?? '' }}</div>
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
                    <tr class="sum-pay">
                        <td>Pay</td>
                        <td>{{ number_format($invoice->paid ?? 0, 2) }}</td>
                    </tr>
                    <tr class="sum-due">
                        <td>Due Amount</td>
                        <td>{{ number_format($invoice->due_amount ?? $invoice->bill_amount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- SIGNATURES --}}
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


</div>
</body>
</html>