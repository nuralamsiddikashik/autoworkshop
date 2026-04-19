@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

:root {
--bg:        #F4F6FA;
--surface:   #FFFFFF;
--surface2:  #F8F9FC;
--border:    #E2E6EF;
--border2:   #D0D6E4;
--accent:    #E87B2A;   /* orange */
--accent2:   #E87B2A;   /* blue */
--danger:    #EF4444;
--text:      #1A2035;
--muted:     #7B8499;
--faint:     #E2E6EF;
--green: #059669;
}

* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Syne', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
}

.inv-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 32px 24px 120px;
}

/* ── Page Header ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}

.page-title {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.page-title span {
    color: var(--accent);
}

.back-btn {
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color .2s;
}
.back-btn:hover { color: var(--text); }

/* ── Section Card ── */
.section-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 0;
    margin-bottom: 16px;
    overflow: hidden;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
}

.card-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-label::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--accent);
}

.card-label.green::before { background: var(--accent2); }
.card-label.amber::before { background: #F5A623; }

.card-body { padding: 20px; }

/* ── Job Search ── */
.job-search-wrap {
    display: flex;
    gap: 10px;
    align-items: center;
}

.job-input {
    background: var(--bg);
    border: 1px solid var(--border2);
    border-radius: 8px;
    padding: 10px 14px;
    color: var(--text);
    font-family: var(--mono);
    font-size: 13px;
    width: 220px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}

.job-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(79,142,247,.12);
}

.job-info-box {
    margin-top: 14px;
}

.job-info-card {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 0;
    background: var(--bg);
    border: 1px solid var(--border2);
    border-left: 3px solid var(--accent2);
    border-radius: 10px;
    overflow: hidden;
}

.job-info-col {
    padding: 14px 16px;
    border-right: 1px solid var(--border);
    font-size: 12px;
    line-height: 1.7;
    color: var(--muted);
}

.job-info-col:last-child { border-right: none; }

.job-info-col strong {
    display: block;
    color: var(--text);
    font-size: 13px;
    margin-bottom: 4px;
}

.job-reg {
    font-family: var(--mono);
    font-size: 15px;
    color: var(--accent2);
    font-weight: 500;
}

/* ── Items Table ── */
.items-wrap { overflow-x: auto; }

table.inv-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
    min-width: 720px;
}

table.inv-table thead th {
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    padding: 8px 10px;
    text-align: left;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
}

table.inv-table thead th:nth-child(n+3) { text-align: right; }

table.inv-table tbody td {
    padding: 6px 6px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

table.inv-table tbody tr:last-child td { border-bottom: none; }

table.inv-table tbody tr:hover td {
    background: rgba(79,142,247,.03);
}

/* ── Inputs in table ── */
.td-input {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 7px 9px;
    width: 100%;
    color: var(--text);
    font-family: var(--mono);
    font-size: 11.5px;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}

.td-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 2px rgba(79,142,247,.12);
}

.td-input.readonly {
    background: var(--faint);
    color: var(--green);
    font-weight: 500;
    cursor: default;
}

.td-select {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 7px 6px;
    width: 100%;
    color: var(--text);
    font-family: 'Syne', sans-serif;
    font-size: 11.5px;
    outline: none;
    cursor: pointer;
}

.td-select:focus { border-color: var(--accent); }

.sl-cell {
    font-family: var(--mono);
    font-size: 10px;
    color: var(--faint);
    text-align: center;
    width: 28px;
    padding: 0 4px !important;
}

/* ── Row delete btn ── */
.del-btn {
    background: transparent;
    border: 1px solid var(--border2);
    border-radius: 6px;
    color: var(--muted);
    cursor: pointer;
    padding: 5px 8px;
    font-size: 11px;
    transition: all .15s;
    white-space: nowrap;
}

.del-btn:hover {
    background: rgba(247,111,111,.12);
    border-color: var(--danger);
    color: var(--danger);
}

/* ── Add row button ── */
.add-row-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: transparent;
    border: 1px dashed var(--border2);
    border-radius: 7px;
    color: var(--muted);
    font-family: 'Syne', sans-serif;
    font-size: 12px;
    font-weight: 500;
    padding: 8px 16px;
    margin-top: 12px;
    cursor: pointer;
    transition: all .2s;
}

.add-row-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(79,142,247,.06);
}

/* ── Fixed Footer Bar ── */
.inv-footer-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--surface);
    border-top: 1px solid var(--border);
    padding: 14px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 100;
    backdrop-filter: blur(10px);
}

.footer-totals {
    display: flex;
    align-items: center;
    gap: 28px;
}

