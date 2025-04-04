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
            <input type="text" name="filter" placeholder="Search sale by name, CPF/CNPJ, phone or e-mail" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4">

            <button type="submit" class="bg-blue-500 text-white text-sm py-2 px-4 rounded-full hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Search customers</button>
            <a href="/sales" class="flex items-center bg-blue-500 text-white text-sm py-1 px-2 rounded-full hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">All sales</a>
        </form>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="rounded-lg">
            <tr class="text-neutral-900">
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Name</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">CPF/CNPJ</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Phone</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">E-mail</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                    <span class="sr-only">Start a new sale</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($customers as $customer)
                <tr class="text-neutral-900 border-b-neutral-300 hover:bg-neutral-200 transition-all">
                    <td class="p-2 whitespace-nowrap">{{ ucfirst($customer->name) }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $customer->cpf_cnpj }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $customer->phone }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $customer->email }}</td>
                    <td class="flex items-center gap-2 p-2 whitespace-nowrap">
                        <a href="/sales/{{ $customer->uuid }}/create" class="bg-emerald-400 p-1 text-black shadow-sm rounded-full hover:bg-emerald-500 hover:text-neutral-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>                              
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-8">
        {{ $customers->links() }}
    </div>
</div>
@endsection
