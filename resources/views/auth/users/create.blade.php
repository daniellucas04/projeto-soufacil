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
        @method('post')
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label>Name</label>
                <input type="text" name="name" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('name') is-invalid @enderror" required>
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label>E-mail</label>
                <input type="email" name="email" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('email') is-invalid @enderror" required>        
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label>Password</label>
                <input type="password" name="password" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('password') is-invalid @enderror" required>            
                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" class="flex-auto border border-neutral-400 bg-white rounded-md py-2 px-4 @error('password_confirmation') is-invalid @enderror" required>
                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="role" name="role" class="border bodrder-neutral-400 @error('role') is-invalid @enderror">            
                <label for="role">Admin <small class="text-neutral-500">(Check this box if the user will have Admin privileges)</small></label>
                @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div class="flex justify-end gap-4">
            <a href="/users" class="bg-white border border-neutral-400 text-neutral-800 py-2 px-4 rounded-lg hover:bg-neutral-100 hover:text-neutral-900 cursor-pointer transition-all">Cancel</a>
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Create user</button>
        </div>
    </form>
</div>
@endsection