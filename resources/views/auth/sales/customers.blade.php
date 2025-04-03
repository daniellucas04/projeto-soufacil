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
    <div class="flex mb-8">
        <form method="get" class="flex gap-4 w-full">
            <input type="text" name="filter" placeholder="Search sale by price, due date or status" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4">

            <button type="submit" class="bg-blue-500 text-white text-sm py-1 px-2 rounded-full hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Search sale</button>
            <a href="/sales" class="flex items-center bg-blue-500 text-white text-sm py-1 px-2 rounded-full hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">All customers</a>
        </form>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="rounded-lg">
            <tr class="text-neutral-900">
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Customer</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Price (R$)</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Due date</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Sale date</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Status</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($sales as $sale)
                <tr class="text-neutral-900 border-b-neutral-300 hover:bg-neutral-200 transition-all">
                    <td class="p-2 whitespace-nowrap">{{ ucfirst($sale->name) }}</td>
                    <td class="p-2 whitespace-nowrap">{{ number_format($sale->price, 2, ',', '.') }}</td>
                    <td class="p-2 whitespace-nowrap">{{ date_format(new DateTime($sale->due_date), 'd/m/Y') }}</td>
                    <td class="p-2 whitespace-nowrap">{{ date_format(new DateTime($sale->created_at), 'd/m/Y H:i:s') }}</td>
                    <td class="p-2 whitespace-nowrap">
                        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border {{ $sale->status == 'Pending' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                            {{ $sale->status }}
                        </span>
                    </td>
                    <td class="flex items-center gap-2 p-2 whitespace-nowrap">
                        <a href="/reciepts?filter={{ $sale->uuid }}" class="bg-emerald-500 py-1 px-2 rounded hover:bg-emerald-600 hover:text-neutral-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-8">
        {{ $sales->links() }}
    </div>
</div>
@endsection