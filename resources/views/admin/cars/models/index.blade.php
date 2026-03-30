@extends('layouts.app')

@section('content')
<style>
    .models-page {
        max-width: 1000px;
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
        right: 80px;
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
        flex-wrap: wrap;
    }

    .create-select,
    .create-input {
        height: 42px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 9px;
        background: rgba(255, 255, 255, 0.06);
        color: #fff;
        padding: 0 14px;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        appearance: none;
        -webkit-appearance: none;
    }

    .create-select {
        padding-right: 34px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 11 11'%3E%3Cpath fill='rgba(255,255,255,0.4)' d='M5.5 7.5L1 3h9z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 11px center;
        cursor: pointer;
        min-width: 150px;
    }

    .create-select option {
        background: #2a2a4a;
        color: #fff;
    }

    .create-input {
        flex: 1;
        min-width: 160px;
    }

    .create-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .create-select:focus,
    .create-input:focus {
        border-color: rgba(232, 201, 106, 0.5);
        background: rgba(255, 255, 255, 0.09);
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

    .btn-create:hover { background: #f0d678; }
    .btn-create:active { transform: scale(0.97); }

    /* Stats */
    .stats-row {
        display: flex;
        gap: 10px;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        border: 1px solid #ebebf0;
        border-radius: 50px;
        padding: 6px 14px 6px 9px;
        font-size: 0.78rem;
        color: #5a5e78;
    }

    .stat-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stat-dot.active   { background: #22c55e; }
    .stat-dot.inactive { background: #e94b4b; }
    .stat-dot.total    { background: #1a1a2e; }

    .stat-num {
        font-weight: 700;
        color: #1a1a2e;
    }

    /* Table */
    .table-card {
        background: #fff;
        border: 1px solid #ebebf0;
        border-radius: 16px;
        overflow: hidden;
    }

    .models-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .models-table thead tr {
        background: #f8f8fc;
        border-bottom: 1px solid #ebebf0;
    }

    .models-table th {
        padding: 11px 16px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #8b8fa8;
        text-align: left;
    }

    .models-table td {
        padding: 12px 16px;
        font-size: 0.85rem;
        color: #2c2f47;
        vertical-align: middle;
        border-bottom: 1px solid #f2f2f6;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .models-table tbody tr:last-child td { border-bottom: none; }
    .models-table tbody tr { transition: background 0.15s; }
    .models-table tbody tr:hover { background: #fafafe; }

    .row-num {
        font-size: 0.72rem;
        color: #b0b3c6;
        font-weight: 500;
    }

    .brand-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0f0f8;
        color: #3a3d5c;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
    }

    .model-name {
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: -0.01em;
    }

    .badge-active {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dcfce7;
        color: #166534;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
    }

    .badge-inactive {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fee2e2;
        color: #991b1b;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
    }

    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-active .badge-dot  { background: #16a34a; }
    .badge-inactive .badge-dot { background: #dc2626; }

    /* Inline edit */
    .action-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .edit-select,
    .edit-input {
        height: 32px;
        border: 1px solid #dde0f0;
        border-radius: 6px;
        font-size: 0.77rem;
        font-family: 'DM Sans', sans-serif;
        color: #1a1a2e;
        background: #f8f8fc;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
        padding: 0 9px;
    }

    .edit-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 24px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 9 9'%3E%3Cpath fill='%238b8fa8' d='M4.5 6.5L1 3h7z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 7px center;
        cursor: pointer;
        min-width: 100px;
    }

    .edit-input { width: 110px; }

    .edit-select:focus,
    .edit-input:focus {
        border-color: #1a1a2e;
        background: #fff;
    }

    .btn-save {
        height: 32px;
        padding: 0 13px;
        background: #1a1a2e;
        color: #e8c96a;
        border: none;
        border-radius: 6px;
        font-size: 0.77rem;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-save:hover  { background: #2a2a4e; }
    .btn-save:active { transform: scale(0.97); }

    .btn-delete {
        height: 32px;
        width: 32px;
        padding: 0;
        background: transparent;
        color: #c0c3d6;
        border: 1px solid #e8e8f0;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.15s, color 0.15s, border-color 0.15s;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .btn-delete svg {
        width: 13px;
        height: 13px;
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

    @media (max-width: 768px) {
        .create-form-row { flex-wrap: wrap; }
        .create-input { min-width: 100%; }
        .action-wrap { flex-wrap: wrap; }
        .models-table { table-layout: auto; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<div class="models-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-icon">
            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <div>
            <h1 class="page-title">Car Models</h1>
            <p class="page-subtitle">Manage models under each brand</p>
        </div>
    </div>

    {{-- Create Form --}}
    <div class="create-card">
        <div class="create-label">Add new model</div>
        <form action="{{ route('cars.models.store') }}" method="POST">
            @csrf
            <div class="create-form-row">
                <select name="car_brand_id" class="create-select" required>
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <input
                    type="text"
                    name="name"
                    class="create-input"
                    placeholder="Model name, e.g. Corolla, X5..."
                    required
                >
                <select name="is_active" class="create-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <button type="submit" class="btn-create">+ Add Model</button>
            </div>
        </form>
    </div>

    {{-- Stats --}}
<div class="stats-row">
    <div class="stat-pill">
        <span class="stat-dot total"></span>
        <span class="stat-num">{{ $total }}</span> total
    </div>
    <div class="stat-pill">
        <span class="stat-dot active"></span>
        <span class="stat-num">{{ $activeCount }}</span> active
    </div>
    <div class="stat-pill">
        <span class="stat-dot inactive"></span>
        <span class="stat-num">{{ $inactiveCount }}</span> inactive
    </div>
</div>

    {{-- Table --}}
    <div class="table-card">
        <table class="models-table">
            <thead>
                <tr>
                    <th style="width: 46px;">#</th>
                    <th style="width: 140px;">Brand</th>
                    <th style="width: 140px;">Model</th>
                    <th style="width: 100px;">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($models as $key => $model)
                    <tr>
                        <td><span class="row-num">{{ $key + 1 }}</span></td>
                        <td>
                            <span class="brand-chip">{{ $model->brand->name ?? '-' }}</span>
                        </td>
                        <td><span class="model-name">{{ $model->name }}</span></td>
                        <td>
                            @if($model->is_active)
                                <span class="badge-active"><span class="badge-dot"></span> Active</span>
                            @else
                                <span class="badge-inactive"><span class="badge-dot"></span> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-wrap">
                                {{-- Update --}}
                                <form action="{{ route('cars.models.update', $model->id) }}" method="POST" style="display:contents;">
                                    @csrf
                                    @method('PUT')
                                    <select name="car_brand_id" class="edit-select">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $model->car_brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="name" value="{{ $model->name }}" class="edit-input" required>
                                    <select name="is_active" class="edit-select" style="min-width: 90px;">
                                        <option value="1" {{ $model->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$model->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="btn-save">Save</button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('cars.models.destroy', $model->id) }}" method="POST" style="display:contents;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-delete"
                                        onclick="return confirm('Delete {{ $model->name }}?')"
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
                        <td colspan="5">
                            <div class="empty-state">No models added yet. Add your first model above.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection