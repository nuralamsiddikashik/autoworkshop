@extends('layouts.app')

@section('content')

{{-- ===== CSS LAYOUT ONLY ===== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap');

    .inv-page {
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1.5rem 120px 1.5rem;
        background: #F8F9FA;
        min-height: 100vh;
    }

    /* Full Width Card Design */
    .section-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        width: 100%;
    }

    .section-title {
        font-size: 13px; font-weight: 600; color: #64748B;
        text-transform: uppercase; letter-spacing: 1px;
        margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
    }

    /* Table Full Width Optimization */
    .inv-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .inv-table th { 
        text-align: left; font-size: 11px; color: #94A3B8; 
        padding: 12px; text-transform: uppercase; border-bottom: 1px solid #F1F5F9;
    }
    .inv-table td { padding: 10px; border-bottom: 1px solid #F8FAFC; }

    /* Input Styling */
    .td-input { 
        border: 1px solid #E2E8F0; background: #F8FAFC; 
        padding: 10px 12px; border-radius: 6px; width: 100%; font-size: 14px;
        outline: none; transition: 0.2s;
    }
    .td-input:focus { border-color: #94A3B8; background: #fff; }
    .td-readonly { background: #EDF2F7; font-weight: 600; font-family: 'JetBrains Mono'; color: #2D3748; border: none; }

    /* Bottom Sticky Summary Bar */
    .inv-footer-bar {
        position: fixed; bottom: 0; left: 0; right: 0;
        background: #1A202C; color: #fff;
        padding: 15px 40px; display: flex; justify-content: space-between; align-items: center;
        z-index: 1000; border-top: 2px solid #2D3748;
    }

    .footer-stats { display: flex; gap: 45px; }
    .stat-label { font-size: 10px; color: #A0AEC0; text-transform: uppercase; display: block; }
    .stat-value { font-family: 'JetBrains Mono'; font-size: 18px; color: #E2E8F0; }
    .stat-total { color: #48BB78; font-size: 24px; font-weight: 600; }

    .btn-save {
        background: #48BB78; color: #fff; padding: 12px 35px; border: none; 
        border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;
    }
    .btn-save:hover { background: #38A169; transform: translateY(-1px); }

    .btn-add {
        background: #fff; border: 1px dashed #CBD5E0; color: #718096;
        padding: 8px 20px; border-radius: 6px; cursor: pointer; margin-top: 15px;
    }
</style>

<div class="inv-page">
    
    <h2 style="margin-bottom: 25px; color: #1A202C;">Create New Invoice</h2>

    <form method="POST" action="{{ route('invoices.store') }}">
        @csrf

        {{-- 1. Job Information Section --}}
        <div class="section-card">
            <div class="section-title">🔍 Job Information</div>
            <div style="display: flex; gap: 25px; align-items: flex-start; flex-wrap: wrap;">
                <div style="width: 250px;">
                    <label style="font-size: 11px; font-weight: 600; color: #A1A1AA; display: block; margin-bottom: 5px;">JOB CARD NO</label>
                    <input type="text" id="job_no" class="td-input" style="background: #fff;" placeholder="JC-12345">
                    <input type="hidden" name="job_card_id" id="job_card_id">
                </div>
                <div id="job_info_box" style="flex: 1;">
                    {{-- Unique Info Card will appear here --}}
                </div>
            </div>
        </div>

        {{-- 2. Spare Parts --}}
        <div class="section-card">
            <div class="section-title">⚙️ Spare Parts & Materials</div>
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Item Description</th>
                        <th style="width: 100px;">Qty</th>
                        <th style="width: 150px;">Buy Price</th>
                        <th style="width: 150px;">Sell Price</th>
                        <th style="width: 180px;">Total</th>
                    </tr>
                </thead>
                <tbody id="parts_body"></tbody>
            </table>
            <button type="button" class="btn-add" onclick="addRow('parts')">+ Add Item</button>
        </div>

        {{-- 3. Sub Works --}}
        <div class="section-card">
            <div class="section-title">🛠️ Sub Works / External Services</div>
            <table class="inv-table">
                <tbody id="works_body"></tbody>
            </table>
            <button type="button" class="btn-add" onclick="addRow('works')">+ Add Sub Work</button>
        </div>

        {{-- 4. Service Charges --}}
        <div class="section-card">
            <div class="section-title">👨‍🔧 Service & Labor Charges</div>
            <table class="inv-table">
                <tbody id="services_body"></tbody>
            </table>
            <button type="button" class="btn-add" onclick="addRow('services')">+ Add Service Charge</button>
        </div>

        {{-- ── Sticky Footer ── --}}
        <div class="inv-footer-bar">
            <div class="footer-stats">
                <div><span class="stat-label">Subtotal</span><span class="stat-value" id="grand_total">0.00</span></div>
                <div><span class="stat-label">VAT (10%)</span><span class="stat-value" id="vat">0.00</span></div>
                <div><span class="stat-label">Grand Total</span><span class="stat-total" id="bill_amount">0.00</span></div>
                <div style="background: #2D3748; padding: 5px 15px; border-radius: 6px;">
                    <span class="stat-label" style="color: #63B3ED;">Est. Profit</span>
                    <span class="stat-value" id="total_profit" style="color: #63B3ED;">0.00</span>
                </div>
            </div>
            <button type="submit" class="btn-save">Save Invoice</button>
        </div>
    </form>
</div>

<script>
let index = 1;

// মূল লজিক (আপনার দেওয়া কোড)
function addRow(type) {
    let id = Date.now();
    let row = `
    <tr>
        <td style="color:#94A3B8; font-size:12px;">${index++}</td>
        <td><input name="${type}[${id}][name]" class="td-input" required></td>
        <td><input type="number" name="${type}[${id}][qty]" class="td-input qty" value="1" step="any"></td>
        <td><input type="number" name="${type}[${id}][buy_price]" class="td-input buy" placeholder="0" step="any"></td>
        <td><input type="number" name="${type}[${id}][sell_price]" class="td-input sell" placeholder="0" step="any"></td>
        <td><input class="td-input total td-readonly" readonly value="0.00"></td>
        <input type="hidden" class="profit">
    </tr>`;
    document.getElementById(type + '_body').insertAdjacentHTML('beforeend', row);
}

document.addEventListener('input', function(e) {
    let row = e.target.closest('tr');
    if (!row) return;

    let q = Math.max(0, parseFloat(row.querySelector('.qty')?.value) || 0);
    let b = Math.max(0, parseFloat(row.querySelector('.buy')?.value) || 0);
    let s = Math.max(0, parseFloat(row.querySelector('.sell')?.value) || 0);

    let total = q * s;
    let profit = (s - b) * q;

    row.querySelector('.total').value = total.toFixed(2);
    row.querySelector('.profit').value = profit.toFixed(2);
    calculate();
});

function calculate() {
    let total = 0, profit = 0;
    document.querySelectorAll('.total').forEach(e => total += Number(e.value || 0));
    document.querySelectorAll('.profit').forEach(e => profit += Number(e.value || 0));
    let vat = total * 0.10;

    document.getElementById('grand_total').innerText = total.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('vat').innerText = vat.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('bill_amount').innerText = (total + vat).toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('total_profit').innerText = profit.toLocaleString(undefined, {minimumFractionDigits: 2});
}

// আপনার ছবির আইডিয়া অনুযায়ী Job Info Box Design
document.getElementById('job_no').addEventListener('blur', function() {
    let jobNo = this.value;
    let box = document.getElementById('job_info_box');
    if (!jobNo) return;

    fetch(`{{ route('invoices.find') }}?job_no=${jobNo}`)
    .then(res => res.json())
    .then(data => {
        if (!data || !data.id) {
            box.innerHTML = `<span style="color:#E53E3E;">❌ Job card not found</span>`;
            return;
        }
        document.getElementById('job_card_id').value = data.id;
        
       box.innerHTML = `
<div style="
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 20px;
    background: #ffffff;
    border: 1px solid #E2E8F0;
    border-left: 5px solid #10B981;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-top: 15px;
    align-items: start;
">
    <div style="border-right: 1px solid #F1F5F9; padding-right: 15px;">
        <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 8px;">👤 Customer Profile</div>
        <div style="font-size: 16px; font-weight: 700; color: #1E293B; margin-bottom: 10px;">${data.receive.customer.customer_name}</div>
        
        <div style="font-size: 13px; color: #475569; line-height: 1.6;">
            <strong>📞 Contact:</strong><br>
            ${data.receive.customer.owner_phone ? 'Owner: ' + data.receive.customer.owner_phone + '<br>' : ''}
            ${data.receive.customer.transport_phone ? 'Transport: ' + data.receive.customer.transport_phone + '<br>' : ''}
            ${data.receive.customer.driver_phone ? 'Driver: ' + data.receive.customer.driver_phone + '<br>' : ''}
            ${data.receive.customer.office_phone ? 'Office: ' + data.receive.customer.office_phone + '<br>' : ''}
        </div>
    </div>

    <div style="border-right: 1px solid #F1F5F9; padding-right: 15px; padding-left: 5px;">
        <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 8px;">🚗 Vehicle Specs</div>
        
        <div style="margin-bottom: 12px;">
            <span style="background: #ECFDF5; color: #059669; font-family: 'JetBrains Mono', monospace; font-weight: 600; padding: 4px 10px; border-radius: 6px; border: 1px solid #DCFCE7; font-size: 14px;">
                ${data.receive.car.registration_no}
            </span>
        </div>

        <div style="font-size: 13px; color: #475569;">
            <div style="margin-bottom: 4px;"><strong>🔑 VIN:</strong> ${data.receive.car.vin ?? 'N/A'}</div>
            <div><strong>🏷️ Brand:</strong> ${data.receive.car.brand?.name ?? 'N/A'}</div>
        </div>
    </div>

    <div style="padding-left: 5px;">
        <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 8px;">📌 Assignment</div>
        
        <div style="font-size: 13px; color: #475569;">
            <div style="margin-bottom: 4px;"><strong>Model:</strong> ${data.receive.car.model?.name ?? 'N/A'}</div>
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #E2E8F0;">
                <span style="color: #94A3B8; font-size: 11px;">Status:</span><br>
                <span style="color: #10B981; font-weight: 600;">● Active Job Card</span>
            </div>
        </div>
    </div>
</div>
`;
    });
});

window.onload = () => addRow('parts');
</script>

@endsection