.footer-stat {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.footer-stat-label {
    font-size: 8.5px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
}

.footer-stat-value {
    font-family: var(--mono);
    font-size: 15px;
    font-weight: 500;
    color: var(--text);
}

.footer-stat-value.highlight { color: var(--accent2); }

.footer-divider {
    width: 1px;
    height: 32px;
    background: var(--border);
}

.footer-actions { display: flex; gap: 10px; align-items: center; }

.btn-save {
    background: var(--accent2);
    color: #0F1117;
    border: none;
    border-radius: 8px;
    padding: 10px 28px;
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 0.3px;
    transition: opacity .2s, transform .1s;
}

.btn-save:hover { opacity: .88; }
.btn-save:active { transform: scale(.98); }

.btn-cancel {
    background: transparent;
    border: 1px solid var(--border2);
    border-radius: 8px;
    padding: 10px 20px;
    color: var(--muted);
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all .2s;
}

.btn-cancel:hover {
    border-color: var(--text);
    color: var(--text);
}

/* ── Status badge ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
}

.badge-ok {
    background: rgba(61,220,151,.12);
    color: var(--accent2);
    border: 1px solid rgba(61,220,151,.25);
}

.badge-err {
    background: rgba(247,111,111,.12);
    color: var(--danger);
    border: 1px solid rgba(247,111,111,.25);
}
</style>

<div class="inv-page">

    <div class="page-header">
        <div class="page-title">Create <span>Invoice</span></div>
        <a href="{{ route('invoices.index') }}" class="back-btn">← Back to list</a>
    </div>

    <form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    {{-- JOB --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label">Job Card</div>
        </div>
        <div class="card-body">
            <div class="job-search-wrap">
                <input type="text" id="job_no" class="job-input" placeholder="Enter job no...">
                <input type="hidden" name="job_card_id" id="job_card_id">
            </div>
            <div id="job_info_box" class="job-info-box"></div>
        </div>
    </div>

    {{-- PARTS --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label">Parts</div>
            <span id="parts_count" style="font-size:11px; color:var(--muted); font-family:var(--mono);">0 items</span>
        </div>
        <div class="card-body" style="padding-bottom:16px;">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th style="width:28px;">#</th>
                            <th>Name</th>
                            <th style="width:60px;">Qty</th>
                            <th style="width:90px;">Buy Price</th>
                            <th style="width:90px;">Unit</th>
                            <th style="width:90px;">Unit Price</th>
                            <th style="width:100px;">Sell Price</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:44px;"></th>
                        </tr>
                    </thead>
                    <tbody id="parts_body"></tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" onclick="addRow('parts')">
                <span>+</span> Add Part
            </button>
        </div>
    </div>

    {{-- WORKS --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label green">Service Works</div>
            <span id="works_count" style="font-size:11px; color:var(--muted); font-family:var(--mono);">0 items</span>
        </div>
        <div class="card-body" style="padding-bottom:16px;">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th style="width:28px;">#</th>
                            <th>Name</th>
                            <th style="width:60px;">Qty</th>
                            <th style="width:90px;">Buy Price</th>
                            <th style="width:90px;">Unit</th>
                            <th style="width:90px;">Unit Price</th>
                            <th style="width:100px;">Sell Price</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:44px;"></th>
                        </tr>
                    </thead>
                    <tbody id="works_body"></tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" style="--accent:#3DDC97;" onclick="addRow('works')">
                <span>+</span> Add Work
            </button>
        </div>
    </div>

    {{-- SERVICES --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label amber">Service Charges</div>
            <span id="services_count" style="font-size:11px; color:var(--muted); font-family:var(--mono);">0 items</span>
        </div>
        <div class="card-body" style="padding-bottom:16px;">
            <div class="items-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th style="width:28px;">#</th>
                            <th>Name</th>
                            <th style="width:60px;">Qty</th>
                            <th style="width:90px;">Buy Price</th>
                            <th style="width:90px;">Unit</th>
                            <th style="width:90px;">Unit Price</th>
                            <th style="width:100px;">Sell Price</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:44px;"></th>
                        </tr>
                    </thead>
                    <tbody id="services_body"></tbody>
                </table>
            </div>
            <button type="button" class="add-row-btn" onclick="addRow('services')">
                <span>+</span> Add Service
            </button>
        </div>
    </div>

    {{-- FOOTER BAR --}}
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

        {{-- 🔥 IMPORTANT: Hidden Inputs (ADD THIS) --}}
        <input type="hidden" name="grand_total" id="grand_total_input">
        <input type="hidden" name="vat" id="vat_input">
        <input type="hidden" name="bill_amount" id="bill_amount_input">

        <div class="footer-actions">
            <a href="{{ route('invoices.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">Save Invoice</button>
        </div>
    </div>

    </form>
</div>

<script>
const units = @json($units ?? []);
</script>

<script>
let rowIndex = 1;

function getUnitOptions() {
    let op = `<option value="">Unit</option>`;
    units.forEach(u => op += `<option value="${u}">${u}</option>`);
    return op;
}

function updateCount(type) {
    const count = document.querySelectorAll(`#${type}_body tr`).length;
    const el = document.getElementById(`${type}_count`);
    if (el) el.textContent = count + (count === 1 ? ' item' : ' items');
}

function addRow(type) {
    const id   = Date.now();
    const idx  = rowIndex++;

    const row = `
    <tr id="row_${id}">
        <td class="sl-cell">${idx}</td>
        <td><input name="${type}[${id}][name]" class="td-input" placeholder="Item name"></td>
        <td><input type="number" name="${type}[${id}][qty]" class="td-input qty" value="1" min="1"></td>
        <td><input type="number" name="${type}[${id}][buy_price]" class="td-input buy" placeholder="0.00"></td>
        <td>
            <select name="${type}[${id}][unit]" class="td-select">
                ${getUnitOptions()}
            </select>
        </td>
        <td><input type="number" name="${type}[${id}][unit_price]" class="td-input" placeholder="0.00"></td>
        <td><input type="number" name="${type}[${id}][sell_price]" class="td-input sell" placeholder="0.00"></td>
        <td><input class="td-input readonly total" readonly value="0.00"></td>
        <td>
            <button type="button" class="del-btn" onclick="removeRow(this, '${type}')">✕</button>
        </td>
        <input type="hidden" class="profit" name="${type}[${id}][profit]">
    </tr>`;

    document.getElementById(type + '_body').insertAdjacentHTML('beforeend', row);
    updateCount(type);

    // focus name input
    const tbody = document.getElementById(type + '_body');
    const lastRow = tbody.lastElementChild;
    lastRow?.querySelector('input[type="text"]')?.focus();
}

function removeRow(btn, type) {
    if (confirm('Remove this row?')) {
        btn.closest('tr').remove();
        calculate();
        updateCount(type);
    }
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

document.getElementById('job_no').addEventListener('blur', function () {
    const jobNo = this.value.trim();
    const box   = document.getElementById('job_info_box');
    if (!jobNo) return;

    fetch(`{{ route('invoices.find') }}?job_no=${encodeURIComponent(jobNo)}`)
        .then(res => res.json())
        .then(data => {
            if (!data || !data.id) {
                box.innerHTML = `
                    <div style="margin-top:10px;">
                        <span class="status-badge badge-err">✕ Job card not found</span>
                    </div>`;
                document.getElementById('job_card_id').value = '';
                return;
            }

            document.getElementById('job_card_id').value = data.id;

            const c = data.receive.customer;
            const car = data.receive.car;

            let phones = '';
            if (c.owner_phone)     phones += `<span>Owner: <b>${c.owner_phone}</b></span>`;
            if (c.transport_phone) phones += `<span>Transport: <b>${c.transport_phone}</b></span>`;
            if (c.driver_phone)    phones += `<span>Driver: <b>${c.driver_phone}</b></span>`;
            if (c.office_phone)    phones += `<span>Office: <b>${c.office_phone}</b></span>`;

            box.innerHTML = `
            <div class="job-info-card">
                <div class="job-info-col">
                    <strong>${c.customer_name}</strong>
                    <div style="display:flex;flex-direction:column;gap:2px;font-size:11px;">${phones}</div>
                </div>
                <div class="job-info-col">
                    <div class="job-reg">${car.registration_no}</div>
                    <span style="font-size:11px;">VIN: ${car.vin ?? 'N/A'}</span>
                </div>
                <div class="job-info-col">
                    <strong>${car.brand?.name ?? 'N/A'}</strong>
                    <span>${car.model?.name ?? 'N/A'}</span>
                </div>
            </div>`;
        })
        .catch(() => {
            box.innerHTML = `
                <div style="margin-top:10px;">
                    <span class="status-badge badge-err">Server error</span>
                </div>`;
        });
});

function calculate() {
    let total = 0;

    document.querySelectorAll('.total').forEach(e => {
        total += Number(e.value || 0);
    });

    const vat = total * 0.10;
    const bill = total + vat;

    // UI update
    document.getElementById('grand_total').textContent = total.toFixed(2);
    document.getElementById('vat').textContent = vat.toFixed(2);
    document.getElementById('bill_amount').textContent = bill.toFixed(2);

    // 🔥 hidden input update (THIS WAS MISSING)
    document.getElementById('grand_total_input').value = total;
    document.getElementById('vat_input').value = vat;
    document.getElementById('bill_amount_input').value = bill;
}

window.onload = () => addRow('parts');
</script>

@endsection