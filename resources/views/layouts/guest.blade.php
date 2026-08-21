
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Souq') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-100 min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-indigo-300">
                    S
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-2xl tracking-tight text-slate-900 leading-none">Souq</span>
                    <span class="text-xs font-bold text-indigo-600 tracking-wider uppercase">Marketplace</span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white p-8 sm:p-10 shadow-xl shadow-slate-200/60 border border-slate-200/80 rounded-3xl">
            {{ $slot }}
        </div>
    </body>
</html>
