@extends('layouts.app')

@section('content')
<style>
    .brands-page {
        max-width: 900px;
        margin: 2.5rem auto;
        padding: 0 1.25rem;
        font-family: 'DM Sans', sans-serif;
    }

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
    }

    .page-header-icon svg {
        width: 22px;
        height: 22px;
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
        font-weight: 400;
    }

    /* Create Card */
    .create-card {
        background: #1a1a2e;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .create-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(232, 201, 106, 0.08);
        pointer-events: none;
    }

    .create-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: 60px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(232, 201, 106, 0.05);
        pointer-events: none;
    }

    .create-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #e8c96a;
        margin-bottom: 1rem;
    }

    .create-form-row {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .create-input {
        flex: 1;
        height: 42px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 9px;
        background: rgba(255,255,255,0.06);
        color: #fff;
        padding: 0 14px;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
    }

    .create-input::placeholder {
        color: rgba(255,255,255,0.3);
    }

    .create-input:focus {
        border-color: rgba(232, 201, 106, 0.5);
        background: rgba(255,255,255,0.09);
    }

    .create-select {
        height: 42px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 9px;
        background: rgba(255,255,255,0.06);
        color: #fff;
        padding: 0 14px;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        padding-right: 32px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(255,255,255,0.4)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        min-width: 130px;
        transition: border-color 0.2s;
    }

    .create-select option {
        background: #2a2a4a;
        color: #fff;
    }

    .create-select:focus {
        border-color: rgba(232, 201, 106, 0.5);
    }

    .btn-create {
        height: 42px;
        padding: 0 22px;
        background: #e8c96a;
        color: #1a1a2e;
        border: none;
        border-radius: 9px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        white-space: nowrap;
        letter-spacing: -0.01em;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-create:hover {
        background: #f0d678;
    }

    .btn-create:active {
        transform: scale(0.97);
    }

    /* Stats row */
    .stats-row {
        display: flex;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #ebebf0;
        border-radius: 50px;
        padding: 7px 16px 7px 10px;
        font-size: 0.8rem;
        color: #5a5e78;
    }

    .stat-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stat-dot.active { background: #22c55e; }
    .stat-dot.inactive { background: #e94b4b; }
    .stat-dot.total { background: #1a1a2e; }

    .stat-num {
        font-weight: 700;
        color: #1a1a2e;
    }

    /* Table Card */
    .table-card {
        background: #fff;
        border: 1px solid #ebebf0;
        border-radius: 16px;
        overflow: hidden;
    }

    .brands-table {
        width: 100%;
        border-collapse: collapse;
    }

    .brands-table thead tr {
        background: #f8f8fc;
        border-bottom: 1px solid #ebebf0;
    }

    .brands-table th {
        padding: 11px 18px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #8b8fa8;
        text-align: left;
    }

    .brands-table td {
        padding: 13px 18px;
        font-size: 0.875rem;
        color: #2c2f47;
        vertical-align: middle;
        border-bottom: 1px solid #f2f2f6;
    }

    .brands-table tbody tr:last-child td {
        border-bottom: none;
    }

    .brands-table tbody tr {
        transition: background 0.15s;
    }

    .brands-table tbody tr:hover {
        background: #fafafe;
    }

    .row-num {
        font-size: 0.75rem;
        color: #b0b3c6;
        font-weight: 500;
    }

    .brand-name {
        font-weight: 600;
        color: #1a1a2e;
        letter-spacing: -0.01em;
    }

    .badge-active {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dcfce7;
        color: #166534;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
    }

    .badge-inactive {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fee2e2;
        color: #991b1b;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
    }

    .badge-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
    }

    .badge-active .badge-dot { background: #16a34a; }
    .badge-inactive .badge-dot { background: #dc2626; }

    /* Inline edit form */
    .action-form {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .edit-input {
        height: 34px;
        border: 1px solid #dde0f0;
        border-radius: 7px;
        padding: 0 10px;
        font-size: 0.8rem;
        font-family: 'DM Sans', sans-serif;
        color: #1a1a2e;
        background: #f8f8fc;
        outline: none;
        width: 130px;
        transition: border-color 0.15s, background 0.15s;
    }

    .edit-input:focus {
        border-color: #1a1a2e;
        background: #fff;
    }

    .edit-select {
        height: 34px;
        border: 1px solid #dde0f0;
        border-radius: 7px;
        padding: 0 26px 0 10px;
        font-size: 0.8rem;
        font-family: 'DM Sans', sans-serif;
        color: #1a1a2e;
        background: #f8f8fc;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%238b8fa8' d='M5 7L1 3h8z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
    }

    .edit-select:focus {
        border-color: #1a1a2e;
    }

    .btn-update {
        height: 34px;
        padding: 0 14px;
        background: #1a1a2e;
        color: #e8c96a;
        border: none;
        border-radius: 7px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-update:hover { background: #2a2a4e; }
    .btn-update:active { transform: scale(0.97); }

    .btn-delete {
        height: 34px;
        width: 34px;
        padding: 0;
        background: transparent;
        color: #c0c3d6;
        border: 1px solid #e8e8f0;
        border-radius: 7px;
        font-size: 0.85rem;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, color 0.15s, border-color 0.15s;
        flex-shrink: 0;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .btn-delete svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        pointer-events: none;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #b0b3c6;
        font-size: 0.875rem;
    }

    @media (max-width: 640px) {
        .create-form-row { flex-wrap: wrap; }
        .edit-input { width: 90px; }
        .stats-row { flex-wrap: wrap; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<div class="brands-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-icon">
            <svg viewBox="0 0 24 24"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/><circle cx="12" cy="16" r="1"/><circle cx="20" cy="16" r="1"/></svg>
        </div>
        <div>
            <h1 class="page-title">Car Brands</h1>
            <p class="page-subtitle">Manage your vehicle brand catalog</p>
        </div>
    </div>

    {{-- Create Form --}}
    <div class="create-card">
        <div class="create-label">Add new brand</div>
        <form action="{{ route('cars.brands.store') }}" method="POST">
            @csrf
            <div class="create-form-row">
                <input
                    type="text"
                    name="name"
                    class="create-input"
                    placeholder="e.g. Toyota, BMW, Ford..."
                    required
                >
                <select name="is_active" class="create-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <button type="submit" class="btn-create">+ Add Brand</button>
            </div>
        </form>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-pill">
            <span class="stat-dot total"></span>
            <span class="stat-num">{{ $brands->count() }}</span> total
        </div>
        <div class="stat-pill">
            <span class="stat-dot active"></span>
            <span class="stat-num">{{ $brands->where('is_active', 1)->count() }}</span> active
        </div>
        <div class="stat-pill">
            <span class="stat-dot inactive"></span>
            <span class="stat-num">{{ $brands->where('is_active', 0)->count() }}</span> inactive
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <table class="brands-table">
            <thead>
                <tr>
                    <th style="width: 48px;">#</th>
                    <th>Brand name</th>
                    <th style="width: 110px;">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $key => $brand)
                    <tr>
                        <td><span class="row-num">{{ $key + 1 }}</span></td>
                        <td><span class="brand-name">{{ $brand->name }}</span></td>
                        <td>
                            @if($brand->is_active)
                                <span class="badge-active">
                                    <span class="badge-dot"></span> Active
                                </span>
                            @else
                                <span class="badge-inactive">
                                    <span class="badge-dot"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                {{-- Update Form --}}
                                <form action="{{ route('cars.brands.update', $brand->id) }}" method="POST" class="action-form">
                                    @csrf
                                    @method('PUT')
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ $brand->name }}"
                                        class="edit-input"
                                        required
                                    >
                                    <select name="is_active" class="edit-select">
                                        <option value="1" {{ $brand->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$brand->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="btn-update">Save</button>
                                </form>

                                {{-- Delete Form --}}
                                <form action="{{ route('cars.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-delete"
                                        onclick="return confirm('Delete {{ $brand->name }}?')"
                                        title="Delete"
                                    >
                                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">No brands added yet. Create your first brand above.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection