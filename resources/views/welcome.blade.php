<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-white">
            <i class="fa-solid fa-car-side mr-2 text-indigo-400"></i> Bienvenido al Taller
        </h1>
        <p class="text-sm text-slate-400 mt-2">Servicio de diagnóstico y reparación con avance en tiempo real.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 mb-6">
        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition">
            <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
        </a>
        <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-600 transition">
            <i class="fa-solid fa-user-plus"></i> Crear Cuenta
        </a>
    </div>
</x-guest-layout>
