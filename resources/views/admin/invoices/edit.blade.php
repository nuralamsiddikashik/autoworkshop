@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

:root {
    --bg:      #F5F6FA;
    --surface: #FFFFFF;
    --border:  #E4E7EF;
    --border2: #CDD1DE;
    --accent:  #2563EB;
    --green:   #059669;
    --amber:   #D97706;
    --danger:  #DC2626;
    --text:    #111827;
    --muted:   #6B7280;
    --faint:   #F3F4F8;
    --mono:    'JetBrains Mono', monospace;
}

* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Syne',sans-serif; background:var(--bg); color:var(--text); }

.inv-page { max-width:1060px; margin:0 auto; padding:28px 20px 120px; }

.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.page-title { font-size:20px; font-weight:700; letter-spacing:-0.3px; }
.page-title span { color:var(--amber); }
.back-btn { font-size:12px; color:var(--muted); text-decoration:none; display:flex; align-items:center; gap:5px; transition:color .15s; }
.back-btn:hover { color:var(--text); }

.err-box { background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:var(--danger); }
.err-box ul { padding-left:16px; margin:0; }

.section-card { background:var(--surface); border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:14px; box-shadow:0 1px 3px rgba(0,0,0,.04); }

.card-header { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1px solid var(--border); background:var(--faint); }

.card-label { font-size:9.5px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:var(--muted); display:flex; align-items:center; gap:7px; }
.card-label::before { content:''; width:5px; height:5px; border-radius:50%; background:var(--accent); display:inline-block; }
.card-label.green::before { background:var(--green); }
.card-label.amber::before { background:var(--amber); }

.count-badge { font-size:10px; color:var(--muted); font-family:var(--mono); }
.card-body { padding:16px 18px 14px; }

/* Job info display (readonly on edit) */
.job-info-card { display:grid; grid-template-columns:1.5fr 1fr 1fr; border:1px solid var(--border); border-left:3px solid var(--amber); border-radius:8px; overflow:hidden; }
.job-info-col { padding:11px 14px; border-right:1px solid var(--border); font-size:11.5px; color:var(--muted); line-height:1.6; }
.job-info-col:last-child { border-right:none; }
.job-info-col strong { display:block; color:var(--text); font-size:13px; margin-bottom:3px; }
.job-reg { font-family:var(--mono); font-size:14px; color:var(--accent); font-weight:500; }

.items-wrap { overflow-x:auto; }
table.inv-table { width:100%; border-collapse:collapse; min-width:700px; }

table.inv-table thead th { font-size:8.5px; font-weight:700; letter-spacing:1.8px; text-transform:uppercase; color:var(--muted); padding:8px 8px; text-align:left; border-bottom:2px solid var(--border); background:var(--faint); white-space:nowrap; }
table.inv-table thead th:nth-child(n+3) { text-align:right; }

