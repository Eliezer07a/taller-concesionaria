<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-500"></i> Vehículos Registrados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('vehicles.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Nuevo Vehículo
                </a>
            </div>

            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Propietario</th>
                            <th class="px-4 py-3">Patente</th>
                            <th class="px-4 py-3">Marca</th>
                            <th class="px-4 py-3">Modelo</th>
                            <th class="px-4 py-3">Año</th>
                            <th class="px-4 py-3">VIN</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $vehicle->user->name ?? '—' }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-indigo-500">{{ $vehicle->plate }}</td>
                            <td class="px-4 py-3">{{ $vehicle->brand }}</td>
                            <td class="px-4 py-3">{{ $vehicle->model }}</td>
                            <td class="px-4 py-3">{{ $vehicle->year }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $vehicle->vin }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('vehicles.history', $vehicle) }}" class="px-2 py-1 bg-indigo-600 text-white rounded text-xs font-bold hover:bg-indigo-700" title="Historial">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </a>
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="px-2 py-1 bg-blue-600 text-white rounded text-xs font-bold hover:bg-blue-700">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('¿Eliminar este vehículo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">No hay vehículos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
