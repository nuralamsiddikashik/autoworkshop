@extends('layouts.app')

@section('content')

{{-- ===== INLINE STYLES ===== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

    .cr-page {
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1.5rem;
        background: #F7F6F3;
        min-height: 100vh;
    }

    /* ── Header ── */
    .cr-header { margin-bottom: 1.75rem; }
    .cr-title { font-size: 22px; font-weight: 600; color: #18181B; letter-spacing: -0.4px; }
    .cr-subtitle { font-size: 13px; color: #71717A; margin-top: 3px; }

    /* ── Form Card ── */
    .cr-form-card {
        background: #fff;
        border: 1px solid #E4E4E7;
        border-radius: 14px;
        padding: 24px;
        max-width: 800px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .form-group { margin-bottom: 1.25rem; }
    .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #A1A1AA;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #18181B;
        background: #FAFAFA;
        border: 1px solid #E4E4E7;
        border-radius: 9px;
        outline: none;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus { border-color: #A1A1AA; background: #fff; }

    textarea.form-control-custom { min-height: 100px; resize: vertical; }

    /* ── Info Box (Dynamic) ── */
    #info_box {
        background: #F9FAFB;
        border: 1px dashed #D1D5DB;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 10px; color: #9CA3AF; text-transform: uppercase; font-weight: 600; }
    .info-value { font-size: 13px; color: #374151; font-weight: 500; margin-top: 2px; }

    /* ── Submit Button ── */
    .btn-submit {
        background: #18181B;
        color: #FAFAFA;
        border: none;
        border-radius: 9px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        transition: opacity 0.15s ease;
    }
    .btn-submit:hover { opacity: 0.9; }

    /* ── Receive No Input Special Style ── */
    .input-with-icon { position: relative; }
    .input-with-icon .loader-icon {
        position: absolute; right: 12px; top: 10px; display: none;
    }
</style>

<div class="cr-page">
    
    <div class="cr-header">
        <div class="cr-title">Create Job Card</div>
        <div class="cr-subtitle">Search receive record and document problems</div>
    </div>

    <div class="cr-form-card">
        <form action="{{ route('job-cards.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Receive No</label>
                <div class="input-with-icon">
                    <input type="text" id="receive_no" class="form-control-custom" placeholder="Type Receive No and press Enter or Tab..." autocomplete="off">
                </div>
            </div>

            <div id="info_box" style="display:none;">
                <div class="info-item">
                    <span class="info-label">Customer</span>
                    <span class="info-value" id="customer_name"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Vehicle</span>
                    <span class="info-value" id="car_name"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Registration No</span>
                    <span class="info-value" id="reg_no" style="font-family:'JetBrains Mono';"></span>
                </div>
            </div>

            <input type="hidden" name="car_receive_id" id="car_receive_id">

            <div class="form-group">
                <label>Problem Note</label>
                <textarea name="problem_note" class="form-control-custom" placeholder="What problems did the customer report?"></textarea>
            </div>

            <div class="form-group">
                <label>Work Note</label>
                <textarea name="work_note" class="form-control-custom" placeholder="Instructions for the mechanics..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Create Job Card</button>
        </form>
    </div>

</div>

<script>
document.getElementById('receive_no').addEventListener('blur', function () {
    let receiveNo = this.value;
    if(!receiveNo) return;

    // Optional: Add a simple loading state style
    this.style.opacity = '0.5';

    fetch(`/job-cards/find-receive?receive_no=${receiveNo}`)
        .then(res => res.json())
        .then(data => {
            this.style.opacity = '1';

            if (data.error) {
                alert('Receive not found');
                document.getElementById('info_box').style.display = 'none';
                return;
            }

            document.getElementById('car_receive_id').value = data.id;
            document.getElementById('customer_name').innerText = data.customer.customer_name;
            document.getElementById('car_name').innerText = 
                (data.car.brand.name || '') + ' - ' + (data.car.model.name || '');
            document.getElementById('reg_no').innerText = data.car.registration_no;

            // Show info box with a simple display change
            document.getElementById('info_box').style.display = 'grid';
        })
        .catch(err => {
            this.style.opacity = '1';
            console.error('Error fetching data');
        });
});
</script>

@endsection