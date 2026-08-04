<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-900 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">

        {{-- Fondo decorativo --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-indigo-600 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-emerald-500 blur-3xl"></div>
            <div class="absolute top-1/3 left-1/2 transform -translate-x-1/2 w-64 h-64 rounded-full bg-blue-500 blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full sm:max-w-md">
            <div class="flex flex-col items-center mb-6">
                <a href="/" class="flex items-center gap-3">
                    <div class="bg-indigo-600 rounded-2xl p-3 shadow-lg shadow-indigo-600/30">
                        <i class="fa-solid fa-car-side text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-white leading-tight">Concesionaria de Autos Usados</p>
                        <p class="text-xs text-slate-400">Taller de Diagnóstico y Reparación</p>
                    </div>
                </a>
            </div>

            <div class="bg-slate-800 border border-slate-700 shadow-2xl rounded-2xl px-8 py-8">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-slate-500 mt-6">
                <i class="fa-solid fa-shield-halved mr-1"></i> Acceso seguro — Seguimiento de reparaciones en tiempo real
            </p>
        </div>
    </body>
</html>
