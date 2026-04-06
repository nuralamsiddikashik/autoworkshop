@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap');

* { margin: 0; padding: 0; box-sizing: border-box; }

.rcpt-wrap {
    font-family: 'IBM Plex Sans', sans-serif;
    color: #1a1a1a;
    max-width: 860px;
    margin: 0 auto;
    padding: 32px 36px;
    background: #fff;
}

/* ── Action Bar ── */
.action-bar {
    max-width: 860px;
    margin: 24px auto 12px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-act {
    padding: 9px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'IBM Plex Sans', sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: opacity 0.15s;
    display: inline-block;
}

.btn-act:hover { opacity: 0.8; }
.btn-back { background: #fff; color: #444; border: 1px solid #ccc; }
.btn-print { background: #1a1a1a; color: #fff; border: none; }

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

/* ── Reference Strip ── */
.ref-strip {
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

/* ── Customer Box ── */
.customer-box {
    border: 1px solid #ddd;
    border-left: 3px solid #1a1a1a;
    padding: 16px 20px;
    margin-bottom: 20px;
}

.customer-box-title {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #eee;
}

.customer-name {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.customer-meta {
    font-size: 12px;
    color: #555;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.customer-meta span { display: flex; align-items: center; gap: 5px; }
.customer-meta .mono { font-family: 'IBM Plex Mono', monospace; font-size: 11px; }

/* ── Amount Grid ── */
.amount-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}

.amount-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px 20px;
    position: relative;
    overflow: hidden;
}

.amount-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}

.amount-card.bill::before  { background: #1a1a1a; }
.amount-card.disc::before  { background: #D97706; }
.amount-card.paid::before  { background: #059669; }
.amount-card.due::before   { background: #DC2626; }

.amount-card-label {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 8px;
}

.amount-card-value {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 22px;
    font-weight: 500;
    color: #1a1a1a;
    line-height: 1;
}

.amount-card.paid .amount-card-value { color: #059669; }
.amount-card.due  .amount-card-value { color: #DC2626; }
.amount-card.disc .amount-card-value { color: #D97706; }

/* ── Invoices breakdown ── */
.breakdown-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.breakdown-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-bottom: 1px solid #ddd;
    background: #fafafa;
}

.breakdown-title {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #888;
    display: flex;
    align-items: center;
    gap: 7px;
}

.breakdown-title::before {
    content: '';
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #2563EB;
    display: inline-block;
}

table.breakdown-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
}

table.breakdown-table thead th {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #94A3B8;
    padding: 10px 18px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

table.breakdown-table thead th:nth-child(n+2) { text-align: right; }

table.breakdown-table tbody td {
    padding: 10px 18px;
    border-bottom: 1px solid #f5f5f5;
    color: #333;
    vertical-align: middle;
}

table.breakdown-table tbody tr:last-child td { border-bottom: none; }
table.breakdown-table tbody td:nth-child(n+2) {
    text-align: right;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11.5px;
}

.inv-id-badge {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11px;
    color: #2563EB;
    font-weight: 500;
}

.pay-amt  { color: #059669; font-weight: 600; }
.disc-amt { color: #D97706; }

/* ── In Words ── */
.words-box {
    border: 1px solid #ddd;
    border-left: 3px solid #1a1a1a;
    padding: 14px 18px;
    margin-bottom: 20px;
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
    font-size: 14px;
    line-height: 1.6;
    color: #1a1a1a;
}

/* ── Signatures ── */
.sig-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    margin-top: 52px;
    padding-top: 0;
}

.sig-item {
    text-align: center;
}

.sig-line-area {
    height: 48px;
    border-bottom: 1.5px solid #1a1a1a;
    margin-bottom: 8px;
}

.sig-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #555;
}

.sig-sub {
    font-size: 9px;
    color: #aaa;
    margin-top: 3px;
    letter-spacing: 0.5px;
}

/* ── Footer ── */
.rcpt-footer {
    margin-top: 28px;
    padding-top: 12px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: #aaa;
    letter-spacing: 0.5px;
}

/* ── Print ── */
@media print {
    .action-bar { display: none; }
    .rcpt-wrap { padding: 16px 20px; max-width: 100%; }
    body { background: #fff !important; }
}
</style>

{{-- Action Bar --}}
<div class="action-bar">
    <a href="{{ route('money.receipts.index') }}" class="btn-act btn-back">← Back</a>
    <button onclick="window.print()" class="btn-act btn-print">🖨️ Print</button>
</div>

<div class="rcpt-wrap">

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

    {{-- Doc Title --}}
    <div class="doc-title">
        <div class="doc-label">Money Receipt</div>
        <div class="doc-line"></div>
    </div>

    {{-- Reference Strip --}}
    <div class="ref-strip">
        <div class="ref-item">
            <span class="ref-k">Receipt No</span>
            <span class="ref-v">{{ $receipt->receipt_no }}</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Date</span>
          <span class="ref-v">{{ $receipt->created_at ? $receipt->created_at->format('d-m-Y') : '—' }}</span>
        </div>
        <div class="ref-item">
            <span class="ref-k">Received By</span>
            <span class="ref-v">{{ $receipt->received_by ?? '—' }}</span>
        </div>
    </div>

    {{-- Customer --}}
    <div class="customer-box">
        <div class="customer-box-title">Customer</div>
        <div class="customer-name">{{ $receipt->customer->customer_name }}</div>
        <div class="customer-meta">
            @if($receipt->customer->owner_phone)
                <span>📞 <span class="mono">{{ $receipt->customer->owner_phone }}</span></span>
            @endif
            @if($receipt->customer->address)
                <span>📍 {{ $receipt->customer->address }}</span>
            @endif
        </div>
    </div>

    {{-- Amount Grid --}}
   
        @php
            $totalBill = $receipt->details->sum(function($d){
                return $d->invoice->bill_amount ?? 0;
            });
            $totalDiscount = $receipt->details->sum('discount_amount');
            $totalPaid     = $receipt->details->sum('pay_amount');
            $totalDue      = $totalBill - $totalDiscount - $totalPaid;
        @endphp
  

    <div class="amount-grid">
        <div class="amount-card bill">
            <div class="amount-card-label">Bill Amount</div>
            <div class="amount-card-value">{{ number_format($totalBill, 2) }}</div>
        </div>
        <div class="amount-card disc">
            <div class="amount-card-label">Discount</div>
            <div class="amount-card-value">{{ number_format($totalDiscount, 2) }}</div>
        </div>
        <div class="amount-card paid">
            <div class="amount-card-label">Paid Amount</div>
            <div class="amount-card-value">{{ number_format($totalPaid, 2) }}</div>
        </div>
        <div class="amount-card due">
            <div class="amount-card-label">Due Amount</div>
            <div class="amount-card-value"> {{ number_format($totalDue, 2) }}</div>
        </div>
    </div>

    {{-- Invoice Breakdown --}}
    @if($receipt->details->count())
    <div class="breakdown-card">
        <div class="breakdown-header">
            <div class="breakdown-title">Invoice Breakdown</div>
            <span style="font-size:10px; color:#888; font-family:'IBM Plex Mono',monospace;">
                {{ $receipt->details->count() }} invoice(s)
            </span>
        </div>
        <table class="breakdown-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Bill Amount</th>
                    <th>Discount</th>
                    <th>Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receipt->details as $detail)
                <tr>
                    <td><span class="inv-id-badge">#{{ $detail->invoice_id }}</span></td>
                    <td>{{ number_format($detail->bill_amount ?? 0, 2) }}</td>
                    <td class="disc-amt">{{ number_format($detail->discount_amount ?? 0, 2) }}</td>
                    <td class="pay-amt">{{ number_format($detail->pay_amount ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- In Words --}}
    <div class="words-box">
        <div class="words-label">In Words</div>
        <div class="words-text">
            {{ $receipt->paid_in_words ?? '—' }}
        </div>
    </div>

    {{-- Signatures --}}
    <div class="sig-section">
        <div class="sig-item">
            <div class="sig-line-area"></div>
            <div class="sig-label">Customer Signature</div>
            <div class="sig-sub">Name &amp; Date</div>
        </div>
        <div class="sig-item">
            <div class="sig-line-area"></div>
            <div class="sig-label">Authorized Signature</div>
            <div class="sig-sub">Name &amp; Date</div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="rcpt-footer">
        <span>Ashis Auto Solution &mdash; 100 Feet, Madani Avenue, Beraid, Dhaka 1212</span>
        <span>This is a computer generated receipt</span>
    </div>

</div>

@endsection