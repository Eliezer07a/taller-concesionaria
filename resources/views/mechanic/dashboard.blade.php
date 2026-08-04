<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-wrench mr-2 text-indigo-500"></i> Panel de Control del Taller
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensaje de éxito con SweetAlert2 / Alert -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulario: Documentar Falla del Auto -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-folder-plus text-indigo-500"></i> Documentar Falla y Crear Orden de Trabajo
                </h3>

                <form action="{{ route('tickets.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar Vehículo</label>
                        <select name="vehicle_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate }})</option>
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

                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Generar Ticket & Código
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Avances del Taller -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-indigo-500"></i> Reparaciones Activas y Control de Avance
                </h3>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Vehículo</th>
                            <th class="px-4 py-3">Falla Documentada</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Progreso</th>
                            <th class="px-4 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            @if($ticket->workOrder)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-mono font-bold text-indigo-500">
                                    <a href="/seguimiento/{{ $ticket->workOrder->tracking_code }}" target="_blank" class="hover:underline">
                                        {{ $ticket->workOrder->tracking_code }} <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->vehicle->brand }} {{ $ticket->vehicle->model }}
                                </td>
                                <td class="px-4 py-3">{{ $ticket->reported_fault }}</td>
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
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Script Fetch para actualizar avance sin recargar la página -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                    title: '¡Actualizado!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
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