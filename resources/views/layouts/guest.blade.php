<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">

        <!-- Card Login -->
        <div class="w-full sm:max-w-md bg-white shadow-lg rounded-lg px-6 py-6">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo" class="w-28 h-28 object-contain mx-auto">

            <!-- Judul -->
            <div class="text-center mb-6 max-w-2xl">
                <h1 class="text-xl font-bold text-gray-700">
                    Website Prediksi Pencapaian Target Produksi Harian PT Bumi Menara Internusa
                </h1>
            </div>
            {{ $slot }}
        </div>

    </div>
</body>

</html>
