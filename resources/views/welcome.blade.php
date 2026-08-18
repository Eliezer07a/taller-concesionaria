<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'NavaMotor') }} — Taller de Diagnóstico y Reparación</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .fade-up { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
            .fade-up.visible { opacity: 1; transform: translateY(0); }
            .fade-up-delay-1 { transition-delay: 0.1s; }
            .fade-up-delay-2 { transition-delay: 0.2s; }
            .fade-up-delay-3 { transition-delay: 0.3s; }
            .fade-up-delay-4 { transition-delay: 0.4s; }
            .glow-indigo { box-shadow: 0 0 40px rgba(99,102,241,0.15); }
            .text-gradient { background: linear-gradient(135deg, #818cf8, #6366f1, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .hero-bg { background: radial-gradient(ellipse at 30% 20%, rgba(99,102,241,0.12) 0%, transparent 50%), radial-gradient(ellipse at 70% 80%, rgba(16,185,129,0.08) 0%, transparent 50%); }
            .card-glow:hover { box-shadow: 0 8px 40px rgba(99,102,241,0.12); border-color: rgba(99,102,241,0.3); }
            @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
            .float-anim { animation: float 3s ease-in-out infinite; }
            .float-anim-delay { animation: float 3s ease-in-out infinite 1.5s; }
            @keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(2.2); opacity: 0; } }
            .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
            .scroll-indicator { animation: bounce 2s infinite; }
            @keyframes bounce { 0%,20%,50%,80%,100% { transform: translateY(0); } 40% { transform: translateY(-8px); } 60% { transform: translateY(-4px); } }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100">

        {{-- NAVBAR --}}
        <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="bg-indigo-600 rounded-xl p-2 shadow-lg shadow-indigo-600/20">
                        <i class="fa-solid fa-car-side text-white text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-lg">NavaMotor</span>
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white transition">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">
                        Registrarse
                    </a>
                </div>
            </div>
        </nav>

        {{-- HERO --}}
        <section class="relative min-h-screen flex items-center hero-bg overflow-hidden pt-16">
            {{-- Elementos decorativos de fondo --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-600/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-600/8 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-3xl"></div>
                {{-- Iconos flotantes de fondo --}}
                <div class="absolute top-32 right-1/4 text-indigo-500/10 text-7xl float-anim"><i class="fa-solid fa-wrench"></i></div>
                <div class="absolute bottom-32 left-1/4 text-emerald-500/10 text-6xl float-anim-delay"><i class="fa-solid fa-car"></i></div>
                <div class="absolute top-1/2 right-10 text-amber-500/10 text-5xl float-anim"><i class="fa-solid fa-gear"></i></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    {{-- Texto --}}
                    <div class="fade-up">
                        <div class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 rounded-full px-4 py-1.5 mb-6">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-semibold text-indigo-300">Seguimiento en tiempo real</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                            <span class="text-white">Tu taller,</span><br>
                            <span class="text-gradient">siempre visible.</span>
                        </h1>

                        <p class="text-lg text-slate-400 mb-8 max-w-lg leading-relaxed">
                            Sistema de gestión para talleres de diagnóstico y reparación automotriz. 
                            Documenta fallas, genera órdenes de trabajo y ofrece a tus clientes 
                            <span class="text-white font-semibold">seguimiento en tiempo real</span> de cada reparación.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="px-7 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-500/40 flex items-center gap-2 text-base">
                                <i class="fa-solid fa-rocket"></i> Comenzar Gratis
                            </a>
                            <a href="#features" class="px-7 py-3.5 bg-slate-800/80 border border-slate-700 text-white font-bold rounded-xl hover:bg-slate-700 hover:border-slate-600 transition-all duration-300 flex items-center gap-2 text-base">
                                <i class="fa-solid fa-star"></i> Ver Características
                            </a>
                        </div>

                        {{-- Stats mini --}}
                        <div class="flex gap-8 mt-10 pt-8 border-t border-slate-800">
                            <div>
                                <p class="text-2xl font-bold text-white">4</p>
                                <p class="text-xs text-slate-500">Estados de seguimiento</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">100%</p>
                                <p class="text-xs text-slate-500">En tiempo real</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">PDF</p>
                                <p class="text-xs text-slate-500">Órdenes exportables</p>
                            </div>
                        </div>
                    </div>

                    {{-- Visual / Card mockup --}}
                    <div class="fade-up fade-up-delay-2 hidden lg:block">
                        <div class="relative">
                            {{-- Card principal mockup --}}
                            <div class="bg-slate-800/90 backdrop-blur border border-slate-700/50 rounded-2xl p-6 glow-indigo shadow-2xl">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                                        <i class="fa-solid fa-car text-indigo-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">Toyota Corolla 2024</p>
                                        <p class="text-slate-500 text-xs">Patente: ABC-1234</p>
                                    </div>
                                    <span class="ml-auto bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-500/20">En Proceso</span>
                                </div>

                                {{-- Stepper mockup --}}
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="flex-1 h-1.5 bg-indigo-500 rounded-full"></div>
                                    <div class="flex-1 h-1.5 bg-indigo-500 rounded-full"></div>
                                    <div class="flex-1 h-1.5 bg-indigo-500 rounded-full"></div>
                                    <div class="flex-1 h-1.5 bg-slate-700 rounded-full"></div>
                                </div>
                                <div class="flex justify-between text-[9px] text-slate-500 mb-5">
                                    <span class="text-indigo-400 font-semibold">Recibido</span>
                                    <span class="text-indigo-400 font-semibold">Revisión</span>
                                    <span class="text-indigo-400 font-semibold">Proceso</span>
                                    <span>Listo</span>
                                </div>

                                {{-- Barra de progreso --}}
                                <div class="bg-slate-900 rounded-full h-3 mb-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-emerald-400 h-full rounded-full" style="width: 75%"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-400">Progreso general</span>
                                    <span class="text-xs font-mono text-emerald-400 font-bold">75%</span>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-700/50 flex items-center justify-between">
                                    <span class="text-xs text-slate-500"><i class="fa-solid fa-clock mr-1"></i> Actualizado hace 2 min</span>
                                    <span class="text-xs font-mono text-indigo-400 font-bold">TRK-A8F2K9</span>
                                </div>
                            </div>

                            {{-- Badge flotante --}}
                            <div class="absolute -top-4 -right-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg shadow-emerald-500/30 float-anim">
                                <i class="fa-solid fa-bell mr-1"></i> ¡Listo para entregar!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Scroll indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 scroll-indicator">
                <a href="#features" class="text-slate-600 hover:text-slate-400 transition">
                    <i class="fa-solid fa-chevron-down text-xl"></i>
                </a>
            </div>
        </section>

        {{-- FEATURES --}}
        <section id="features" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-up">
                    <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Características</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-3 mb-4">Todo lo que tu taller necesita</h2>
                    <p class="text-slate-400 max-w-2xl mx-auto">Herramientas diseñadas para mecánicos y propietarios de vehículos, con seguimiento en cada paso del proceso.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Feature 1 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-indigo-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-1 group">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center mb-4 group-hover:bg-indigo-500/20 transition">
                            <i class="fa-solid fa-clipboard-list text-xl text-indigo-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Órdenes de Trabajo</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Genera órdenes automáticamente al documentar una falla. Cada orden incluye código de seguimiento único.</p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-emerald-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-2 group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center mb-4 group-hover:bg-emerald-500/20 transition">
                            <i class="fa-solid fa-satellite-dish text-xl text-emerald-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Seguimiento en Vivo</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Los propietarios ven el progreso de su reparación en tiempo real, sin necesidad de llamar al taller.</p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-amber-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-3 group">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center mb-4 group-hover:bg-amber-500/20 transition">
                            <i class="fa-solid fa-camera text-xl text-amber-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Fotos del Daño</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Adjunta fotos del estado del vehículo al momento de la recepción para documentar cada detalle.</p>
                    </div>

                    {{-- Feature 4 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-rose-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-1 group">
                        <div class="w-12 h-12 rounded-xl bg-rose-500/10 flex items-center justify-center mb-4 group-hover:bg-rose-500/20 transition">
                            <i class="fa-solid fa-file-pdf text-xl text-rose-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Exportación PDF</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Genera documentos PDF profesionales con el resumen completo de cada orden de trabajo.</p>
                    </div>

                    {{-- Feature 5 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-blue-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-2 group">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center mb-4 group-hover:bg-blue-500/20 transition">
                            <i class="fa-solid fa-timeline text-xl text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Historial Completo</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Cada vehículo tiene su historial de reparaciones con fechas, diagnósticos y costos acumulados.</p>
                    </div>

                    {{-- Feature 6 --}}
                    <div class="bg-slate-800/60 border border-slate-700/50 rounded-2xl p-6 hover:border-purple-500/30 transition-all duration-300 card-glow fade-up fade-up-delay-3 group">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center mb-4 group-hover:bg-purple-500/20 transition">
                            <i class="fa-solid fa-users text-xl text-purple-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Gestión de Roles</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Mecánicos gestionan el taller. Propietarios solo ven sus vehículos y reparaciones.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CÓMO FUNCIONA --}}
        <section id="como-funciona" class="py-24 relative bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-up">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Proceso</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-3 mb-4">Así de simple</h2>
                    <p class="text-slate-400 max-w-xl mx-auto">Cuatro pasos para que tus clientes sepan exactamente en qué estado está su vehículo.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                    {{-- Línea conectora --}}
                    <div class="hidden lg:block absolute top-12 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-indigo-500 via-amber-500 to-emerald-500 opacity-30"></div>

                    {{-- Paso 1 --}}
                    <div class="text-center fade-up fade-up-delay-1 relative">
                        <div class="w-24 h-24 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mx-auto mb-5 relative">
                            <i class="fa-solid fa-car text-3xl text-indigo-400"></i>
                            <span class="absolute -top-2 -right-2 w-7 h-7 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-indigo-600/30">1</span>
                        </div>
                        <h3 class="text-white font-bold mb-2">Recepción</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">El mecánico registra el vehículo, documenta la falla y adjunta fotos del daño.</p>
                    </div>

                    {{-- Paso 2 --}}
                    <div class="text-center fade-up fade-up-delay-2 relative">
                        <div class="w-24 h-24 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center mx-auto mb-5 relative">
                            <i class="fa-solid fa-magnifying-glass text-3xl text-amber-400"></i>
                            <span class="absolute -top-2 -right-2 w-7 h-7 bg-amber-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-amber-600/30">2</span>
                        </div>
                        <h3 class="text-white font-bold mb-2">Diagnóstico</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Se realiza el diagnóstico técnico y se genera la orden de trabajo con código único.</p>
                    </div>

                    {{-- Paso 3 --}}
                    <div class="text-center fade-up fade-up-delay-3 relative">
                        <div class="w-24 h-24 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mx-auto mb-5 relative">
                            <i class="fa-solid fa-gear text-3xl text-blue-400"></i>
                            <span class="absolute -top-2 -right-2 w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-600/30">3</span>
                        </div>
                        <h3 class="text-white font-bold mb-2">Reparación</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">El propietario sigue el avance en tiempo real con el código de seguimiento.</p>
                    </div>

                    {{-- Paso 4 --}}
                    <div class="text-center fade-up fade-up-delay-4 relative">
                        <div class="w-24 h-24 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mx-auto mb-5 relative">
                            <i class="fa-solid fa-check-double text-3xl text-emerald-400"></i>
                            <span class="absolute -top-2 -right-2 w-7 h-7 bg-emerald-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-emerald-600/30">4</span>
                        </div>
                        <h3 class="text-white font-bold mb-2">Entrega</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Se finaliza la orden, se exporta el PDF y el vehículo está listo para entregar.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA FINAL --}}
        <section class="py-24 relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-up">
                <div class="bg-gradient-to-br from-indigo-600/20 via-slate-800/80 to-emerald-600/20 border border-slate-700/50 rounded-3xl p-10 sm:p-14 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/5 to-emerald-600/5 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-600/20 flex items-center justify-center mx-auto mb-6">
                            <i class="fa-solid fa-wrench text-3xl text-indigo-400"></i>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">¿Listo para profesionalizar tu taller?</h2>
                        <p class="text-slate-400 mb-8 max-w-lg mx-auto">Regístrate gratis y comienza a gestionar tus reparaciones con seguimiento en tiempo real.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-500/40 text-base">
                            <i class="fa-solid fa-rocket"></i> Crear Mi Cuenta Gratis
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="border-t border-slate-800/50 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <div class="bg-indigo-600 rounded-lg p-1.5">
                            <i class="fa-solid fa-car-side text-white text-sm"></i>
                        </div>
                        <span class="text-white font-bold text-sm">NavaMotor</span>
                    </div>
                    <p class="text-xs text-slate-500">
                        <i class="fa-solid fa-wrench mr-1"></i> Taller de Diagnóstico y Reparación — Concesionaria de Autos Usados
                    </p>
                    <p class="text-xs text-slate-600">&copy; {{ date('Y') }} NavaMotor</p>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
            });
        </script>
    </body>
</html>
