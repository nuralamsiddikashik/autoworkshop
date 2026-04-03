@extends('layouts.app')

@section('content')

{{-- ===== CUSTOM STYLES ===== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap');

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
        margin-bottom: 24px;
    }

    .page-title { font-size: 24px; font-weight: 600; color: #1E293B; }

    /* ── Table Container ── */
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

    /* ── Badges & Text Styles ── */
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

    /* ── Action Buttons ── */
    .btn-view {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-view:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #1E293B;
    }

    .btn-create {
        background: #10B981;
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: 0.2s;
    }

    .btn-create:hover { background: #059669; transform: translateY(-1px); }

    /* Pagination Styling Override */
    .pagination-wrapper { margin-top: 20px; }
</style>

<div class="list-page">
    
    <div class="page-header">
        <h3 class="page-title">Invoice Management</h3>
        <a href="{{ route('invoices.create') }}" class="btn-create">+ Create New Invoice</a>
    </div>

    <div class="table-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="150">Job No</th>
                    <th>Customer Name</th>
                    <th>Vehicle Details</th>
                    <th width="150">Total Amount</th>
                    <th width="100" style="text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td style="color: #94A3B8; font-weight: 500;">{{ $loop->iteration }}</td>
                        
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
                            <a href="{{ route('invoices.show', $inv->id) }}" class="btn-view">
                                👁 View
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('invoices.edit', $inv->id) }}" class="btn-edit">
                                ✏ Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94A3B8;">
                            No invoices found in the system.
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