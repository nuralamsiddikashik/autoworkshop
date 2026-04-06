@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Money Receipts</h2>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Receipt No</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Discount</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
    @forelse($moneyReceipts as $key => $receipt)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                {{ $moneyReceipts->firstItem() + $key }}
            </td>
            <td class="px-4 py-3 font-medium text-gray-800">
                MR-{{ str_pad($receipt->id, 5, '0', STR_PAD_LEFT) }}
            </td>

            <td class="px-4 py-3">
                {{ $receipt->customer->customer_name ?? 'N/A' }}
            </td>

            <td class="px-4 py-3">
                {{ $receipt->total_discount ?? 'N/A' }}
            </td>

            <td class="px-4 py-3 text-green-600 font-semibold">
                ৳ {{ number_format($receipt->total_paid, 2) }}
            </td>

            <td class="px-4 py-3">
                {{ \Carbon\Carbon::parse($receipt->payment_date)->format('d M Y') }}
            </td>

            <td class="px-4 py-3 text-right">
                <a href="{{ route('money.receipts.show', $receipt->id) }}" class="text-blue-500 hover:underline">
                    View
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center py-6 text-gray-500">
                No receipts found
            </td>
        </tr>
    @endforelse
</tbody>
        </table>

        <div class="p-4">
            {{ $moneyReceipts->links() }}
        </div>

    </div>
</div>
@endsection