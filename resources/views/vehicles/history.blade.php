<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-500"></i> Historial: {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Datos del vehículo --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Propietario</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $vehicle->user->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Marca</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $vehicle->brand }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Modelo</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $vehicle->model }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Año</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $vehicle->year }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 uppercase">Patente</p>
                        <p class="font-mono font-bold text-indigo-500">{{ $vehicle->plate }}</p>
                    </div>
                </div>
            </div>

            {{-- Timeline de reparaciones --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-indigo-500"></i> Reparaciones Anteriores
                </h3>

                @forelse($tickets as $ticket)
                <div class="relative pl-8 pb-8 border-l-2 border-indigo-200 dark:border-indigo-800 last:border-l-0 last:pb-0">
                    {{-- Punto del timeline --}}
                    <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full
                        @if($ticket->status === 'completed') bg-emerald-500
                        @elseif($ticket->status === 'diagnosing') bg-amber-500
                        @else bg-gray-400 @endif">
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap justify-between items-start gap-2 mb-2">
                            <div>
                                <span class="text-xs text-gray-500 dark:text-slate-400">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $ticket->reported_fault }}</h4>
                            </div>
                            @php
                                $statusColors = [
                                    'reception' => 'bg-gray-100 text-gray-800',
                                    'diagnosing' => 'bg-amber-100 text-amber-800',
                                    'completed' => 'bg-emerald-100 text-emerald-800',
                                ];
                            @endphp
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColors[$ticket->status] ?? '' }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>

                        @if($ticket->diagnostic)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <i class="fa-solid fa-stethoscope mr-1 text-indigo-500"></i> {{ $ticket->diagnostic }}
                        </p>
                        @endif

                        {{-- Fotos adjuntas --}}
                        @if($ticket->photos && count($ticket->photos) > 0)
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach($ticket->photos as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto del daño"
                                 class="w-20 h-20 object-cover rounded-lg border border-gray-300 cursor-pointer hover:scale-110 transition">
                            @endforeach
                        </div>
                        @endif

                        {{-- Orden de trabajo asociada --}}
                        @if($ticket->workOrder)
                        <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex flex-wrap justify-between items-center gap-2 text-sm">
                                <div>
                                    <span class="font-mono font-bold text-indigo-500">{{ $ticket->workOrder->tracking_code }}</span>
                                    <span class="text-gray-500 dark:text-slate-400 mx-2">|</span>
                                    <span>{{ $ticket->workOrder->description }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-indigo-600">${{ number_format($ticket->workOrder->cost, 2) }}</span>
                                    <span class="font-mono text-xs">{{ $ticket->workOrder->current_progress }}</span>
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank"
                                       class="text-indigo-500 hover:text-indigo-700">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 py-8">No hay reparaciones registradas para este vehículo.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
