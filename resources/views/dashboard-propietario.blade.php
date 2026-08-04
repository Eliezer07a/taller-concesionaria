<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-500"></i> Mis Vehículos
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

            @if($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $finalizadas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado')->count();
                $enCurso = $tickets->count() - $finalizadas;
            @endphp

            {{-- Resumen --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center gap-3">
                    <i class="fa-solid fa-car text-3xl text-indigo-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vehicles->count() }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Vehículos Registrados</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center gap-3">
                    <i class="fa-solid fa-clipboard-list text-3xl text-amber-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $enCurso }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Reparaciones en Curso</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-3xl text-emerald-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $finalizadas }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Reparaciones Finalizadas</p>
                    </div>
                </div>
            </div>

            {{-- Tabla de vehículos --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-car text-indigo-500"></i> Mis Vehículos
                    </h3>
                    <button onclick="document.getElementById('nuevo-vehiculo').classList.toggle('hidden')"
                            class="px-3 py-1.5 bg-indigo-600 text-white rounded text-xs font-bold hover:bg-indigo-700 inline-flex items-center gap-1">
                        <i class="fa-solid fa-plus"></i> Registrar Vehículo
                    </button>
                </div>

                <div id="nuevo-vehiculo" class="hidden mb-6 p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-car-side text-indigo-500"></i> Registrar mi vehículo en el taller
                    </h4>
                    <form action="{{ route('vehicles.store-own') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Patente</label>
                            <input type="text" name="plate" maxlength="10" required placeholder="ABC-1234"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Marca</label>
                            <input type="text" name="brand" maxlength="50" required placeholder="Toyota"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Modelo</label>
                            <input type="text" name="model" maxlength="50" required placeholder="Corolla"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Año</label>
                            <input type="number" name="year" min="1900" max="{{ date('Y') + 1 }}" required placeholder="{{ date('Y') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">VIN</label>
                            <input type="text" name="vin" maxlength="17" required placeholder="17 caracteres"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-3 py-2 bg-emerald-600 text-white font-bold rounded-md hover:bg-emerald-700 transition text-xs">
                                <i class="fa-solid fa-save mr-1"></i> Guardar Vehículo
                            </button>
                        </div>
                    </form>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Patente</th>
                            <th class="px-4 py-3">Marca / Modelo</th>
                            <th class="px-4 py-3">Año</th>
                            <th class="px-4 py-3">VIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 font-mono font-bold text-indigo-500">{{ $vehicle->plate }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                            <td class="px-4 py-3">{{ $vehicle->year }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $vehicle->vin }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No tienes vehículos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Seguimiento de reparaciones --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-wrench text-indigo-500"></i> Seguimiento de Reparaciones
                </h3>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Vehículo</th>
                            <th class="px-4 py-3">Falla</th>
                            <th class="px-4 py-3">Mecánico</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Progreso</th>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Seguimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            @if($ticket->workOrder)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}
                                </td>
                                <td class="px-4 py-3">{{ $ticket->reported_fault }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                                        <i class="fa-solid fa-wrench text-indigo-500"></i> {{ $ticket->mechanic->name ?? 'Asignado' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'recibido' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                            'en_revision' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'en_proceso' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                            'finalizado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                        ];
                                    @endphp
                                    <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColors[$ticket->workOrder->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->workOrder->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $ticket->workOrder->current_progress }}"></div>
                                    </div>
                                    <span class="text-xs font-mono text-indigo-500">{{ $ticket->workOrder->current_progress }}</span>
                                </td>
                                <td class="px-4 py-3 font-mono font-bold text-indigo-500">{{ $ticket->workOrder->tracking_code }}</td>
                                <td class="px-4 py-3">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank"
                                       class="px-3 py-1 bg-indigo-600 text-white rounded text-xs font-bold hover:bg-indigo-700 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">No hay reparaciones registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
