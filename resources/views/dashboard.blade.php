<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-wrench mr-2 text-indigo-500"></i> Panel de Control del Taller
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

            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-folder-plus text-indigo-500"></i> Documentar Falla y Crear Orden de Trabajo
                </h3>

                <form action="{{ route('tickets.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar Vehículo</label>
                        <select name="vehicle_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate }}) — {{ $vehicle->user->name ?? 'Sin propietario' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Costo Estimado ($)</label>
                        <input type="number" step="0.01" name="cost" required placeholder="150.00" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Falla Documentada por el Taller</label>
                        <textarea name="reported_fault" rows="2" required placeholder="Ej: Ruido metálico al frenar y fuga de líquido..." class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnóstico Técnico</label>
                        <input type="text" name="diagnostic" required placeholder="Desgaste total de balatas delanteras" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción del Trabajo</label>
                        <input type="text" name="description" required placeholder="Reemplazo de balatas y rectificado de discos" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fotos del Daño (máx. 5)</label>
                        <input type="file" name="photos[]" multiple accept="image/*"
                               class="mt-1 block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-slate-700 file:text-slate-200 hover:file:bg-slate-600">
                    </div>

                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Generar Ticket & Código
                        </button>
                    </div>
                </form>
            </div>

            @php
                $activas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status !== 'finalizado');
                $finalizadas = $tickets->filter(fn($t) => $t->workOrder && $t->workOrder->status === 'finalizado');
                $statusColors = [
                    'recibido' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                    'en_revision' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                    'en_proceso' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                    'finalizado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                ];
            @endphp

            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-500"></i> Reparaciones y Control de Avance
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="switchTab('activas')" id="tab-btn-activas"
                                class="px-4 py-2 rounded-lg text-sm font-bold bg-indigo-600 text-white shadow flex items-center gap-2 transition">
                            <i class="fa-solid fa-wrench text-xs"></i> Activas
                            <span class="bg-white/25 rounded-full px-2 py-0.5 text-xs">{{ $activas->count() }}</span>
                        </button>
                        <button onclick="switchTab('finalizadas')" id="tab-btn-finalizadas"
                                class="px-4 py-2 rounded-lg text-sm font-bold bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 flex items-center gap-2 transition">
                            <i class="fa-solid fa-circle-check text-xs"></i> Finalizadas
                            <span class="bg-slate-200 dark:bg-slate-600 rounded-full px-2 py-0.5 text-xs">{{ $finalizadas->count() }}</span>
                        </button>
                    </div>
                </div>

                {{-- Reparaciones activas --}}
                <div id="panel-activas" class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Código</th>
                                <th class="px-4 py-3">Vehículo</th>
                                <th class="px-4 py-3">Cliente</th>
                                <th class="px-4 py-3">Falla Documentada</th>
                                <th class="px-4 py-3">Fotos</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Progreso</th>
                                <th class="px-4 py-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activas as $ticket)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-mono font-bold text-indigo-500">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank" class="hover:underline">
                                        {{ $ticket->workOrder->tracking_code }} <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}
                                    <a href="{{ route('vehicles.history', $ticket->vehicle) }}" class="text-indigo-500 hover:text-indigo-700 ml-1" title="Ver historial">
                                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                                        <i class="fa-solid fa-user text-indigo-500"></i> {{ $ticket->vehicle->user->name ?? 'Sin propietario' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $ticket->reported_fault }}</td>
                                <td class="px-4 py-3">
                                    @if($ticket->photos && count($ticket->photos) > 0)
                                    <div class="flex gap-1">
                                        @foreach(array_slice($ticket->photos, 0, 3) as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-8 h-8 object-cover rounded border">
                                        @endforeach
                                        @if(count($ticket->photos) > 3)
                                        <span class="text-xs text-gray-400 self-center">+{{ count($ticket->photos) - 3 }}</span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <select id="status-{{ $ticket->workOrder->id }}" class="text-xs rounded border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                                        <option value="recibido" {{ $ticket->workOrder->status == 'recibido' ? 'selected' : '' }}>Recibido</option>
                                        <option value="en_revision" {{ $ticket->workOrder->status == 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                        <option value="en_proceso" {{ $ticket->workOrder->status == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="finalizado" {{ $ticket->workOrder->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <select id="progress-{{ $ticket->workOrder->id }}" class="text-xs rounded border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                                        <option value="10%" {{ $ticket->workOrder->current_progress == '10%' ? 'selected' : '' }}>10% - Ingreso</option>
                                        <option value="30%" {{ $ticket->workOrder->current_progress == '30%' ? 'selected' : '' }}>30% - Diagnóstico</option>
                                        <option value="60%" {{ $ticket->workOrder->current_progress == '60%' ? 'selected' : '' }}>60% - En Reparación</option>
                                        <option value="90%" {{ $ticket->workOrder->current_progress == '90%' ? 'selected' : '' }}>90% - Pruebas</option>
                                        <option value="100%" {{ $ticket->workOrder->current_progress == '100%' ? 'selected' : '' }}>100% - Listo</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <button onclick="updateProgress({{ $ticket->workOrder->id }})" class="px-3 py-1 bg-emerald-600 text-white rounded text-xs font-bold hover:bg-emerald-700">
                                        Actualizar
                                    </button>
                                    <a href="{{ route('work-orders.pdf', $ticket->workOrder) }}" target="_blank" class="px-3 py-1 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                    <i class="fa-solid fa-circle-check text-3xl mb-2 block text-emerald-300"></i>
                                    No hay reparaciones activas en este momento.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Reparaciones finalizadas --}}
                <div id="panel-finalizadas" class="hidden overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Código</th>
                                <th class="px-4 py-3">Vehículo</th>
                                <th class="px-4 py-3">Cliente</th>
                                <th class="px-4 py-3">Falla</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Progreso</th>
                                <th class="px-4 py-3">Costo</th>
                                <th class="px-4 py-3">Entregado</th>
                                <th class="px-4 py-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($finalizadas as $ticket)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-mono font-bold text-indigo-500">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank" class="hover:underline">
                                        {{ $ticket->workOrder->tracking_code }} <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}
                                    <a href="{{ route('vehicles.history', $ticket->vehicle) }}" class="text-indigo-500 hover:text-indigo-700 ml-1" title="Ver historial">
                                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                                        <i class="fa-solid fa-user text-indigo-500"></i> {{ $ticket->vehicle->user->name ?? 'Sin propietario' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $ticket->reported_fault }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColors[$ticket->workOrder->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->workOrder->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $ticket->workOrder->current_progress }}"></div>
                                    </div>
                                    <span class="text-xs font-mono text-emerald-500">{{ $ticket->workOrder->current_progress }}</span>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">${{ number_format($ticket->workOrder->cost, 2) }}</td>
                                <td class="px-4 py-3 text-xs">{{ $ticket->workOrder->updated_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('work-orders.pdf', $ticket->workOrder) }}" target="_blank" class="px-3 py-1 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-gray-400">
                                    <i class="fa-solid fa-hourglass-half text-3xl mb-2 block text-slate-300"></i>
                                    Aún no hay reparaciones finalizadas.
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
        const ACTIVE_BTN = 'px-4 py-2 rounded-lg text-sm font-bold bg-indigo-600 text-white shadow flex items-center gap-2 transition';
        const INACTIVE_BTN = 'px-4 py-2 rounded-lg text-sm font-bold bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 flex items-center gap-2 transition';

        function switchTab(tab) {
            const isActivas = tab === 'activas';
            document.getElementById('panel-activas').classList.toggle('hidden', !isActivas);
            document.getElementById('panel-finalizadas').classList.toggle('hidden', isActivas);
            document.getElementById('tab-btn-activas').className = isActivas ? ACTIVE_BTN : INACTIVE_BTN;
            document.getElementById('tab-btn-finalizadas').className = isActivas ? INACTIVE_BTN : ACTIVE_BTN;
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
                    showConfirmButton: false
                }).then(() => {
                    if (data.status === 'finalizado') {
                        location.reload();
                    }
                });
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el avance.'
                });
            });
        }
    </script>
</x-app-layout>
