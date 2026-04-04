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

.rcpt-page { max-width:900px; margin:0 auto; padding:28px 20px 120px; }

.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.page-title { font-size:20px; font-weight:700; letter-spacing:-0.3px; }
.page-title span { color:var(--green); }
.back-btn { font-size:12px; color:var(--muted); text-decoration:none; display:flex; align-items:center; gap:5px; transition:color .15s; }
.back-btn:hover { color:var(--text); }

/* ── Cards ── */
.section-card { background:var(--surface); border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:14px; box-shadow:0 1px 3px rgba(0,0,0,.04); }
.card-header { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1px solid var(--border); background:var(--faint); }
.card-label { font-size:9.5px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:var(--muted); display:flex; align-items:center; gap:7px; }
.card-label::before { content:''; width:5px; height:5px; border-radius:50%; background:var(--green); display:inline-block; }
.card-label.blue::before { background:var(--accent); }
.card-body { padding:16px 18px; }

/* ── Customer Select ── */
.select-wrap { position:relative; }
.select-wrap::after { content:'▾'; position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:12px; pointer-events:none; }

.cust-select {
    width:100%; appearance:none;
    background:#fff; border:1px solid var(--border2);
    border-radius:8px; padding:10px 36px 10px 13px;
    color:var(--text); font-family:'Syne',sans-serif;
    font-size:13px; outline:none; cursor:pointer;
    transition:border-color .15s, box-shadow .15s;
}
.cust-select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(37,99,235,.1); }

/* ── Customer info strip ── */
.cust-info-strip {
    display:none;
    margin-top:12px;
    padding:10px 14px;
    background:var(--faint);
    border:1px solid var(--border);
    border-left:3px solid var(--green);
    border-radius:8px;
    font-size:12px;
    color:var(--muted);
    gap:20px;
    align-items:center;
}
.cust-info-strip.visible { display:flex; }
.cust-info-strip strong { color:var(--text); font-size:13px; }

/* ── Empty state ── */
.empty-state {
    text-align:center; padding:40px 20px;
    color:var(--muted); font-size:13px;
}
.empty-state .icon { font-size:32px; margin-bottom:10px; opacity:.4; }

/* ── Invoices Table ── */
.items-wrap { overflow-x:auto; }
table.rcpt-table { width:100%; border-collapse:collapse; min-width:600px; }

table.rcpt-table thead th {
    font-size:8.5px; font-weight:700; letter-spacing:1.8px;
    text-transform:uppercase; color:var(--muted);
    padding:8px 10px; text-align:left;
    border-bottom:2px solid var(--border);
    background:var(--faint); white-space:nowrap;
}
table.rcpt-table thead th.r { text-align:right; }

