<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Reparación en Tiempo Real</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl p-6 relative overflow-hidden">
        
        <!-- Indicador de Tiempo Real -->
        <div class="absolute top-4 right-4 flex items-center space-x-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <span class="text-[10px] text-emerald-400 font-semibold uppercase tracking-wider">En Vivo</span>
        </div>

        <div class="text-center mb-6">
            <i class="fa-solid fa-screwdriver-wrench text-4xl text-indigo-500 mb-2"></i>
            <h2 class="text-2xl font-bold text-white">Estado de Reparación</h2>
            <p class="text-xs text-slate-400 mt-1">Código: <span class="font-mono text-indigo-400 font-bold">{{ $tracking_code }}</span></p>
        </div>

        <div id="loading" class="text-center py-8">
            <i class="fa-solid fa-circle-notch fa-spin text-3xl text-indigo-500"></i>
            <p class="text-sm text-slate-400 mt-2">Cargando estado...</p>
        </div>

        <div id="tracking-content" class="hidden space-y-4">
            <!-- Vehículo -->
            <div class="bg-slate-700/50 p-4 rounded-xl flex items-center space-x-3 border border-slate-600/50">
                <i class="fa-solid fa-car text-2xl text-indigo-400"></i>
                <div>
                    <p class="text-xs text-slate-400">Vehículo</p>
                    <p id="vehicle" class="font-semibold text-white"></p>
                </div>
            </div>

            <!-- Falla Reportada por el Taller -->
            <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600/50">
                <p class="text-xs text-slate-400 flex items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i> Falla Documentada:
                </p>
                <p id="reported_fault" class="text-sm font-medium text-slate-200 mt-1"></p>
            </div>

            <!-- Estado y Barra de Progreso -->
            <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600/50 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-400">Estado Actual</span>
                    <span id="status" class="text-xs font-bold text-indigo-400 uppercase tracking-wide"></span>
                </div>
                
                <!-- Barra de Progreso -->
                <div class="w-full bg-slate-900 rounded-full h-3 border border-slate-700 overflow-hidden">
                    <div id="progress-bar" class="bg-gradient-to-r from-indigo-500 to-emerald-400 h-full transition-all duration-700 ease-out" style="width: 0%"></div>
                </div>
                <div class="text-right">
                    <span id="progress-text" class="text-xs font-mono text-emerald-400 font-bold">0%</span>
                </div>
            </div>

            <p class="text-[11px] text-center text-slate-500 pt-2">
                Actualizado: <span id="updated_at" class="text-slate-400"></span>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trackingCode = "{{ $tracking_code }}";

            function fetchStatus() {
                fetch(`/api/seguimiento/${trackingCode}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Código no encontrado');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('loading').classList.add('hidden');
                        document.getElementById('tracking-content').classList.remove('hidden');

                        document.getElementById('vehicle').textContent = data.vehicle;
                        document.getElementById('reported_fault').textContent = data.reported_fault ?? 'En revisión técnica';
                        document.getElementById('status').textContent = data.status.replace('_', ' ');
                        
                        // --- Cambio realizado aquí ---
                        // Revisa 'current_progress' o 'progress'. Si no encuentra ninguno, usa '0%'
                        let progressValue = data.current_progress ?? data.progress ?? '0%';

                        // Formatea para asegurar que termine en "%" (ej. 50 -> "50%")
                        if (typeof progressValue === 'number' || !String(progressValue).includes('%')) {
                            progressValue = `${progressValue}%`;
                        }

                        // Actualiza el ancho de la barra y el texto del porcentaje
                        document.getElementById('progress-bar').style.width = progressValue;
                        document.getElementById('progress-text').textContent = progressValue;
                        // -----------------------------

                        document.getElementById('updated_at').textContent = data.updated_at;
                    })
                    .catch(error => {
                        document.getElementById('loading').classList.add('hidden');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Consulta',
                            text: 'No se encontró información para este código de seguimiento.',
                            background: '#1e293b',
                            color: '#fff',
                            confirmButtonColor: '#6366f1'
                        });
                    });
            }

            // Carga inicial al entrar
            fetchStatus();

            // Auto-actualización silenciosa en tiempo real cada 5 segundos
            setInterval(fetchStatus, 5000);
        });
    </script>
</body>
</html>