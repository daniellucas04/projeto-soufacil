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
    <form method="post" class="flex flex-col gap-8 w-full">
        @csrf
        @method('put')
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label>Name</label>
                <input type="text" name="name" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('name') is-invalid @enderror" value="{{ $customer->name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label>CPF/CNPJ</label>
                <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('cpf_cnpj') is-invalid @enderror" value="{{ $customer->cpf_cnpj }}">        
                @error('cpf_cnpj') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label>Phone</label>
                <input type="text" id="phone" name="phone" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('phone') is-invalid @enderror" value="{{ $customer->phone }}">            
                @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label>E-mail</label>
                <input type="email" name="email" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('email') is-invalid @enderror" value="{{ $customer->email }}">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div class="flex justify-end gap-4">
            <a href="/customers" class="bg-white border border-neutral-400 text-neutral-800 py-2 px-4 rounded-lg hover:bg-neutral-100 hover:text-neutral-900 cursor-pointer transition-all">Cancel</a>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Update customer</button>
        </div>
    </form>
</div>
@endsection