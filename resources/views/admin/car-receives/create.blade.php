@extends('layouts.app')

@section('content')
<style>
    .receive-page {
        max-width: 860px;
        margin: 2.5rem auto;
        padding: 0 1.25rem;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Header ── */
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
    }

    .page-header-icon {
        width: 42px;
        height: 42px;
        background: #1a1a2e;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .page-header-icon svg {
        width: 21px;
        height: 21px;
        stroke: #e8c96a;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.8rem;
        color: #8b8fa8;
        margin: 0;
        margin-top: 1px;
    }

    /* ── Form card ── */
    .form-card {
        background: #fff;
        border: 1px solid #ebebf0;
        border-radius: 16px;
        overflow: hidden;
    }

    /* ── Section header inside card ── */
    .section-head {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f2f2f6;
        background: #f8f8fc;
    }

    .section-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-icon.customer { background: #ede9fe; }
    .section-icon.car      { background: #fef3c7; }
    .section-icon.details  { background: #e0f2fe; }

    .section-icon svg {
        width: 15px;
        height: 15px;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .section-icon.customer svg { stroke: #7c3aed; }
    .section-icon.car      svg { stroke: #d97706; }
    .section-icon.details  svg { stroke: #0284c7; }

    .section-title {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #3a3d5c;
    }

    /* ── Field grid ── */
    .field-grid {
        display: grid;
        gap: 1.25rem;
        padding: 1.5rem;
        border-bottom: 1px solid #f2f2f6;
    }

    .fg-3 { grid-template-columns: repeat(3, 1fr); }
    .fg-4 { grid-template-columns: repeat(4, 1fr); }
    .fg-1-3 { grid-template-columns: 1fr 3fr; }

    .field-group { display: flex; flex-direction: column; gap: 6px; }

    .field-label {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #8b8fa8;
    }

    .field-control {
        height: 40px;
        border: 1px solid #dde0f0;
        border-radius: 9px;
        padding: 0 13px;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        color: #1a1a2e;
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    .field-control:focus {
        border-color: #1a1a2e;
        box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.07);
    }

    .field-control:read-only {
        background: #f8f8fc;
        color: #6b6f8c;
        cursor: default;
    }

    .field-control:read-only:focus {
        border-color: #dde0f0;
        box-shadow: none;
    }

    select.field-control {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 34px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 11 11'%3E%3Cpath fill='%238b8fa8' d='M5.5 7.5L1 3h9z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        cursor: pointer;
    }

    select.field-control:focus {
        border-color: #1a1a2e;
        box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.07);
    }

    /* readonly pill badge */
    .readonly-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f0f0f8;
        color: #8b8fa8;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 2px 7px;
        border-radius: 50px;
        margin-left: 6px;
        vertical-align: middle;
    }

    /* ── Footer / Submit ── */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
    }

    .footer-hint {
        font-size: 0.78rem;
        color: #b0b3c6;
    }

    .footer-hint span {
        color: #e94b4b;
        margin-right: 3px;
    }

    .btn-submit {
        height: 44px;
        padding: 0 30px;
        background: #1a1a2e;
        color: #e8c96a;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-submit svg {
        width: 16px;
        height: 16px;
        stroke: #e8c96a;
        fill: none;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .btn-submit:hover  { background: #2a2a4e; }
    .btn-submit:active { transform: scale(0.97); }

    /* ── Textarea ── */
    textarea.field-control {
        height: auto;
        min-height: 40px;
        resize: none;
        padding-top: 10px;
        padding-bottom: 10px;
        line-height: 1.5;
    }

    @media (max-width: 720px) {
        .fg-3, .fg-4, .fg-1-3 { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 480px) {
        .fg-3, .fg-4, .fg-1-3 { grid-template-columns: 1fr; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<div class="receive-page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div class="page-header-icon">
            <svg viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="12" y1="18" x2="12" y2="12"/>
                <line x1="9" y1="15" x2="15" y2="15"/>
            </svg>
        </div>
        <div>
            <h1 class="page-title">Car Receive</h1>
            <p class="page-subtitle">Register an incoming vehicle for service</p>
        </div>
    </div>

    {{-- ── Form ── --}}
    <form action="{{ route('car-receives.store') }}" method="POST">
        @csrf
        <div class="form-card">

            {{-- ===== CUSTOMER ===== --}}
            <div class="section-head">
                <div class="section-icon customer">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <span class="section-title">Customer Info</span>
            </div>

            <div class="field-grid fg-3">
                <div class="field-group">
                    <label class="field-label">Customer</label>
                    <select name="customer_id" id="customer_id" class="field-control" required>
                        <option value="">Select customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->customer_name }} ({{ $customer->owner_phone }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">
                        Phone
                        <span class="readonly-tag">auto</span>
                    </label>
                    <input name="owner_phone" type="text" id="owner_phone" class="field-control" readonly placeholder="Auto-filled">
                </div>

                <div class="field-group">
                    <label class="field-label">
                        Address
                        <span class="readonly-tag">auto</span>
                    </label>
                    <input type="text" id="address" class="field-control" readonly placeholder="Auto-filled">
                </div>
            </div>

            {{-- ===== CAR ===== --}}
            <div class="section-head">
                <div class="section-icon car">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <span class="section-title">Vehicle Details</span>
            </div>

            <div class="field-grid fg-4">
                <div class="field-group">
                    <label class="field-label">Brand</label>
                    <select name="car_brand_id" id="car_brand_id" class="field-control" required>
                        <option value="">Select brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">Model</label>
                    <select name="car_model_id" id="car_model_id" class="field-control" required>
                        <option value="">Select model</option>
                        @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">VIN</label>
                    <input type="text" name="vin" id="vin" class="field-control" placeholder="e.g. 1HGBH41JXMN109186">
                </div>

                <div class="field-group">
                    <label class="field-label">Registration No</label>
                    <input type="text" name="registration_no" id="registration_no" class="field-control" placeholder="e.g. DHA-1234">
                </div>
            </div>

            {{-- ===== ODOMETER & NOTE ===== --}}
            <div class="section-head">
                <div class="section-icon details">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="section-title">Additional Details</span>
            </div>

            <div class="field-grid fg-1-3">
                <div class="field-group">
                    <label class="field-label">Odometer (km)</label>
                    <input type="number" name="odometer" id="odometer" class="field-control" placeholder="e.g. 45000" min="0">
                </div>

                <div class="field-group">
                    <label class="field-label">Note</label>
                    <input type="text" name="note" class="field-control" placeholder="Any remarks about the vehicle condition...">
                </div>
            </div>

            {{-- ===== FOOTER ===== --}}
            <div class="form-footer">
                <p class="footer-hint"><span>*</span> Required fields must be filled before submitting.</p>
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Submit
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const customerEl = document.getElementById('customer_id');
    const regEl      = document.getElementById('registration_no');

    regEl.addEventListener('keyup', function () {

        let reg        = this.value.trim();
        let customerId = customerEl.value;

        if (!customerId) {
            console.warn('Customer select koro age');
            return;
        }

        if (reg.length < 3) return;

        axios.get('/car-receives/find-by-registration', {
            params: {
                customer_id: customerId,
                registration_no: reg
            }
        })
        .then(res => {

            console.log('DATA:', res.data);

            // ❌ data না থাকলে stop
            if (!res.data) return;

            let data = res.data;

            // 🔥 VIN
            document.getElementById('vin').value = data.vin ?? '';

            // 🔥 ODOMETER
            document.getElementById('odometer').value = data.odometer ?? '';

            // 🔥 BRAND SELECT
            let brandEl = document.getElementById('car_brand_id');
            brandEl.value = data.car_brand_id;

            // 🔥 MODEL SELECT
            let modelEl = document.getElementById('car_model_id');
            modelEl.value = data.car_model_id;

        })
        .catch(err => {
            console.error('ERROR:', err);
        });

    });

});
</script>