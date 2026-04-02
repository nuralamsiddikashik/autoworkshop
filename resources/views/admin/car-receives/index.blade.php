@extends('layouts.app')

@section('content')

{{-- ===== INLINE STYLES ===== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

    .cr-page * { box-sizing: border-box; }

    .cr-page {
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1.5rem;
        background: #F7F6F3;
        min-height: 100vh;
    }

    /* ── Header ── */
    .cr-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.75rem;
    }
    .cr-title {
        font-size: 22px;
        font-weight: 600;
        color: #18181B;
        letter-spacing: -0.4px;
        line-height: 1.2;
    }
    .cr-subtitle {
        font-size: 13px;
        color: #71717A;
        margin-top: 3px;
    }

    /* ── Table Card ── */
    .cr-table-card {
        background: #fff;
        border: 1px solid #E4E4E7;
        border-radius: 14px;
        overflow: hidden;
    }
    .cr-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        border-bottom: 1px solid #F4F4F5;
    }
    .cr-record-count {
        font-size: 13px;
        color: #71717A;
    }
    .cr-record-count strong {
        color: #18181B;
        font-weight: 600;
    }

    .cr-table-wrap { overflow-x: auto; }

    .cr-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .cr-table thead tr {
        background: #FAFAFA;
        border-bottom: 1px solid #F4F4F5;
    }
    .cr-table thead th {
        padding: 11px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.55px;
        color: #A1A1AA;
        white-space: nowrap;
    }
    .cr-table tbody tr {
        border-bottom: 1px solid #F4F4F5;
        transition: background 0.1s ease;
    }
    .cr-table tbody tr:hover { background: #FAFAFA; }
    .cr-table tbody td {
        padding: 14px 18px;
        color: #18181B;
        vertical-align: middle;
    }

    /* Badge & Avatar Styles */
    .receive-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11.5px;
        font-weight: 500;
        background: #F4F4F5;
        color: #3F3F46;
        padding: 4px 9px;
        border-radius: 6px;
        border: 1px solid #E4E4E7;
        white-space: nowrap;
    }

    .customer-cell { display: flex; align-items: center; gap: 10px; }
    .cust-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .av-a { background: #DBEAFE; color: #1E40AF; }
    .av-b { background: #DCFCE7; color: #166534; }
    .av-c { background: #EDE9FE; color: #5B21B6; }
    .av-d { background: #FFE4E6; color: #9F1239; }
    .av-e { background: #FEF3C7; color: #92400E; }
    
    .cust-name { font-weight: 600; color: #18181B; }
    
    .contact-grid {
        display: flex;
        flex-direction: column;
        gap: 3px;
        font-size: 11.5px;
    }
    .contact-item { display: flex; align-items: center; gap: 6px; color: #52525B; }
    .contact-icon { font-size: 12px; filter: grayscale(1); opacity: 0.8; }

    .brand-pill {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }
    .brand-toyota   { background: #DBEAFE; color: #1D4ED8; }
    .brand-honda    { background: #FEF3C7; color: #92400E; }
    .brand-nissan   { background: #DCFCE7; color: #166534; }
    .brand-bmw      { background: #EDE9FE; color: #5B21B6; }
    .brand-default  { background: #F4F4F5; color: #52525B; }

    .vin-text { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #A1A1AA; }
    .odo-text { font-variant-numeric: tabular-nums; font-weight: 500; }
    .date-text { color: #71717A; font-size: 12.5px; white-space: nowrap; }
    .text-muted-cell { color: #D4D4D8; }

    /* Pagination */
    .cr-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        border-top: 1px solid #F4F4F5;
        font-size: 12.5px;
        color: #71717A;
    }
</style>

<div class="cr-page">

    <!-- Header -->
    <div class="cr-header">
        <div>
            <div class="cr-title">Car Receive List</div>
            <div class="cr-subtitle">Detailed vehicle entry records and owner information</div>
        </div>
    </div>

    <!-- Table -->
    <div class="cr-table-card">

        <div class="cr-table-header">
            <div class="cr-record-count">
                Showing <strong>{{ $receives->count() }}</strong> of <strong>{{ $receives->total() }}</strong> records
            </div>
        </div>

        <div class="cr-table-wrap">
            <table class="cr-table">
                <thead>
                    <tr>
                        <th>Receive No</th>
                        <th>Customer</th>
                        <th>Contact Details</th>
                        <th>Brand & Model</th>
                        <th>Registration</th>
                        <th>VIN</th>
                        <th>Odometer</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($receives as $item)

                        @php
                            $avatarClasses = ['av-a','av-b','av-c','av-d','av-e'];
                            $avatarClass   = $avatarClasses[$loop->index % count($avatarClasses)];

                            $name = optional($item->customer)->customer_name ?? 'N/A';

                            $initials = collect(explode(' ', $name))
                                ->take(2)
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->implode('');

                            if (!$initials) $initials = '--';

                            $brandName = strtolower(optional($item->car->brand)->name ?? '');

                            $brandClass = match(true) {
                                str_contains($brandName, 'toyota') => 'brand-toyota',
                                str_contains($brandName, 'honda')  => 'brand-honda',
                                str_contains($brandName, 'nissan') => 'brand-nissan',
                                str_contains($brandName, 'bmw')    => 'brand-bmw',
                                default                           => 'brand-default',
                            };
                        @endphp

                        <tr>

                            <!-- Receive No -->
                            <td>
                                <span class="receive-badge">
                                    {{ $item->receive_no }}
                                </span>
                            </td>

                            <!-- Customer -->
                            <td>
                                <div class="customer-cell">
                                    <div class="cust-avatar {{ $avatarClass }}">
                                        {{ $initials }}
                                    </div>
                                    <span class="cust-name">{{ $name }}</span>
                                </div>
                            </td>

                            <!-- Contact -->
                            <td>
                                @php
                                    $phones = [
                                        'Owner'    => $item->customer->owner_phone ?? null,
                                        'Transport'=> $item->customer->transport_phone ?? null,
                                        'Driver'   => $item->customer->driver_phone ?? null,
                                        'Office'   => $item->customer->office_phone ?? null,
                                    ];

                                    // remove empty values
                                    $phones = array_filter($phones);
                                    $count  = count($phones);
                                @endphp

                                <div class="contact-grid">

                                    {{-- ✅ If only ONE number --}}
                                    @if($count === 1)
                                        <div class="contact-item">
                                            📞 {{ array_values($phones)[0] }}
                                        </div>
                                    @endif

                                    {{-- ✅ If MULTIPLE numbers --}}
                                    @if($count > 1)
                                        @foreach($phones as $label => $number)
                                            <div class="contact-item">
                                                <span class="contact-icon">📞</span>
                                                <strong>{{ $label }}:</strong> {{ $number }}
                                            </div>
                                        @endforeach
                                    @endif

                                    {{-- ❌ No number --}}
                                    @if($count === 0)
                                        <span class="text-muted-cell">—</span>
                                    @endif

                                </div>
                            </td>
                            <!-- Brand & Model -->
                            <td>
                                <span class="brand-pill {{ $brandClass }}">
                                    {{ optional($item->car->brand)->name ?? '—' }}
                                </span>

                                <div style="font-size: 11px; color: #71717A; margin-top: 3px;">
                                    {{ optional($item->car->model)->name ?? '—' }}
                                </div>
                            </td>

                            <!-- Registration -->
                            <td>
                                {{ optional($item->car)->registration_no ?? '—' }}
                            </td>

                            <!-- VIN -->
                            <td>
                                <span class="vin-text">
                                    {{ optional($item->car)->vin ?? '—' }}
                                </span>
                            </td>

                            <!-- Odometer -->
                            <td>
                                @if(optional($item->car)->odometer)
                                    <span class="odo-text">
                                        {{ number_format($item->car->odometer) }} km
                                    </span>
                                @else
                                    <span class="text-muted-cell">—</span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td>
                                <span class="date-text">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </span>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 50px;">
                                No car receive records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($receives->hasPages())
            <div class="cr-pagination">
                <span>
                    Showing {{ $receives->firstItem() }} to {{ $receives->lastItem() }} 
                    of {{ $receives->total() }}
                </span>

                {{ $receives->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>

@endsection