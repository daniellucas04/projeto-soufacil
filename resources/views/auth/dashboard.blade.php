<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sou Fácil :: Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    @extends('auth.components.sidebar')
    @section('content')
        <main class="mt-8 p-4">
            <h1 class="text-xl font-medium mb-4">Shortcuts</h1>
            <div class="flex items-center gap-4">
                <a href="/users" class="bg-blue-500 text-white rounded-full py-2 px-4 hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Create new user</a>
                <a href="/customers" class="bg-blue-500 text-white rounded-full py-2 px-4 hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Create customer</a>
                <a href="/sales" class="bg-blue-500 text-white rounded-full py-2 px-4 hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Create sale</a>
                <a href="/reciepts" class="bg-blue-500 text-white rounded-full py-2 px-4 hover:bg-blue-600 hover:text-neutral-100 cursor-pointer transition-all">Show all reciepts</a>
            </div>
        </main>
    @endsection
</body>
</html>