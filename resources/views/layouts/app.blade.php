<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Project Repository') }} — {{ $title ?? 'LASU CS Department' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between p-4 bg-green-50 border border-green-200
                        text-green-800 rounded-lg text-sm">
                <span>✓ {{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800 ml-4">✕</button>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                class="flex items-center justify-between p-4 bg-red-50 border border-red-200
                        text-red-800 rounded-lg text-sm">
                <span>✕ {{ session('error') }}</span>
                <button @click="show = false" class="text-red-600 hover:text-red-800 ml-4">✕</button>
            </div>
        @endif
        @if (session('warning'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200
                        text-yellow-800 rounded-lg text-sm">
                <span>⚠ {{ session('warning') }}</span>
                <button @click="show = false" class="text-yellow-600 hover:text-yellow-800 ml-4">✕</button>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} LASU Department of Computer Science -
                    Final Year Project Repository
                </p>
                <p class="text-xs text-gray-400">
                    Developed by Adepemeji Samuel Adetomiwa &bull; {{ date('Y') }}
                </p>
            </div>
        </div>
    </footer>

</body>

</html>