table.inv-table tbody td { padding:5px 5px; border-bottom:1px solid var(--border); vertical-align:middle; }
table.inv-table tbody tr:last-child td { border-bottom:none; }
table.inv-table tbody tr:hover td { background:#FAFBFF; }

.td-input { background:#fff; border:1px solid var(--border); border-radius:6px; padding:6px 8px; width:100%; color:var(--text); font-family:var(--mono); font-size:12px; outline:none; transition:border-color .15s, box-shadow .15s; }
.td-input:focus { border-color:var(--accent); box-shadow:0 0 0 2px rgba(37,99,235,.09); }
.td-input.readonly { background:var(--faint); color:var(--green); font-weight:600; cursor:default; }

.td-select { background:#fff; border:1px solid var(--border); border-radius:6px; padding:6px 5px; width:100%; color:var(--text); font-size:12px; outline:none; cursor:pointer; }
.td-select:focus { border-color:var(--accent); }

.sl-num { font-family:var(--mono); font-size:10px; color:var(--border2); text-align:center; padding:0 4px !important; width:24px; }

.del-btn { background:transparent; border:1px solid var(--border); border-radius:6px; color:var(--muted); cursor:pointer; padding:5px 8px; font-size:11px; transition:all .15s; }
.del-btn:hover { background:#FEF2F2; border-color:#FECACA; color:var(--danger); }

.add-row-btn { display:inline-flex; align-items:center; gap:5px; background:transparent; border:1px dashed var(--border2); border-radius:7px; color:var(--muted); font-family:'Syne',sans-serif; font-size:12px; font-weight:500; padding:7px 14px; margin-top:10px; cursor:pointer; transition:all .18s; }
.add-row-btn:hover { border-color:var(--accent); color:var(--accent); background:#EFF6FF; }

.inv-footer-bar { position:fixed; bottom:0; left:0; right:0; background:#fff; border-top:1px solid var(--border); padding:12px 36px; display:flex; align-items:center; justify-content:space-between; z-index:100; box-shadow:0 -4px 20px rgba(0,0,0,.06); }
.footer-totals { display:flex; align-items:center; gap:24px; }
.footer-stat { display:flex; flex-direction:column; gap:1px; }
.footer-stat-label { font-size:8px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--muted); }
.footer-stat-value { font-family:var(--mono); font-size:15px; font-weight:500; color:var(--text); }
.footer-stat-value.highlight { color:var(--accent); font-weight:700; }
.footer-divider { width:1px; height:30px; background:var(--border); }
.footer-actions { display:flex; gap:10px; align-items:center; }

.btn-update { background:var(--amber); color:#fff; border:none; border-radius:8px; padding:9px 26px; font-family:'Syne',sans-serif; font-size:13px; font-weight:700; cursor:pointer; transition:opacity .15s, transform .1s; }
.btn-update:hover { opacity:.88; }
.btn-update:active { transform:scale(.98); }

.btn-cancel { background:transparent; border:1px solid var(--border2); border-radius:8px; padding:9px 18px; color:var(--muted); font-family:'Syne',sans-serif; font-size:13px; cursor:pointer; text-decoration:none; display:inline-block; transition:all .15s; }
.btn-cancel:hover { border-color:var(--text); color:var(--text); }
</style>

<div class="inv-page">
    <div class="page-header">
        <div class="page-title">Edit <span>Invoice</span></div>
        <a href="{{ route('invoices.index') }}" class="back-btn">← Back to list</a>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
    <div class="err-box">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="job_card_id" value="{{ $invoice->job_card_id }}">

    {{-- JOB INFO (readonly display) --}}
    <div class="section-card">
        <div class="card-header"><div class="card-label amber">Job Card</div></div>
        <div class="card-body">
            <div class="job-info-card">
                <div class="job-info-col">
                    <strong>{{ $invoice->job->receive->customer->customer_name }}</strong>
                    @if($invoice->job->receive->customer->owner_phone)
                        <span>Owner: <b>{{ $invoice->job->receive->customer->owner_phone }}</b></span><br>
                    @endif
                    @if($invoice->job->receive->customer->driver_phone)
                        <span>Driver: <b>{{ $invoice->job->receive->customer->driver_phone }}</b></span>
                    @endif
                </div>
                <div class="job-info-col">
                    <div class="job-reg">{{ $invoice->job->receive->car->registration_no }}</div>
                    <span style="font-size:11px;">VIN: {{ $invoice->job->receive->car->vin ?? 'N/A' }}</span>
                </div>
                <div class="job-info-col">
                    <strong>{{ $invoice->job->receive->car->brand->name ?? 'N/A' }}</strong>
                    <span>{{ $invoice->job->receive->car->model->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- PARTS --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label">Parts</div>
            <span class="count-badge" id="parts_count">{{ $invoice->parts->count() }} items</span>
        </div>
        <div class="card-body">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead><tr>
                        <th style="width:24px;">#</th><th>Name</th>
                        <th style="width:62px;">Qty</th><th style="width:90px;">Buy Price</th>
                        <th style="width:86px;">Unit</th><th style="width:90px;">Unit Price</th>
                        <th style="width:96px;">Sell Price</th><th style="width:96px;">Total</th>
                        <th style="width:40px;"></th>
                    </tr></thead>
                    <tbody id="parts_body">
                        @foreach($invoice->parts as $index => $item)
                        <tr>
                            <td class="sl-num">{{ $index + 1 }}</td>
                            <td><input name="parts[{{ $index }}][name]" class="td-input" value="{{ $item->name }}"></td>
                            <td><input type="number" name="parts[{{ $index }}][qty]" class="td-input qty" value="{{ $item->qty }}" min="1"></td>
                            <td><input type="number" name="parts[{{ $index }}][buy_price]" class="td-input buy" value="{{ $item->buy_price }}"></td>
                            <td>
                                <select name="parts[{{ $index }}][unit]" class="td-select">
                                    @foreach(config('invoice.units') as $unit)
                                        <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="parts[{{ $index }}][unit_price]" class="td-input" value="{{ $item->unit_price }}"></td>
                            <td><input type="number" name="parts[{{ $index }}][sell_price]" class="td-input sell" value="{{ $item->sell_price }}"></td>
                            <td><input class="td-input readonly total" readonly value="{{ $item->qty * $item->sell_price }}"></td>
                            <td><button type="button" class="del-btn" onclick="removeRow(this,'parts')">✕</button></td>
                            <input type="hidden" class="profit" name="parts[{{ $index }}][profit]" value="{{ $item->profit ?? 0 }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" onclick="addRow('parts')">+ Add Part</button>
        </div>
    </div>

    {{-- WORKS --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label green">Service Works</div>
            <span class="count-badge" id="works_count">{{ $invoice->works->count() }} items</span>
        </div>
        <div class="card-body">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead><tr>
                        <th style="width:24px;">#</th><th>Name</th>
                        <th style="width:62px;">Qty</th><th style="width:90px;">Buy Price</th>
                        <th style="width:86px;">Unit</th><th style="width:90px;">Unit Price</th>
                        <th style="width:96px;">Sell Price</th><th style="width:96px;">Total</th>
                        <th style="width:40px;"></th>
                    </tr></thead>
                    <tbody id="works_body">
                        @foreach($invoice->works as $index => $item)
                        <tr>
                            <td class="sl-num">{{ $index + 1 }}</td>
                            <td><input name="works[{{ $index }}][name]" class="td-input" value="{{ $item->name }}"></td>
                            <td><input type="number" name="works[{{ $index }}][qty]" class="td-input qty" value="{{ $item->qty }}" min="1"></td>
                            <td><input type="number" name="works[{{ $index }}][buy_price]" class="td-input buy" value="{{ $item->buy_price }}"></td>
                            <td>
                                <select name="works[{{ $index }}][unit]" class="td-select">
                                    @foreach(config('invoice.units') as $unit)
                                        <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="works[{{ $index }}][unit_price]" class="td-input" value="{{ $item->unit_price }}"></td>
                            <td><input type="number" name="works[{{ $index }}][sell_price]" class="td-input sell" value="{{ $item->sell_price }}"></td>
                            <td><input class="td-input readonly total" readonly value="{{ $item->qty * $item->sell_price }}"></td>
                            <td><button type="button" class="del-btn" onclick="removeRow(this,'works')">✕</button></td>
                            <input type="hidden" class="profit" name="works[{{ $index }}][profit]" value="{{ $item->profit ?? 0 }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" onclick="addRow('works')">+ Add Work</button>
        </div>
    </div>

    {{-- SERVICES --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label amber">Service Charges</div>
            <span class="count-badge" id="services_count">{{ $invoice->services->count() }} items</span>
        </div>
        <div class="card-body">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead><tr>
                        <th style="width:24px;">#</th><th>Name</th>
                        <th style="width:62px;">Qty</th><th style="width:90px;">Buy Price</th>
                        <th style="width:86px;">Unit</th><th style="width:90px;">Unit Price</th>
                        <th style="width:96px;">Sell Price</th><th style="width:96px;">Total</th>
                        <th style="width:40px;"></th>
                    </tr></thead>
                    <tbody id="services_body">
                        @foreach($invoice->services as $index => $item)
                        <tr>
                            <td class="sl-num">{{ $index + 1 }}</td>
                            <td><input name="services[{{ $index }}][name]" class="td-input" value="{{ $item->name }}"></td>
                            <td><input type="number" name="services[{{ $index }}][qty]" class="td-input qty" value="{{ $item->qty }}" min="1"></td>
                            <td><input type="number" name="services[{{ $index }}][buy_price]" class="td-input buy" value="{{ $item->buy_price }}"></td>
                            <td>
                                <select name="services[{{ $index }}][unit]" class="td-select">
                                    @foreach(config('invoice.units') as $unit)
                                        <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="services[{{ $index }}][unit_price]" class="td-input" value="{{ $item->unit_price }}"></td>
                            <td><input type="number" name="services[{{ $index }}][sell_price]" class="td-input sell" value="{{ $item->sell_price }}"></td>
                            <td><input class="td-input readonly total" readonly value="{{ $item->qty * $item->sell_price }}"></td>
                            <td><button type="button" class="del-btn" onclick="removeRow(this,'services')">✕</button></td>
                            <input type="hidden" class="profit" name="services[{{ $index }}][profit]" value="{{ $item->profit ?? 0 }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" onclick="addRow('services')">+ Add Service</button>
        </div>
    </div>

    {{-- hidden totals --}}
    <input type="hidden" name="vat"          id="vat_input">
    <input type="hidden" name="grand_total"  id="grand_total_input">
    <input type="hidden" name="bill_amount"  id="bill_amount_input">

    {{-- FOOTER --}}
    <div class="inv-footer-bar">
        <div class="footer-totals">
            <div class="footer-stat">
                <span class="footer-stat-label">Subtotal</span>
                <span class="footer-stat-value" id="grand_total">0.00</span>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-stat">
                <span class="footer-stat-label">VAT (10%)</span>
                <span class="footer-stat-value" id="vat">0.00</span>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-stat">
                <span class="footer-stat-label">Total Payable</span>
                <span class="footer-stat-value highlight" id="bill_amount">0.00</span>
            </div>
        </div>
        <div class="footer-actions">
            <a href="{{ route('invoices.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-update">Update Invoice</button>
        </div>
    </div>

    </form>
</div>

<script>
const units = @json(config('invoice.units') ?? []);
let rowIndex = 1000; // avoid collision with existing blade indexes

function getUnitOptions(selected = '') {
    let op = `<option value="">Unit</option>`;
    units.forEach(u => op += `<option value="${u}" ${u === selected ? 'selected' : ''}>${u}</option>`);
    return op;
}

function updateCount(type) {
    const count = document.querySelectorAll(`#${type}_body tr`).length;
    const el = document.getElementById(`${type}_count`);
    if (el) el.textContent = count + (count === 1 ? ' item' : ' items');
}

function addRow(type) {
    const id  = Date.now();
    const idx = rowIndex++;
    const row = `
    <tr>
        <td class="sl-num">${idx}</td>
        <td><input name="${type}[${id}][name]" class="td-input" placeholder="Item name"></td>
        <td><input type="number" name="${type}[${id}][qty]" class="td-input qty" value="1" min="1"></td>
        <td><input type="number" name="${type}[${id}][buy_price]" class="td-input buy" placeholder="0.00"></td>
        <td><select name="${type}[${id}][unit]" class="td-select">${getUnitOptions()}</select></td>
        <td><input type="number" name="${type}[${id}][unit_price]" class="td-input" placeholder="0.00"></td>
        <td><input type="number" name="${type}[${id}][sell_price]" class="td-input sell" placeholder="0.00"></td>
        <td><input class="td-input readonly total" readonly value="0.00"></td>
        <td><button type="button" class="del-btn" onclick="removeRow(this,'${type}')">✕</button></td>
        <input type="hidden" class="profit" name="${type}[${id}][profit]" value="0">
    </tr>`;
    document.getElementById(type + '_body').insertAdjacentHTML('beforeend', row);
    updateCount(type);
}

function removeRow(btn, type) {
    if (confirm('Remove this row?')) { btn.closest('tr').remove(); calculate(); updateCount(type); }
}

document.addEventListener('input', function (e) {
    const row = e.target.closest('tr');
    if (!row) return;
    const q = Number(row.querySelector('.qty')?.value  || 0);
    const b = Number(row.querySelector('.buy')?.value  || 0);
    const s = Number(row.querySelector('.sell')?.value || 0);
    const total  = q * s;
    const profit = (s - b) * q;
    const totalEl  = row.querySelector('.total');
    const profitEl = row.querySelector('.profit');
    if (totalEl)  totalEl.value  = total.toFixed(2);
    if (profitEl) profitEl.value = profit.toFixed(2);
    calculate();
});

function calculate() {
    let total = 0;
    document.querySelectorAll('.total').forEach(e => {
        // strip commas before parsing (safety net)
        const val = parseFloat((e.value || '0').replace(/,/g, ''));
        total += isNaN(val) ? 0 : val;
    });
    const vat  = total * 0.10;
    const bill = total + vat;
    document.getElementById('grand_total').textContent  = total.toFixed(2);
    document.getElementById('vat').textContent          = vat.toFixed(2);
    document.getElementById('bill_amount').textContent  = bill.toFixed(2);
    document.getElementById('grand_total_input').value  = total.toFixed(2);
    document.getElementById('vat_input').value          = vat.toFixed(2);
    document.getElementById('bill_amount_input').value  = bill.toFixed(2);
}

window.addEventListener('load', calculate);
</script>

@endsection