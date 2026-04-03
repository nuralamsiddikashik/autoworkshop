@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap');

    .inv-page { font-family: 'DM Sans', sans-serif; padding: 2rem 1.5rem 120px; background: #F8F9FA; }
    .section-card { background:#fff; border:1px solid #E2E8F0; border-radius:12px; padding:24px; margin-bottom:24px; }
    .section-title { font-size:13px; font-weight:600; color:#64748B; margin-bottom:20px; }
    .inv-table { width:100%; border-collapse: collapse; }
    .inv-table th { font-size:11px; color:#94A3B8; padding:12px; border-bottom:1px solid #F1F5F9; }
    .inv-table td { padding:10px; }
    .td-input { border:1px solid #E2E8F0; padding:8px; width:100%; border-radius:6px; }
    .td-readonly { background:#EDF2F7; }
    .inv-footer-bar { position:fixed; bottom:0; left:0; right:0; background:#1A202C; color:#fff; padding:15px 40px; display:flex; justify-content:space-between; }
    .btn-save { background:#48BB78; color:#fff; padding:10px 30px; border:none; border-radius:6px; }
    .btn-add { margin-top:10px; }
</style>

<div class="inv-page">

<h2>Create Invoice</h2>

<form method="POST" action="{{ route('invoices.store') }}">
@csrf

{{-- JOB --}}
<div class="section-card">
    <div class="section-title">Job</div>
    <input type="text" id="job_no" placeholder="Enter Job No">
    <input type="hidden" name="job_card_id" id="job_card_id">
    <div id="job_info_box"></div>
</div>

{{-- PARTS --}}
<div class="section-card">
    <div class="section-title">Parts</div>

    <table class="inv-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Buy</th>
            <th>Unit</th>
            <th>Unit Price</th>
            <th>Sell</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody id="parts_body"></tbody>
    </table>

    <button type="button" class="btn-add" onclick="addRow('parts')">+ Add</button>
</div>

{{-- WORKS --}}
<div class="section-card">
    <div class="section-title">Works</div>
    <table class="inv-table">
        <tbody id="works_body"></tbody>
    </table>
    <button type="button" onclick="addRow('works')">+ Add</button>
</div>

{{-- SERVICES --}}
<div class="section-card">
    <div class="section-title">Service</div>
    <table class="inv-table">
        <tbody id="services_body"></tbody>
    </table>
    <button type="button" onclick="addRow('services')">+ Add</button>
</div>

{{-- FOOTER --}}
<div class="inv-footer-bar">
    <div>
        Subtotal: <span id="grand_total">0</span> |
        VAT: <span id="vat">0</span> |
        Total: <span id="bill_amount">0</span>
    </div>
    <button type="submit" class="btn-save">Save</button>
</div>

</form>
</div>

{{-- UNITS --}}
<script>
const units = @json($units ?? []);
</script>

<script>

let index = 1;

function getUnitOptions(){
    let op = `<option value="">Unit</option>`;
    units.forEach(u=> op += `<option value="${u}">${u}</option>`);
    return op;
}

function addRow(type){

    let id = Date.now();

    let row = `
    <tr>
        <td>${index++}</td>

        <td><input name="${type}[${id}][name]" class="td-input"></td>

        <td><input type="number" name="${type}[${id}][qty]" class="td-input qty" value="1"></td>

        <td><input type="number" name="${type}[${id}][buy_price]" class="td-input buy"></td>

        <td>
            <select name="${type}[${id}][unit]" class="td-input">
                ${getUnitOptions()}
            </select>
        </td>

        <td><input type="number" name="${type}[${id}][unit_price]" class="td-input"></td>

        <td><input type="number" name="${type}[${id}][sell_price]" class="td-input sell"></td>

        <td><input class="td-input total td-readonly" readonly value="0"></td>

        <td>
            <button type="button" onclick="removeRow(this)">❌</button>
        </td>

        <input type="hidden" class="profit">
    </tr>
    `;

    document.getElementById(type+'_body').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn){
    if(confirm('Remove row?')){
        btn.closest('tr').remove();
        calculate();
    }
}

document.addEventListener('input', function(e){

    let row = e.target.closest('tr');
    if(!row) return;

    let q = Number(row.querySelector('.qty')?.value || 0);
    let b = Number(row.querySelector('.buy')?.value || 0);
    let s = Number(row.querySelector('.sell')?.value || 0);

    let total = q * s;
    let profit = (s - b) * q;

    row.querySelector('.total').value = total.toFixed(2);
    row.querySelector('.profit').value = profit.toFixed(2);

    calculate();
});

document.getElementById('job_no').addEventListener('blur', function () {

    let jobNo = this.value;
    let box = document.getElementById('job_info_box');

    if (!jobNo) return;

    fetch(`{{ route('invoices.find') }}?job_no=${jobNo}`)
        .then(res => res.json())
        .then(data => {

            // ❌ not found
            if (!data || !data.id) {
                box.innerHTML = `<span style="color:#E53E3E;">❌ Job card not found</span>`;
                return;
            }

            // ✅ hidden input set
            document.getElementById('job_card_id').value = data.id;

            // ✅ FULL INFO SHOW
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
                margin-top: 15px;
            ">

                <!-- CUSTOMER -->
                <div>
                    <strong>👤 ${data.receive.customer.customer_name}</strong><br>

                    ${data.receive.customer.owner_phone ? '📞 Owner: ' + data.receive.customer.owner_phone + '<br>' : ''}
                    ${data.receive.customer.transport_phone ? '🚚 Transport: ' + data.receive.customer.transport_phone + '<br>' : ''}
                    ${data.receive.customer.driver_phone ? '👨‍✈️ Driver: ' + data.receive.customer.driver_phone + '<br>' : ''}
                    ${data.receive.customer.office_phone ? '🏢 Office: ' + data.receive.customer.office_phone + '<br>' : ''}
                </div>

                <!-- CAR -->
                <div>
                    🚗 <strong>${data.receive.car.registration_no}</strong><br>
                    🔑 VIN: ${data.receive.car.vin ?? 'N/A'}<br>
                </div>

                <!-- BRAND MODEL -->
                <div>
                    🏷️ ${data.receive.car.brand?.name ?? 'N/A'}<br>
                    📌 ${data.receive.car.model?.name ?? 'N/A'}
                </div>

            </div>
            `;
        })
        .catch(() => {
            box.innerHTML = `<span style="color:red;">Server error</span>`;
        });
});

function calculate(){

    let total = 0;

    document.querySelectorAll('.total').forEach(e=>{
        total += Number(e.value || 0);
    });

    let vat = total * 0.10;

    document.getElementById('grand_total').innerText = total.toFixed(2);
    document.getElementById('vat').innerText = vat.toFixed(2);
    document.getElementById('bill_amount').innerText = (total + vat).toFixed(2);
}

window.onload = () => addRow('parts');

</script>

@endsection