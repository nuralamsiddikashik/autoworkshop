@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap');

    .list-page {
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1.5rem;
        background: #F8F9FA;
        min-height: 100vh;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .page-title-wrap h3 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }

    .page-title-wrap p {
        margin-top: 6px;
        font-size: 14px;
        color: #64748B;
    }

    .page-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .custom-table { width: 100%; border-collapse: collapse; }

    .custom-table th {
        background: #F8FAFC;
        text-align: left;
        padding: 14px 16px;
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E2E8F0;
    }

    .custom-table td {
        padding: 16px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        font-size: 14px;
        color: #334155;
    }

    .custom-table tr:hover { background-color: #FBFBFE; }

    .job-badge {
        font-family: 'JetBrains Mono', monospace;
        background: #F1F5F9;
        color: #475569;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .reg-no {
        color: #059669;
        font-weight: 600;
        display: block;
        margin-bottom: 2px;
    }

    .car-meta { font-size: 12px; color: #94A3B8; }

    .amount-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 600;
        color: #1E293B;
        font-size: 15px;
    }

    .btn-view,
    .btn-show,
    .btn-back,
    .btn-lock {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: #FFFFFF;
        color: #475569;
        border: 1px solid #E2E8F0;
    }

    .btn-view:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #1E293B;
    }

    .btn-show {
        width: 100%;
        background: #ECFDF5;
        color: #047857;
    }

    .btn-show:hover { background: #D1FAE5; }

    .btn-back {
        background: #2563EB;
        color: #FFFFFF;
    }

    .btn-back:hover { background: #1D4ED8; }

    .btn-lock {
        background: #FFF7ED;
        color: #C2410C;
        border: 1px solid #FED7AA;
    }

    .btn-lock:hover { background: #FFEDD5; }

    .pagination-wrapper { margin-top: 20px; }

    .alert {
        margin-bottom: 16px;
        padding: 14px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #B91C1C;
    }

    .action-form {
        margin: 0;
    }
</style>

<div class="list-page">
    <div class="page-header">
        <div class="page-title-wrap">
            <h3>Hidden Invoices</h3>
            <p>Invoices hidden from the main invoice list stay here until you show them again.</p>
        </div>

        <div class="page-actions">
            <a href="{{ route('invoices.index') }}" class="btn-back">Back to Invoice List</a>

            <form action="{{ route('invoices.hidden.lock') }}" method="POST" class="action-form">
                @csrf
                <button type="submit" class="btn-lock">Lock Hidden List</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('error'))
        <div class="alert alert-error">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="table-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="150">Job No</th>
                    <th>Customer Name</th>
                    <th>Vehicle Details</th>
                    <th width="150">Total Amount</th>
                    <th width="100" style="text-align: center;">View</th>
                    <th width="150" style="text-align: center;">Show Invoice</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td style="color: #94A3B8; font-weight: 500;">
                            {{ $invoices->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <span class="job-badge">{{ $inv->job->job_no ?? '-' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1E293B;">
                                {{ $inv->job->receive->customer->customer_name ?? 'N/A' }}
                            </div>
                            <small style="color: #94A3B8;">ID: #INV-{{ $inv->id }}</small>
                        </td>
                        <td>
                            <span class="reg-no">{{ $inv->job->receive->car->registration_no ?? '-' }}</span>
                            <span class="car-meta">
                                {{ $inv->job->receive->car->brand->name ?? '' }}
                                {{ $inv->job->receive->car->model->name ?? '' }}
                            </span>
                        </td>
                        <td>
                            <span class="amount-text">{{ number_format($inv->bill_amount, 2) }}</span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('invoices.show', $inv->id) }}" class="btn-view">View</a>
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('invoices.restore', $inv->id) }}" method="POST" class="action-form" onsubmit="return confirm('Show this invoice in the main invoice list again?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-show">Show Invoice</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94A3B8;">
                            No hidden invoices found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
