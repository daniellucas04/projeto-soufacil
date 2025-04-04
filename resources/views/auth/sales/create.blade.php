@extends('auth.dashboard')
@section('content')
@if (session('success') || session('error'))
    <div id="alert-message" class="p-3 rounded-lg m-10 text-center
        {{ session('success') ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
        {{ session('success') ?? session('error') }}
    </div>

    {{-- <script>
        setTimeout(() => {
            document.getElementById('alert-message').style.display = 'none';
        }, 3000); // Fecha após 3 segundos
    </script> --}}
@endif

<div class="w-[95%] m-10 bg-neutral-100 border border-neutral-200 p-8 rounded-lg shadow">
    <form method="post" class="flex flex-col gap-8 w-full">
        @csrf
        @method('post')
        <h3 class="text-lg text-center text-neutral-600">You are creating a new sale for the customer: <span class="text-black font-bold">{{ $customer->name }}</span></h3>

        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label>Price</label>
                <input type="text" id="price" name="price" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('name') is-invalid @enderror">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label>Installment</label>
                <select name="installment" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('name') is-invalid @enderror">
                    @for ($i = 1; $i <= $maxInstallmentQuantity; $i++)
                        <option value="{{ $i }}">{{ $i }}x</option>
                    @endfor
                </select>
                @error('installment') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div class="flex flex-col">
                <label>Due date</label>
                <input type="date" name="due_date" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('email') is-invalid @enderror">        
                @error('due_date') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="/sales" class="bg-white border border-neutral-400 text-neutral-800 py-2 px-4 rounded-lg hover:bg-neutral-100 hover:text-neutral-900 cursor-pointer transition-all">Cancel</a>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Create sale</button>
        </div>
    </form>
</div>
@endsection