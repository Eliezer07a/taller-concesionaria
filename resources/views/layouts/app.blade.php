<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'NavaMotor') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950">
        {{-- Fondo decorativo global --}}
        <div class="fixed inset-0 pointer-events-none z-0">
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-600/5 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-emerald-600/3 rounded-full blur-[120px]"></div>
        </div>
        <div class="relative z-10">
            @include('layouts.navigation')
        </div>
    </body>
</html>
