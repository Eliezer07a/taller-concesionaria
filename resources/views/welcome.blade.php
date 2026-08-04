<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-white">
            <i class="fa-solid fa-car-side mr-2 text-indigo-400"></i> Bienvenido al Taller
        </h1>
        <p class="text-sm text-slate-400 mt-2">Venta de autos usados y diagnóstico técnico profesional con seguimiento en tiempo real.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 mb-6">
        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition">
            <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
        </a>
        <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-600 transition">
            <i class="fa-solid fa-user-plus"></i> Crear Cuenta
        </a>
    </div>

    <div class="border-t border-slate-700 pt-5 space-y-3">
        <a href="/seguimiento/TRK-A1B2C3" class="flex items-center gap-3 p-3 bg-slate-900 rounded-lg border border-slate-700 hover:border-indigo-500 transition group">
            <div class="bg-indigo-600 rounded-lg p-2 group-hover:scale-110 transition">
                <i class="fa-solid fa-magnifying-glass text-white"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Seguimiento de Reparación</p>
                <p class="text-xs text-slate-400">Consulta el avance de tu auto sin crear cuenta</p>
            </div>
        </a>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
            <div class="text-center p-3 bg-slate-800 rounded-lg border border-slate-700">
                <i class="fa-solid fa-wrench text-indigo-400 text-xl"></i>
                <p class="text-xs text-slate-300 mt-1">Diagnóstico Técnico</p>
            </div>
            <div class="text-center p-3 bg-slate-800 rounded-lg border border-slate-700">
                <i class="fa-solid fa-shield-halved text-emerald-400 text-xl"></i>
                <p class="text-xs text-slate-300 mt-1">Garantía Incluida</p>
            </div>
            <div class="text-center p-3 bg-slate-800 rounded-lg border border-slate-700">
                <i class="fa-solid fa-clock text-amber-400 text-xl"></i>
                <p class="text-xs text-slate-300 mt-1">Avance en Tiempo Real</p>
            </div>
        </div>
    </div>
</x-guest-layout>