table.rcpt-table tbody td {
    padding:8px 10px; border-bottom:1px solid var(--border);
    vertical-align:middle; font-size:12.5px;
}
table.rcpt-table tbody tr:last-child td { border-bottom:none; }
table.rcpt-table tbody tr:hover td { background:#FAFBFF; }

.inv-id {
    font-family:var(--mono); font-size:11px;
    color:var(--accent); font-weight:500;
}

.amount-cell {
    font-family:var(--mono); font-size:12px;
    text-align:right;
}

.due-cell {
    font-family:var(--mono); font-size:12px;
    font-weight:700; color:var(--danger);
    text-align:right;
}

.due-zero { color:var(--green); }

/* ── Editable inputs in table ── */
.td-input {
    background:#fff; border:1px solid var(--border);
    border-radius:6px; padding:6px 8px; width:100%;
    color:var(--text); font-family:var(--mono); font-size:12px;
    outline:none; transition:border-color .15s, box-shadow .15s;
    text-align:right;
}
.td-input:focus { border-color:var(--accent); box-shadow:0 0 0 2px rgba(37,99,235,.09); }
.td-input.pay-input:focus { border-color:var(--green); box-shadow:0 0 0 2px rgba(5,150,105,.1); }
.td-input.disc-input:focus { border-color:var(--amber); box-shadow:0 0 0 2px rgba(217,119,6,.1); }

/* ── Loading state ── */
.loading-row td {
    text-align:center; padding:24px;
    color:var(--muted); font-size:12px;
}
.spinner {
    display:inline-block; width:16px; height:16px;
    border:2px solid var(--border);
    border-top-color:var(--accent);
    border-radius:50%;
    animation:spin .7s linear infinite;
    vertical-align:middle; margin-right:8px;
}
@keyframes spin { to { transform:rotate(360deg); } }

/* ── Footer bar ── */
.rcpt-footer-bar {
    position:fixed; bottom:0; left:0; right:0;
    background:#fff; border-top:1px solid var(--border);
    padding:12px 36px;
    display:flex; align-items:center; justify-content:space-between;
    z-index:100; box-shadow:0 -4px 20px rgba(0,0,0,.06);
}
.footer-totals { display:flex; align-items:center; gap:24px; }
.footer-stat { display:flex; flex-direction:column; gap:1px; }
.footer-stat-label { font-size:8px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--muted); }
.footer-stat-value { font-family:var(--mono); font-size:15px; font-weight:500; color:var(--text); }
.footer-stat-value.green { color:var(--green); font-weight:700; }
.footer-stat-value.amber { color:var(--amber); font-weight:700; }
.footer-divider { width:1px; height:30px; background:var(--border); }
.footer-actions { display:flex; gap:10px; align-items:center; }

.btn-submit {
    background:var(--green); color:#fff; border:none;
    border-radius:8px; padding:9px 26px;
    font-family:'Syne',sans-serif; font-size:13px; font-weight:700;
    cursor:pointer; transition:opacity .15s, transform .1s;
}
.btn-submit:hover { opacity:.88; }
.btn-submit:active { transform:scale(.98); }
.btn-submit:disabled { opacity:.4; cursor:not-allowed; }

.btn-cancel {
    background:transparent; border:1px solid var(--border2);
    border-radius:8px; padding:9px 18px; color:var(--muted);
    font-family:'Syne',sans-serif; font-size:13px; cursor:pointer;
    text-decoration:none; display:inline-block; transition:all .15s;
}
.btn-cancel:hover { border-color:var(--text); color:var(--text); }
</style>

