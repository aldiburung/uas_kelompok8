<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KDKMP') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-gradient-to-br from-red-600 via-red-500 to-red-700 text-white font-sans">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full max-w-5xl rounded-[40px] bg-white/10 border border-white/20 shadow-2xl backdrop-blur-xl overflow-hidden">
                <div class="bg-white/10 p-6 sm:px-8 sm:py-8 text-center">
                    <div class="mx-auto max-w-xl">
                        <p class="text-xs tracking-[0.28em] uppercase text-red-100">Welcome to Website KDKMP</p>
                        <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-white">Silakan login untuk mengelola sistem komoditas desa dan keuangan.</h1>
                    </div>
                </div>
                <div class="bg-white/90 p-6 sm:p-8 text-gray-900">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
