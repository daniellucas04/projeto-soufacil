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
        <form method="get" class="flex gap-4">
            <input type="text" name="filter" placeholder="Filter by name or e-mail" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4">

            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Filter</button>
        </form>

        <a href="/users/create" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Crate user</a>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="rounded-lg">
            <tr class="text-neutral-900">
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Name</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">E-mail</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($users as $user)
                <tr class="text-neutral-900 border-b-neutral-300 hover:bg-neutral-200 transition-all">
                    <td class="p-2 whitespace-nowrap">{{ ucfirst($user->name) }}</td>
                    <td class="p-2 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="flex gap-2 p-2 whitespace-nowrap">
                        <a href="/users/{{ $user->uuid }}/edit" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 hover:text-neutral-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <form method="post" class="flex" action="/users/{{ $user->uuid }}/destroy">
                            @csrf
                            @method('delete')
                            <button class="bg-red-400 text-white p-2 rounded-lg hover:bg-red-600 hover:text-neutral-100 transition-all cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>                              
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>
@endsection