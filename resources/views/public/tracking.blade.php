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

    <div class="max-w-lg w-full bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl p-6 relative overflow-hidden">
        
        <!-- Indicador de Tiempo Real -->
        <div class="absolute top-4 right-4 flex items-center space-x-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <span class="text-[10px] text-emerald-400 font-semibold uppercase tracking-wider">En Vivo</span>
        </div>

        <div class="text-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-screwdriver-wrench text-2xl text-indigo-400"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Estado de Reparación</h2>
            <p class="text-xs text-slate-400 mt-1">Código: <span class="font-mono text-indigo-400 font-bold">{{ $tracking_code }}</span></p>
        </div>

        <div id="loading" class="text-center py-8">
            <i class="fa-solid fa-circle-notch fa-spin text-3xl text-indigo-500"></i>
            <p class="text-sm text-slate-400 mt-2">Cargando estado...</p>
        </div>

        <div id="tracking-content" class="hidden space-y-5">
            <!-- Vehículo -->
            <div class="bg-slate-700/50 p-4 rounded-xl flex items-center space-x-3 border border-slate-600/50">
                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-car text-indigo-400"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider">Vehículo</p>
                    <p id="vehicle" class="font-semibold text-white text-sm"></p>
                </div>
            </div>

            <!-- Falla Reportada -->
            <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600/50">
                <p class="text-[10px] text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i> Falla Documentada
                </p>
                <p id="reported_fault" class="text-sm text-slate-200"></p>
            </div>

            <!-- Stepper de Estados -->
            <div class="bg-slate-700/50 p-5 rounded-xl border border-slate-600/50">
                <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-4">Progreso de la Reparación</p>
                
                <div class="flex items-center justify-between relative mb-6">
                    <!-- Línea de fondo -->
                    <div class="absolute top-4 left-0 right-0 h-0.5 bg-slate-600"></div>
                    <!-- Línea de progreso -->
                    <div id="stepper-line" class="absolute top-4 left-0 h-0.5 bg-gradient-to-r from-indigo-500 to-emerald-400 transition-all duration-700" style="width: 0%"></div>

                    <!-- Paso 1: Recibido -->
                    <div class="flex flex-col items-center relative z-10">
                        <div id="step-1" class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center border-2 border-slate-800 transition-all duration-500">
                            <i class="fa-solid fa-inbox text-xs text-slate-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 mt-2 font-semibold">Recibido</span>
                    </div>

                    <!-- Paso 2: En Revisión -->
                    <div class="flex flex-col items-center relative z-10">
                        <div id="step-2" class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center border-2 border-slate-800 transition-all duration-500">
                            <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 mt-2 font-semibold">Revisión</span>
                    </div>

                    <!-- Paso 3: En Proceso -->
                    <div class="flex flex-col items-center relative z-10">
                        <div id="step-3" class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center border-2 border-slate-800 transition-all duration-500">
                            <i class="fa-solid fa-gear text-xs text-slate-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 mt-2 font-semibold">Proceso</span>
                    </div>

                    <!-- Paso 4: Finalizado -->
                    <div class="flex flex-col items-center relative z-10">
                        <div id="step-4" class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center border-2 border-slate-800 transition-all duration-500">
                            <i class="fa-solid fa-check text-xs text-slate-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 mt-2 font-semibold">Finalizado</span>
                    </div>
                </div>

                <!-- Estado actual -->
                <div class="text-center mt-4">
                    <span id="status" class="text-sm font-bold text-indigo-400 uppercase tracking-wide"></span>
                </div>
            </div>

            <!-- Barra de Progreso -->
            <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600/50">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] text-slate-500 uppercase tracking-wider">Progreso General</span>
                    <span id="progress-text" class="text-sm font-mono text-emerald-400 font-bold">0%</span>
                </div>
                <div class="w-full bg-slate-900 rounded-full h-3 border border-slate-600 overflow-hidden">
                    <div id="progress-bar" class="bg-gradient-to-r from-indigo-500 to-emerald-400 h-full transition-all duration-700 ease-out rounded-full" style="width: 0%"></div>
                </div>
            </div>

            <p class="text-[11px] text-center text-slate-500 pt-1">
                Última actualización: <span id="updated_at" class="text-slate-400"></span>
            </p>
        </div>
    </div>

    <script>
        const STATUS_MAP = {
            'recibido': 1,
            'en_revision': 2,
            'en_proceso': 3,
            'finalizado': 4
        };

        const STATUS_LABELS = {
            'recibido': 'Recibido',
            'en_revision': 'En Revisión',
            'en_proceso': 'En Proceso',
            'finalizado': 'Finalizado'
        };

        function updateStepper(status) {
            const currentStep = STATUS_MAP[status] || 0;
            const percentage = ((currentStep - 1) / 3) * 100;

            // Update progress line
            document.getElementById('stepper-line').style.width = percentage + '%';

            // Update each step
            for (let i = 1; i <= 4; i++) {
                const step = document.getElementById(`step-${i}`);
                if (i <= currentStep) {
                    step.className = 'w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center border-2 border-slate-800 transition-all duration-500 shadow-lg shadow-indigo-500/30';
                    step.querySelector('i').className = step.querySelector('i').className.replace('text-slate-400', 'text-white');
                } else {
                    step.className = 'w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center border-2 border-slate-800 transition-all duration-500';
                    step.querySelector('i').className = step.querySelector('i').className.replace('text-white', 'text-slate-400');
                }
            }
        }

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
                        document.getElementById('status').textContent = STATUS_LABELS[data.status] ?? data.status;
                        
                        updateStepper(data.status);

                        let progressValue = data.current_progress ?? data.progress ?? '0%';
                        if (typeof progressValue === 'number' || !String(progressValue).includes('%')) {
                            progressValue = `${progressValue}%`;
                        }

                        document.getElementById('progress-bar').style.width = progressValue;
                        document.getElementById('progress-text').textContent = progressValue;
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

            fetchStatus();
            setInterval(fetchStatus, 5000);
        });
    </script>
</body>
</html>
