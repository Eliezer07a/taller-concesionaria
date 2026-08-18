<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-wrench mr-2 text-indigo-400"></i> Panel de Control del Taller
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="p-4 text-sm text-emerald-300 rounded-xl bg-emerald-500/10 border border-emerald-500/20 font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 text-sm text-red-300 rounded-xl bg-red-500/10 border border-red-500/20">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Stats Cards --}}
            @php
                $activasCount = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status !== 'finalizado')->count();
                $finalizadasCount = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado')->count();
                $totalIngresos = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado')->sum(fn($t) => (float) $t->workOrder->cost);
                $vehiculosActivos = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status !== 'finalizado')->pluck('vehicle_id')->unique()->count();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-indigo-500/50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20 transition">
                        <i class="fa-solid fa-wrench text-xl text-indigo-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $activasCount }}</p>
                        <p class="text-xs text-slate-400">Activas Ahora</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-emerald-500/50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                        <i class="fa-solid fa-circle-check text-xl text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $finalizadasCount }}</p>
                        <p class="text-xs text-slate-400">Finalizadas</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-amber-500/50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center group-hover:bg-amber-500/20 transition">
                        <i class="fa-solid fa-car text-xl text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $vehiculosActivos }}</p>
                        <p class="text-xs text-slate-400">Vehículos en Taller</p>
                    </div>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-emerald-500/50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition">
                        <i class="fa-solid fa-dollar-sign text-xl text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">${{ number_format($totalIngresos, 0) }}</p>
                        <p class="text-xs text-slate-400">Ingresos Totales</p>
                    </div>
                </div>
            </div>

            {{-- Formulario crear ticket --}}
            <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-folder-plus text-indigo-400"></i>
                    <h3 class="text-base font-bold text-white">Documentar Falla y Crear Orden de Trabajo</h3>
                </div>

                <form action="{{ route('tickets.store') }}" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Seleccionar Vehículo</label>
                        @php $disponiblesIds = $disponibles->pluck('id')->toArray(); @endphp
                        <select id="vehicle-select" name="vehicle_id" required class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                        data-disponible="{{ in_array($vehicle->id, $disponiblesIds) ? '1' : '0' }}"
                                        @if(!in_array($vehicle->id, $disponiblesIds)) hidden @endif>
                                    {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate }}) — {{ $vehicle->user->name ?? 'Sin propietario' }}
                                </option>
                            @endforeach
                        </select>
                        <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-500 cursor-pointer select-none hover:text-slate-300 transition">
                            <input type="checkbox" id="incluir-entregados" class="rounded border-slate-600 bg-slate-900 text-indigo-500 focus:ring-indigo-500">
                            <i class="fa-solid fa-rotate-left"></i> Incluir vehículos ya entregados
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Costo Estimado ($)</label>
                        <input type="number" step="0.01" name="cost" required placeholder="150.00" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Falla Documentada por el Taller</label>
                        <textarea name="reported_fault" rows="2" required placeholder="Ej: Ruido metálico al frenar y fuga de líquido..." class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Diagnóstico Técnico</label>
                        <input type="text" name="diagnostic" required placeholder="Desgaste total de balatas delanteras" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Descripción del Trabajo</label>
                        <input type="text" name="description" required placeholder="Reemplazo de balatas y rectificado de discos" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Fotos del Daño (máx. 5)</label>
                        <input type="file" id="photos-input" name="photos[]" multiple accept="image/*"
                               class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 file:cursor-pointer">
                        <span id="photos-warning" class="hidden mt-1 text-xs text-red-400 font-semibold">Máximo 5 fotos. Elimina algunas para continuar.</span>
                        <div id="photos-preview" class="grid grid-cols-3 sm:grid-cols-5 gap-2 mt-3"></div>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Generar Ticket y Código
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabla reparaciones --}}
            @php
                $activas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status !== 'finalizado');
                $finalizadas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado');
                $statusColors = [
                    'recibido' => 'bg-slate-500/20 text-slate-300 border border-slate-500/30',
                    'en_revision' => 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
                    'en_proceso' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
                    'finalizado' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
                ];
            @endphp

            <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-400"></i>
                        <h3 class="text-base font-bold text-white">Reparaciones y Control de Avance</h3>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="switchTab('activas')" id="tab-btn-activas"
                                class="px-4 py-2 rounded-lg text-xs font-bold bg-indigo-600 text-white flex items-center gap-2 transition hover:bg-indigo-500">
                            <i class="fa-solid fa-wrench"></i> Activas
                            <span class="bg-white/20 rounded-full px-2 py-0.5 text-[10px]">{{ $activas->count() }}</span>
                        </button>
                        <button onclick="switchTab('finalizadas')" id="tab-btn-finalizadas"
                                class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-700 text-slate-300 hover:bg-slate-600 flex items-center gap-2 transition">
                            <i class="fa-solid fa-circle-check"></i> Finalizadas
                            <span class="bg-slate-600 rounded-full px-2 py-0.5 text-[10px]">{{ $finalizadas->count() }}</span>
                        </button>
                    </div>
                </div>

                {{-- Panel Activas --}}
                <div id="panel-activas" class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-700">
                            <tr>
                                <th class="px-5 py-3">Código</th>
                                <th class="px-5 py-3">Vehículo</th>
                                <th class="px-5 py-3">Cliente</th>
                                <th class="px-5 py-3">Falla</th>
                                <th class="px-5 py-3">Fotos</th>
                                <th class="px-5 py-3">Estado</th>
                                <th class="px-5 py-3">Progreso</th>
                                <th class="px-5 py-3 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($activas as $ticket)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="px-5 py-3">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank" class="font-mono font-bold text-indigo-400 hover:text-indigo-300 hover:underline text-xs">
                                        {{ $ticket->workOrder->tracking_code }} <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold text-white">{{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}</span>
                                    <a href="{{ route('vehicles.history', $ticket->vehicle) }}" class="ml-1 text-indigo-400 hover:text-indigo-300" title="Ver ficha">
                                        <i class="fa-solid fa-folder-open text-[10px]"></i>
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-full bg-slate-700 text-slate-300">
                                        <i class="fa-solid fa-user text-indigo-400 text-[9px]"></i> {{ $ticket->vehicle->user->name ?? 'Sin prop.' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-slate-300 text-xs max-w-[200px] truncate" title="{{ $ticket->reported_fault }}">{{ $ticket->reported_fault }}</td>
                                <td class="px-5 py-3">
                                    @if($ticket->photos && count($ticket->photos) > 0)
                                    <div class="flex gap-1">
                                        @foreach(array_slice($ticket->photos, 0, 3) as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-7 h-7 object-cover rounded-md border border-slate-600">
                                        @endforeach
                                        @if(count($ticket->photos) > 3)
                                        <span class="text-[10px] text-slate-500 self-center">+{{ count($ticket->photos) - 3 }}</span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-slate-600 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <select id="status-{{ $ticket->workOrder->id }}" class="text-xs rounded-lg border-slate-600 bg-slate-900 text-white focus:ring-indigo-500 py-1.5">
                                        <option value="recibido" {{ $ticket->workOrder->status == 'recibido' ? 'selected' : '' }}>Recibido</option>
                                        <option value="en_revision" {{ $ticket->workOrder->status == 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                        <option value="en_proceso" {{ $ticket->workOrder->status == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="finalizado" {{ $ticket->workOrder->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                    </select>
                                </td>
                                <td class="px-5 py-3">
                                    <select id="progress-{{ $ticket->workOrder->id }}" class="text-xs rounded-lg border-slate-600 bg-slate-900 text-white focus:ring-indigo-500 py-1.5">
                                        <option value="10%" {{ $ticket->workOrder->current_progress == '10%' ? 'selected' : '' }}>10% - Ingreso</option>
                                        <option value="30%" {{ $ticket->workOrder->current_progress == '30%' ? 'selected' : '' }}>30% - Diagnóstico</option>
                                        <option value="60%" {{ $ticket->workOrder->current_progress == '60%' ? 'selected' : '' }}>60% - En Reparación</option>
                                        <option value="90%" {{ $ticket->workOrder->current_progress == '90%' ? 'selected' : '' }}>90% - Pruebas</option>
                                        <option value="100%" {{ $ticket->workOrder->current_progress == '100%' ? 'selected' : '' }}>100% - Listo</option>
                                    </select>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="updateProgress({{ $ticket->workOrder->id }})" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-500 transition">
                                            <i class="fa-solid fa-check mr-1"></i> Actualizar
                                        </button>
                                        <a href="{{ route('work-orders.pdf', $ticket->workOrder) }}" target="_blank" class="px-3 py-1.5 bg-red-600/80 text-white rounded-lg text-xs font-bold hover:bg-red-500 transition inline-flex items-center gap-1">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                        <button onclick="deleteTicket({{ $ticket->id }})" title="Eliminar" class="px-3 py-1.5 bg-rose-600/80 text-white rounded-lg text-xs font-bold hover:bg-rose-500 transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center">
                                    <i class="fa-solid fa-circle-check text-4xl mb-3 block text-emerald-500/50"></i>
                                    <p class="text-slate-500 text-sm">No hay reparaciones activas en este momento.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Panel Finalizadas --}}
                <div id="panel-finalizadas" class="hidden overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-700">
                            <tr>
                                <th class="px-5 py-3">Código</th>
                                <th class="px-5 py-3">Vehículo</th>
                                <th class="px-5 py-3">Cliente</th>
                                <th class="px-5 py-3">Falla</th>
                                <th class="px-5 py-3">Estado</th>
                                <th class="px-5 py-3">Progreso</th>
                                <th class="px-5 py-3">Costo</th>
                                <th class="px-5 py-3">Entregado</th>
                                <th class="px-5 py-3 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($finalizadas as $ticket)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="px-5 py-3">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank" class="font-mono font-bold text-indigo-400 hover:text-indigo-300 hover:underline text-xs">
                                        {{ $ticket->workOrder->tracking_code }} <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold text-white">{{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}</span>
                                    <a href="{{ route('vehicles.history', $ticket->vehicle) }}" class="ml-1 text-indigo-400 hover:text-indigo-300" title="Ver ficha">
                                        <i class="fa-solid fa-folder-open text-[10px]"></i>
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-full bg-slate-700 text-slate-300">
                                        <i class="fa-solid fa-user text-indigo-400 text-[9px]"></i> {{ $ticket->vehicle->user->name ?? 'Sin prop.' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-slate-300 text-xs max-w-[200px] truncate" title="{{ $ticket->reported_fault }}">{{ $ticket->reported_fault }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $statusColors[$ticket->workOrder->status] ?? 'bg-slate-500/20 text-slate-300' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->workOrder->status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="w-20 bg-slate-700 rounded-full h-1.5">
                                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $ticket->workOrder->current_progress }}"></div>
                                    </div>
                                    <span class="text-[10px] font-mono text-emerald-400">{{ $ticket->workOrder->current_progress }}</span>
                                </td>
                                <td class="px-5 py-3 font-semibold text-white">${{ number_format($ticket->workOrder->cost, 2) }}</td>
                                <td class="px-5 py-3 text-xs text-slate-400">{{ $ticket->workOrder->updated_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('work-orders.pdf', $ticket->workOrder) }}" target="_blank" class="px-3 py-1.5 bg-red-600/80 text-white rounded-lg text-xs font-bold hover:bg-red-500 transition inline-flex items-center gap-1">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                        <button onclick="deleteTicket({{ $ticket->id }})" title="Eliminar" class="px-3 py-1.5 bg-rose-600/80 text-white rounded-lg text-xs font-bold hover:bg-rose-500 transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-5 py-12 text-center">
                                    <i class="fa-solid fa-hourglass-half text-4xl mb-3 block text-slate-600"></i>
                                    <p class="text-slate-500 text-sm">Aún no hay reparaciones finalizadas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const ACTIVE_BTN = 'px-4 py-2 rounded-lg text-xs font-bold bg-indigo-600 text-white flex items-center gap-2 transition hover:bg-indigo-500';
        const INACTIVE_BTN = 'px-4 py-2 rounded-lg text-xs font-bold bg-slate-700 text-slate-300 hover:bg-slate-600 flex items-center gap-2 transition';

        const incluirEntregados = document.getElementById('incluir-entregados');
        if (incluirEntregados) {
            incluirEntregados.addEventListener('change', function () {
                const mostrarTodos = this.checked;
                document.querySelectorAll('#vehicle-select option').forEach(opt => {
                    opt.hidden = mostrarTodos ? false : opt.dataset.disponible === '0';
                });
            });
        }

        const photosInput = document.getElementById('photos-input');
        const photosPreview = document.getElementById('photos-preview');
        const photosWarning = document.getElementById('photos-warning');

        function previewPhotos() {
            const files = Array.from(photosInput.files);
            const shown = files.slice(0, 5);

            photosWarning.classList.toggle('hidden', files.length <= 5);
            photosPreview.innerHTML = '';

            shown.forEach((file, i) => {
                if (!file.type.startsWith('image/')) return;

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'block w-full h-full object-cover rounded-lg border border-slate-600';

                const badge = document.createElement('span');
                badge.className = 'absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-bold rounded-full px-1.5';
                badge.textContent = (i + 1);

                const wrap = document.createElement('div');
                wrap.className = 'relative w-20 h-20';
                wrap.appendChild(img);
                wrap.appendChild(badge);

                photosPreview.appendChild(wrap);
            });
        }

        if (photosInput) {
            photosInput.addEventListener('change', previewPhotos);
        }

        function switchTab(tab) {
            const isActivas = tab === 'activas';
            document.getElementById('panel-activas').classList.toggle('hidden', !isActivas);
            document.getElementById('panel-finalizadas').classList.toggle('hidden', isActivas);
            document.getElementById('tab-btn-activas').className = isActivas ? ACTIVE_BTN : INACTIVE_BTN;
            document.getElementById('tab-btn-finalizadas').className = isActivas ? INACTIVE_BTN : ACTIVE_BTN;
        }

        function deleteTicket(ticketId) {
            Swal.fire({
                title: '¿Eliminar este registro?',
                text: 'Se eliminará el ticket, la orden de trabajo y las fotos asociadas.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#475569',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#1e293b',
                color: '#e2e8f0'
            }).then((result) => {
                if (!result.isConfirmed) return;

                fetch(`/tickets/${ticketId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        background: '#1e293b',
                        color: '#e2e8f0'
                    }).then(() => location.reload());
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo eliminar.', background: '#1e293b', color: '#e2e8f0' });
                });
            });
        }

        function updateProgress(workOrderId) {
            const status = document.getElementById(`status-${workOrderId}`).value;
            const progress = document.getElementById(`progress-${workOrderId}`).value;

            fetch(`/work-orders/${workOrderId}/progress`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status, current_progress: progress })
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: data.status === 'finalizado' ? '¡Reparación Finalizada!' : '¡Actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#1e293b',
                    color: '#e2e8f0'
                }).then(() => {
                    if (data.status === 'finalizado') location.reload();
                });
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo actualizar.', background: '#1e293b', color: '#e2e8f0' });
            });
        }
    </script>
</x-app-layout>
