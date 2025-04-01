<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sou Fácil</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-neutral-100 h-screen">
        <section class="h-full grid grid-cols-1 place-items-center">
            <form action="/login" method="post" class="w-1/4 flex flex-col gap-4 bg-white border border-gray-400 p-8 rounded-lg">
                @csrf
                <h1 class="text-center text-2xl font-medium">Welcome back!</h1>
                @error('all')
                    <span class="text-sm text-red-500 text-center">{{ $message }}</span>
                @enderror
                <div class="flex flex-col">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" class="flex-1 border rounded-md border-gray-400 py-2 px-4" required>
                </div>

                <div class="flex flex-col">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" minlength="8" class="flex-1 border rounded-md border-gray-400 py-2 px-4" required>
                </div>

                <div class="flex">
                    <button class="flex-1 bg-blue-500 text-white py-2 px-4 hover:bg-blue-600 hover:text-gray-100 rounded cursor-pointer transition-all">Login</button>
                </div>
            </form>
        </section>
    </body>
</html>
