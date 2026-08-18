<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-400"></i> Vehículos Registrados
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 text-sm text-emerald-300 rounded-xl bg-emerald-500/10 border border-emerald-500/20 font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('vehicles.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Nuevo Vehículo
                </a>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-700">
                            <tr>
                                <th class="px-5 py-3">Propietario</th>
                                <th class="px-5 py-3">Patente</th>
                                <th class="px-5 py-3">Marca</th>
                                <th class="px-5 py-3">Modelo</th>
                                <th class="px-5 py-3">Año</th>
                                <th class="px-5 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="px-5 py-3 font-semibold text-white">{{ $vehicle->user->name ?? '—' }}</td>
                                <td class="px-5 py-3 font-mono font-bold text-indigo-400">{{ $vehicle->plate }}</td>
                                <td class="px-5 py-3 text-slate-300">{{ $vehicle->brand }}</td>
                                <td class="px-5 py-3 text-slate-300">{{ $vehicle->model }}</td>
                                <td class="px-5 py-3 text-slate-300">{{ $vehicle->year }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600/80 text-white rounded-lg text-xs font-bold hover:bg-emerald-500 transition" title="Ir al panel de control">
                                            <i class="fa-solid fa-gauge-high"></i> Panel
                                        </a>
                                        <a href="{{ route('vehicles.history', $vehicle) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-500 transition" title="Ver ficha del vehículo">
                                            <i class="fa-solid fa-folder-open"></i> Ficha
                                        </a>
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600/80 text-white rounded-lg text-xs font-bold hover:bg-blue-500 transition">
                                            <i class="fa-solid fa-pen"></i> Editar
                                        </a>
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('¿Eliminar este vehículo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600/80 text-white rounded-lg text-xs font-bold hover:bg-red-500 transition">
                                                <i class="fa-solid fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-car-side text-2xl text-indigo-400"></i>
                                    </div>
                                    <p class="text-white font-semibold mb-1">Sin vehículos</p>
                                    <p class="text-slate-500 text-sm">No hay vehículos registrados aún.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