<div class="rcpt-page">

    <div class="page-header">
        <div class="page-title">Create <span>Money Receipt</span></div>
        <a href="{{ route('money.receipts.index') }}" class="back-btn">← Back to list</a>
    </div>

    {{-- CUSTOMER SELECT --}}
    <div class="section-card">
        <div class="card-header">
            <div class="card-label">Select Customer</div>
        </div>
        <div class="card-body">
            <div class="select-wrap">
                <select id="customer" class="cust-select">
                    <option value="">Choose a customer...</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="cust-info-strip" id="cust_info">
                <strong id="cust_name">—</strong>
                <span id="cust_meta"></span>
            </div>
        </div>
    </div>

    {{-- INVOICE TABLE --}}
    <form method="POST" action="{{ route('money.receipts.store') }}" id="receipt_form">
    @csrf
    <input type="hidden" name="customer_id" id="customer_id">

    <div class="section-card">
        <div class="card-header">
            <div class="card-label blue">Due Invoices</div>
            <span id="inv_count" style="font-size:10px; color:var(--muted); font-family:var(--mono);"></span>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="items-wrap">
                <table class="rcpt-table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th class="r">Bill Amount</th>
                            <th class="r">Paid</th>
                            <th class="r">Due</th>
                            <th style="width:120px;">Pay Now</th>
                            <th style="width:110px;">Discount</th>
                        </tr>
                    </thead>
                    <tbody id="invoice_table">
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="icon">🧾</div>
                                    Select a customer to load due invoices
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="rcpt-footer-bar">
        <div class="footer-totals">
            <div class="footer-stat">
                <span class="footer-stat-label">Total Due</span>
                <span class="footer-stat-value" id="total_due">0.00</span>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-stat">
                <span class="footer-stat-label">Paying Now</span>
                <span class="footer-stat-value green" id="total_pay">0.00</span>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-stat">
                <span class="footer-stat-label">Total Discount</span>
                <span class="footer-stat-value amber" id="total_disc">0.00</span>
            </div>
        </div>
        <div class="footer-actions">
            <a href="{{ route('money.receipts.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit" id="submit_btn" disabled>Save Receipt</button>
        </div>
    </div>

    </form>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const custSelect = document.getElementById('customer');
    const custInfo   = document.getElementById('cust_info');
    const custName   = document.getElementById('cust_name');
    const custMeta   = document.getElementById('cust_meta');
    const tbody      = document.getElementById('invoice_table');
    const invCount   = document.getElementById('inv_count');
    const submitBtn  = document.getElementById('submit_btn');

    custSelect.addEventListener('change', function () {
        const customerId = this.value;

        document.getElementById('customer_id').value = customerId;

        if (!customerId) {
            custInfo.classList.remove('visible');
            tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><div class="icon">🧾</div>Select a customer to load due invoices</div></td></tr>`;
            invCount.textContent = '';
            submitBtn.disabled = true;
            updateFooter();
            return;
        }

        // Show selected name immediately
        const selectedOpt = this.options[this.selectedIndex];
        custName.textContent  = selectedOpt.text;
        custMeta.textContent  = '';
        custInfo.classList.add('visible');

        // Loading state
        tbody.innerHTML = `<tr class="loading-row"><td colspan="6"><span class="spinner"></span> Loading invoices...</td></tr>`;
        invCount.textContent = '';
        submitBtn.disabled = true;

        fetch('/money-receipts/customer/' + customerId + '/due-invoices')
            .then(res => res.json())
            .then(data => {

                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><div class="icon">✅</div>No due invoices for this customer</div></td></tr>`;
                    invCount.textContent = '0 invoices';
                    submitBtn.disabled = true;
                    updateFooter();
                    return;
                }

                invCount.textContent = data.length + (data.length === 1 ? ' invoice' : ' invoices');
                submitBtn.disabled = false;

                let html = '';
                data.forEach(function (item, i) {
                    const due     = parseFloat(item.due_amount || 0);
                    const dueClass = due <= 0 ? 'due-zero' : '';

                    html += `
                    <tr>
                        <td><span class="inv-id">#${item.id}</span></td>
                        <td class="amount-cell">${parseFloat(item.bill_amount).toFixed(2)}</td>
                        <td class="amount-cell">${parseFloat(item.paid_amount || 0).toFixed(2)}</td>
                        <td class="due-cell ${dueClass}">${due.toFixed(2)}</td>
                        <td>
                            <input type="number" name="payments[${i}][pay]"
                                class="td-input pay-input" min="0" max="${due}" step="0.01"
                                placeholder="0.00" oninput="updateFooter()">
                        </td>
                        <td>
                            <input type="number" name="payments[${i}][discount]"
                                class="td-input disc-input" min="0" step="0.01"
                                placeholder="0.00" oninput="updateFooter()">
                        </td>
                        <input type="hidden" name="payments[${i}][invoice_id]" value="${item.id}">
                    </tr>`;
                });

                tbody.innerHTML = html;

                // update total due in footer
                let totalDue = data.reduce((s, d) => s + parseFloat(d.due_amount || 0), 0);
                document.getElementById('total_due').textContent = totalDue.toFixed(2);
            })
            .catch(() => {
                tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state" style="color:var(--danger);">Failed to load invoices. Please try again.</div></td></tr>`;
            });
    });

    window.updateFooter = function () {
        let pay  = 0;
        let disc = 0;
        document.querySelectorAll('.pay-input').forEach(e  => { pay  += parseFloat(e.value  || 0); });
        document.querySelectorAll('.disc-input').forEach(e => { disc += parseFloat(e.value || 0); });
        document.getElementById('total_pay').textContent  = pay.toFixed(2);
        document.getElementById('total_disc').textContent = disc.toFixed(2);
    };

});
</script>
@endsection