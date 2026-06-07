<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Project Repository') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">

        {{-- Logo / Branding --}}
        <div class="text-center mb-6">
            <a href="{{ route('login') }}" class="inline-block">
                <div
                    class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center
                            justify-center mx-auto mb-3 shadow-lg">
                    <span class="text-white font-extrabold text-2xl">P</span>
                </div>
            </a>
            <h1 class="text-xl font-bold text-gray-800">LASU Project Repository</h1>
            <p class="text-sm text-gray-500 mt-1">
                Department of Computer Science, Faculty of Science
            </p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            {{ $slot }}
        </div>

        {{-- Back to home --}}
        <p class="mt-6 text-xs text-gray-400">
            <a href="{{ url('/') }}" class="hover:text-blue-600 hover:underline">
                &larr; Back to home
            </a>
        </p>
    </div>

</body>

</html>
