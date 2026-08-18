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
        <style>
            @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
            .float-anim { animation: float 3s ease-in-out infinite; }
            .float-anim-delay { animation: float 3s ease-in-out infinite 1s; }
            .float-anim-delay-2 { animation: float 3s ease-in-out infinite 2s; }
            .text-gradient { background: linear-gradient(135deg, #818cf8, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-950">

        <div class="min-h-screen flex">

            {{-- Panel Izquierdo: Marca --}}
            <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-slate-900 overflow-hidden">
                {{-- Fondo decorativo --}}
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-20 left-10 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl"></div>
                </div>

                <div class="relative z-10 flex flex-col justify-center px-12 xl:px-16 w-full">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-3 mb-12">
                        <div class="bg-white/10 backdrop-blur rounded-2xl p-3 border border-white/10">
                            <i class="fa-solid fa-car-side text-2xl text-white"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-white">NavaMotor</span>
                    </a>

                    {{-- Texto --}}
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-6">
                        Tu taller,<br>
                        <span class="text-indigo-200">siempre visible.</span>
                    </h1>
                    <p class="text-lg text-indigo-200/70 mb-10 max-w-md leading-relaxed">
                        Gestiona reparaciones con seguimiento en tiempo real. Cada cliente puede ver el avance de su vehículo con un simple código.
                    </p>

                    {{-- Features --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-satellite-dish text-sm text-white"></i>
                            </div>
                            <span class="text-sm text-indigo-100/80">Seguimiento en tiempo real de cada reparación</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-file-pdf text-sm text-white"></i>
                            </div>
                            <span class="text-sm text-indigo-100/80">Órdenes de trabajo exportables en PDF</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-camera text-sm text-white"></i>
                            </div>
                            <span class="text-sm text-indigo-100/80">Documentación fotográfica del daño</span>
                        </div>
                    </div>

                    {{-- Iconos flotantes decorativos --}}
                    <div class="absolute bottom-16 right-12 text-white/10 text-8xl float-anim">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <div class="absolute top-20 right-20 text-white/5 text-6xl float-anim-delay">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="absolute bottom-40 left-12 text-white/5 text-5xl float-anim-delay-2">
                        <i class="fa-solid fa-car"></i>
                    </div>
                </div>
            </div>

            {{-- Panel Derecho: Formulario --}}
            <div class="flex-1 flex flex-col items-center justify-center px-4 sm:px-8 py-12 relative">
                {{-- Fondo sutil --}}
                <div class="absolute inset-0 pointer-events-none overflow-hidden">
                    <div class="absolute -top-32 -right-32 w-96 h-96 bg-indigo-600/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-emerald-600/5 rounded-full blur-3xl"></div>
                </div>

                <div class="relative z-10 w-full max-w-md">
                    {{-- Logo mobile --}}
                    <div class="flex lg:hidden items-center justify-center gap-3 mb-8">
                        <a href="/" class="flex items-center gap-2.5">
                            <div class="bg-indigo-600 rounded-xl p-2 shadow-lg shadow-indigo-600/20">
                                <i class="fa-solid fa-car-side text-white text-lg"></i>
                            </div>
                            <span class="text-white font-bold text-lg">NavaMotor</span>
                        </a>
                    </div>

                    {{ $slot }}

                    <p class="text-center text-[11px] text-slate-600 mt-8">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Acceso seguro — Seguimiento de reparaciones en tiempo real
                    </p>
                </div>
            </div>
        </div>

    </body>
</html>
