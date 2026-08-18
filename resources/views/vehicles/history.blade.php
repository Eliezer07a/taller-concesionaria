<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-400"></i> Ficha del Vehículo:
            {{ $vehicle->brand }} {{ $vehicle->model }} <span class="font-mono text-indigo-400">({{ $vehicle->plate }})</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $conOrden = $tickets->filter(fn($t) => $t->workOrder);
                $finalizadas = $conOrden->filter(fn($t) => $t->workOrder->status === 'finalizado')->count();
                $enCurso = $conOrden->count() - $finalizadas;
                $totalMonto = $conOrden->sum(fn($t) => (float) $t->workOrder->cost);

                $workOrderColors = [
                    'recibido' => 'bg-slate-500/20 text-slate-300 border border-slate-500/30',
                    'en_revision' => 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
                    'en_proceso' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
                    'finalizado' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
                ];
                $dotColors = [
                    'recibido' => 'bg-slate-500',
                    'en_revision' => 'bg-blue-500',
                    'en_proceso' => 'bg-amber-500',
                    'finalizado' => 'bg-emerald-500',
                ];
                $barColors = [
                    'recibido' => 'bg-slate-400',
                    'en_revision' => 'bg-blue-500',
                    'en_proceso' => 'bg-amber-500',
                    'finalizado' => 'bg-emerald-500',
                ];
            @endphp

            {{-- Datos del vehículo --}}
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-user text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Propietario</p>
                        <p class="font-bold text-white text-sm mt-0.5">{{ $vehicle->user->name ?? '—' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-industry text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Marca</p>
                        <p class="font-bold text-white text-sm mt-0.5">{{ $vehicle->brand }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-car text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Modelo</p>
                        <p class="font-bold text-white text-sm mt-0.5">{{ $vehicle->model }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-calendar text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Año</p>
                        <p class="font-bold text-white text-sm mt-0.5">{{ $vehicle->year }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-hashtag text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Patente</p>
                        <p class="font-mono font-bold text-indigo-400 text-sm mt-0.5">{{ $vehicle->plate }}</p>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 flex items-center gap-3 hover:border-amber-500/50 transition group">
                    <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center group-hover:bg-amber-500/20 transition">
                        <i class="fa-solid fa-clipboard-list text-lg text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $enCurso }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">En Curso</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 flex items-center gap-3 hover:border-emerald-500/50 transition group">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                        <i class="fa-solid fa-circle-check text-lg text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $finalizadas }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Finalizadas</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 flex items-center gap-3 hover:border-indigo-500/50 transition group">
                    <div class="w-11 h-11 rounded-xl bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20 transition">
                        <i class="fa-solid fa-wrench text-lg text-indigo-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $conOrden->count() }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Reparaciones</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 flex items-center gap-3 hover:border-emerald-500/50 transition group">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                        <i class="fa-solid fa-dollar-sign text-lg text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">${{ number_format($totalMonto, 0) }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Monto Total</p>
                    </div>
                </div>
            </div>

            {{-- Timeline de reparaciones --}}
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                <div class="flex items-center gap-2 mb-6">
                    <i class="fa-solid fa-timeline text-indigo-400"></i>
                    <h3 class="text-base font-bold text-white">Historial de Reparaciones</h3>
                </div>

                @forelse($tickets as $ticket)
                <div class="relative pl-10 pb-8 last:pb-0">
                    {{-- Línea vertical --}}
                    @if(!$loop->last)
                    <div class="absolute left-[13px] top-6 bottom-0 w-0.5 bg-slate-700"></div>
                    @endif

                    {{-- Dot de estado --}}
                    <div class="absolute left-0 top-1 w-[27px] h-[27px] rounded-full border-[3px] border-slate-800 {{ $dotColors[$ticket->workOrder->status ?? 'recibido'] ?? 'bg-slate-500' }} z-10"></div>

                    {{-- Card --}}
                    <div class="bg-slate-900 border border-slate-700/50 rounded-xl p-4 hover:border-slate-600 transition">
                        <div class="flex flex-wrap justify-between items-start gap-2 mb-3">
                            <div>
                                <span class="text-[10px] text-slate-500 uppercase tracking-wider">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                <h4 class="font-bold text-white mt-0.5">{{ $ticket->reported_fault }}</h4>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                                    <i class="fa-solid fa-wrench text-[9px]"></i> {{ $ticket->mechanic->name ?? 'Sin asignar' }}
                                </span>
                                @if($ticket->workOrder)
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $workOrderColors[$ticket->workOrder->status] ?? 'bg-slate-500/20 text-slate-300' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->workOrder->status)) }}
                                </span>
                                @endif
                            </div>
                        </div>

                        @if($ticket->diagnostic)
                        <p class="text-sm text-slate-400 mb-3 flex items-start gap-2">
                            <i class="fa-solid fa-stethoscope text-indigo-400 mt-0.5 shrink-0"></i>
                            <span>{{ $ticket->diagnostic }}</span>
                        </p>
                        @endif

                        @if($ticket->photos && count($ticket->photos) > 0)
                        <div class="flex gap-2 mb-3 flex-wrap">
                            @foreach($ticket->photos as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto del daño"
                                 class="w-20 h-20 object-cover rounded-lg border border-slate-600 cursor-pointer hover:scale-110 transition">
                            @endforeach
                        </div>
                        @endif

                        @if($ticket->workOrder)
                        <div class="bg-slate-800 rounded-lg p-3 border border-slate-700/50 space-y-2">
                            <div class="flex flex-wrap justify-between items-center gap-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-indigo-400 text-xs">{{ $ticket->workOrder->tracking_code }}</span>
                                    <span class="text-slate-600">|</span>
                                    <span class="text-slate-300 text-xs">{{ $ticket->workOrder->description }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-emerald-400 text-sm">${{ number_format($ticket->workOrder->cost, 2) }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $ticket->workOrder->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-slate-700 rounded-full h-2">
                                    <div class="{{ $barColors[$ticket->workOrder->status] ?? 'bg-indigo-500' }} h-2 rounded-full transition-all duration-500"
                                         style="width: {{ $ticket->workOrder->current_progress }}"></div>
                                </div>
                                <span class="font-mono text-xs text-indigo-400">{{ $ticket->workOrder->current_progress }}</span>
                                <a href="{{ route('work-orders.pdf', $ticket->workOrder) }}" target="_blank"
                                   class="px-2.5 py-1 bg-red-600/80 text-white rounded-lg text-[11px] font-bold hover:bg-red-500 transition inline-flex items-center gap-1">
                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                </a>
                                <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank"
                                   class="text-indigo-400 hover:text-indigo-300 text-sm transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-slate-700/50 border border-slate-600/50 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-car-side text-2xl text-slate-500"></i>
                    </div>
                    <p class="text-white font-semibold mb-1">Sin historial</p>
                    <p class="text-slate-500 text-sm">No hay reparaciones registradas para este vehículo.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
