@php
    use \App\Enums\ReceiptStatus;
@endphp

@extends('auth.dashboard')
@section('content')

@if (session('success') || session('error'))
    <div id="alert-message" class="p-3 rounded-lg m-10 text-center
        {{ session('success') ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
        {{ session('success') ?? session('error') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('alert-message').style.display = 'none';
        }, 3000); // Fecha após 3 segundos
    </script>
@endif

<div class="w-[95%] m-10 bg-neutral-100 border border-neutral-200 p-8 rounded-lg shadow">
    <div class="flex justify-between mb-8">
        <form method="get" class="flex gap-4 w-full">
            <input type="text" name="filter" placeholder="Search receipt by customer name (or document), payment date or sale date" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4">

            <button type="submit" class="bg-blue-500 text-white text-sm py-1 px-2 rounded-full hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Search receipt</button>
        </form>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="rounded-lg">
            <tr class="text-neutral-900">
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Customer</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Price</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Payment Date</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Sale Date</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Status</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Receipt Code</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Sale Code</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                    <span class="sr-only">Mark as paid</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($receipts as $receipt)
                @php $receipt->status = ReceiptStatus::tryFrom($receipt->status) ?? ReceiptStatus::PENDING; @endphp
                <tr class="text-neutral-900 border-b-neutral-300 hover:bg-neutral-200 transition-all">
                    <td class="p-2 whitespace-nowrap">{{ ucfirst($receipt->customer_name) }}</td>
                    <td class="p-2 whitespace-nowrap">{{ number_format($receipt->receipt_price, 2, ',', '.') }}</td>
                    <td class="p-2 whitespace-nowrap">{{ date_format(new DateTime($receipt->payment_date), 'd/m/Y') }}</td>
                    <td class="p-2 whitespace-nowrap">{{ date_format(new DateTime($receipt->sale_date), 'd/m/Y') }}</td>
                    <td class="p-2 whitespace-nowrap">
                        <span class="{{ $receipt->status->getBadge() }}}}">
                            {{ $receipt->status->value }}
                        </span>
                    </td>
                    <td class="p-2 whitespace-nowrap">{{ $receipt->receipt_code }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $receipt->sale_code }}</td>
                    <td class="flex gap-2 p-2 whitespace-nowrap">
                        @if ($receipt->status->value === 'Pending')
                            <form method="post" class="flex" action="/receipts/{{ $receipt->receipt_code }}/receive">
                                @csrf
                                @method('put')
                                <button class="bg-emerald-400 text-black p-2 rounded-lg hover:bg-emerald-600 hover:text-neutral-100 transition-all cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-8">
        {{ $receipts->links() }}
    </div>
</div>
@endsection