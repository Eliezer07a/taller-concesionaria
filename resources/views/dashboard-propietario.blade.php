<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-400"></i> Mis Vehículos
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 text-sm text-emerald-300 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 backdrop-blur-xl font-semibold flex items-center gap-2 shadow-lg shadow-emerald-500/5">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 text-sm text-red-300 rounded-2xl bg-red-500/10 border border-red-500/20 backdrop-blur-xl font-semibold flex items-center gap-2 shadow-lg shadow-red-500/5">
                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            @php
                $finalizadas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado')->count();
                $enCurso = $tickets->count() - $finalizadas;
                $ultimoTicket = $tickets->where('workOrder')->sortByDesc('created_at')->first();
                $progresoActual = $ultimoTicket && $ultimoTicket->workOrder ? $ultimoTicket->workOrder->current_progress : '0%';
            @endphp

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Vehicles Count --}}
                <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl p-5 flex items-center gap-4 hover:border-indigo-500/40 hover:shadow-lg hover:shadow-indigo-500/10 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/10 flex items-center justify-center group-hover:from-indigo-500/30 group-hover:to-indigo-600/20 transition-all duration-300 ring-1 ring-indigo-500/20">
                        <i class="fa-solid fa-car text-2xl text-indigo-400"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">{{ $vehicles->count() }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Vehículos Registrados</p>
                    </div>
                </div>

                {{-- En Curso --}}
                <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl p-5 flex items-center gap-4 hover:border-amber-500/40 hover:shadow-lg hover:shadow-amber-500/10 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 flex items-center justify-center group-hover:from-amber-500/30 group-hover:to-amber-600/20 transition-all duration-300 ring-1 ring-amber-500/20">
                        <i class="fa-solid fa-clipboard-list text-2xl text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">{{ $enCurso }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Reparaciones en Curso</p>
                    </div>
                </div>

                {{-- Finalizadas --}}
                <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl p-5 flex items-center gap-4 hover:border-emerald-500/40 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 flex items-center justify-center group-hover:from-emerald-500/30 group-hover:to-emerald-600/20 transition-all duration-300 ring-1 ring-emerald-500/20">
                        <i class="fa-solid fa-check-circle text-2xl text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">{{ $finalizadas }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Reparaciones Finalizadas</p>
                    </div>
                </div>
            </div>

            {{-- Progreso Actual (si hay reparación activa) --}}
            @if($ultimoTicket && $ultimoTicket->workOrder && $ultimoTicket->workOrder->status !== 'finalizado')
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                        </span>
                        <span class="text-sm font-semibold text-white">Última Reparación en Curso</span>
                    </div>
                    <span class="text-xs text-slate-400 bg-slate-800/60 px-3 py-1 rounded-full border border-slate-700/50">{{ $ultimoTicket->vehicle->brand }} {{ $ultimoTicket->vehicle->model }}</span>
                </div>
                <div class="w-full bg-slate-800/80 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 via-purple-400 to-emerald-400 h-3 rounded-full transition-all duration-700 shadow-lg shadow-indigo-500/20" style="width: {{ $progresoActual }}"></div>
                </div>
                <div class="flex justify-between mt-3">
                    <span class="text-xs text-slate-400">{{ ucfirst(str_replace('_', ' ', $ultimoTicket->workOrder->status)) }}</span>
                    <span class="text-xs font-mono text-indigo-400 font-bold">{{ $progresoActual }}</span>
                </div>
            </div>
            @endif

            {{-- Tabla de vehículos --}}
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800/50 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/10 flex items-center justify-center ring-1 ring-indigo-500/20">
                        <i class="fa-solid fa-car text-sm text-indigo-400"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">Mis Vehículos</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-800/50">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Patente</th>
                                <th class="px-5 py-3 font-semibold">Marca / Modelo</th>
                                <th class="px-5 py-3 font-semibold">Año</th>
                                <th class="px-5 py-3 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-slate-800/30 transition-colors duration-200">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-400">{{ $vehicle->plate }}</td>
                                <td class="px-5 py-3 font-semibold text-white">{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                <td class="px-5 py-3 text-slate-300">{{ $vehicle->year }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('vehicles.history', $vehicle) }}"
                                       class="px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-xl text-xs font-bold hover:from-indigo-500 hover:to-indigo-400 transition-all duration-200 inline-flex items-center gap-1.5 shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30">
                                        <i class="fa-solid fa-folder-open"></i> Ficha
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-indigo-600/5 border border-indigo-500/20 flex items-center justify-center mx-auto mb-4 ring-1 ring-indigo-500/10">
                                        <i class="fa-solid fa-car-side text-2xl text-indigo-400"></i>
                                    </div>
                                    <p class="text-white font-semibold mb-1">Sin vehículos</p>
                                    <p class="text-slate-500 text-sm">Aún no tienes vehículos registrados en el sistema.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Seguimiento de reparaciones --}}
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800/50 flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/10 flex items-center justify-center ring-1 ring-indigo-500/20">
                            <i class="fa-solid fa-wrench text-sm text-indigo-400"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">Seguimiento de Reparaciones</h3>
                    </div>
                    <span class="inline-flex items-center gap-2 text-[11px] text-emerald-400 font-semibold bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        En Vivo · <span id="ultima-actualizacion">--:--:--</span>
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-800/50">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Vehículo</th>
                                <th class="px-5 py-3 font-semibold">Falla</th>
                                <th class="px-5 py-3 font-semibold">Mecánico</th>
                                <th class="px-5 py-3 font-semibold">Estado</th>
                                <th class="px-5 py-3 font-semibold">Progreso</th>
                                <th class="px-5 py-3 font-semibold">Código</th>
                                <th class="px-5 py-3 font-semibold text-right">Seguimiento</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse($tickets as $ticket)
                                @if($ticket->workOrder)
                                <tr id="ticket-row-{{ $ticket->id }}" class="hover:bg-slate-800/30 transition-colors duration-200">
                                    <td class="px-5 py-3">
                                        <a href="{{ route('vehicles.history', $ticket->vehicle) }}" class="font-semibold text-white hover:text-indigo-400 hover:underline transition">
                                            {{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3 text-slate-300 text-xs max-w-[180px] truncate" title="{{ $ticket->reported_fault }}">{{ $ticket->reported_fault }}</td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-full bg-slate-800/60 border border-slate-700/50 text-slate-300">
                                            <i class="fa-solid fa-wrench text-indigo-400 text-[9px]"></i> {{ $ticket->mechanic->name ?? 'Asignado' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $statusColors = [
                                                'recibido' => 'bg-slate-500/15 text-slate-300 border border-slate-500/25',
                                                'en_revision' => 'bg-blue-500/15 text-blue-300 border border-blue-500/25',
                                                'en_proceso' => 'bg-amber-500/15 text-amber-300 border border-amber-500/25',
                                                'finalizado' => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/25',
                                            ];
                                        @endphp
                                        <span id="status-badge-{{ $ticket->id }}" class="text-[11px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm {{ $statusColors[$ticket->workOrder->status] ?? 'bg-slate-500/15 text-slate-300 border border-slate-500/25' }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->workOrder->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="w-24 bg-slate-800/80 rounded-full h-1.5 overflow-hidden">
                                            <div id="progress-bar-{{ $ticket->id }}" class="bg-gradient-to-r from-indigo-500 to-emerald-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ $ticket->workOrder->current_progress }}"></div>
                                        </div>
                                        <span id="progress-text-{{ $ticket->id }}" class="text-[10px] font-mono text-indigo-400">{{ $ticket->workOrder->current_progress }}</span>
                                    </td>
                                    <td class="px-5 py-3 font-mono font-bold text-indigo-400 text-xs">{{ $ticket->workOrder->tracking_code }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank"
                                           class="px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-xl text-xs font-bold hover:from-indigo-500 hover:to-indigo-400 transition-all duration-200 inline-flex items-center gap-1.5 shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-700/50 to-slate-800/50 border border-slate-600/30 flex items-center justify-center mx-auto mb-4 ring-1 ring-slate-600/20">
                                        <i class="fa-solid fa-wrench text-2xl text-slate-500"></i>
                                    </div>
                                    <p class="text-white font-semibold mb-1">Sin reparaciones</p>
                                    <p class="text-slate-500 text-sm">No hay reparaciones registradas aún para tus vehículos.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        const STATUS_COLORS = {
            'recibido': 'bg-slate-500/15 text-slate-300 border border-slate-500/25',
            'en_revision': 'bg-blue-500/15 text-blue-300 border border-blue-500/25',
            'en_proceso': 'bg-amber-500/15 text-amber-300 border border-amber-500/25',
            'finalizado': 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/25',
        };

        function refreshReparaciones() {
            fetch('{{ route('api.mis-reparaciones') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(tickets => {
                tickets.forEach(t => {
                    const row = document.getElementById(`ticket-row-${t.id}`);
                    if (!row) return;

                    const badge = document.getElementById(`status-badge-${t.id}`);
                    if (badge) {
                        badge.textContent = t.status.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());
                        badge.className = `text-[11px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm ${STATUS_COLORS[t.status] ?? 'bg-slate-500/15 text-slate-300 border border-slate-500/25'}`;
                    }

                    const bar = document.getElementById(`progress-bar-${t.id}`);
                    if (bar) bar.style.width = t.current_progress;

                    const text = document.getElementById(`progress-text-${t.id}`);
                    if (text) text.textContent = t.current_progress;
                });

                const stamp = document.getElementById('ultima-actualizacion');
                if (stamp) stamp.textContent = new Date().toLocaleTimeString();
            })
            .catch(() => {});
        }

        document.addEventListener('DOMContentLoaded', () => {
            setInterval(refreshReparaciones, 1000);
        });
    </script>
</x-app-layout>
