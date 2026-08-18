<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-400"></i> Editar Vehículo
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800/50 rounded-2xl p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-300 rounded-2xl bg-red-500/10 border border-red-500/20 backdrop-blur-xl">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Propietario del Auto</label>
                        <select name="user_id" required class="block w-full rounded-xl border border-slate-700/50 bg-slate-800/60 backdrop-blur text-white text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                            @foreach(\App\Models\User::where('role', 'propietario')->get() as $client)
                                <option value="{{ $client->id }}" {{ old('user_id', $vehicle->user_id) == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Año</label>
                        <input type="number" name="year" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('year', $vehicle->year) }}" required
                               class="block w-full rounded-xl border border-slate-700/50 bg-slate-800/60 backdrop-blur text-white text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Patente</label>
                        <input type="text" name="plate" maxlength="10" value="{{ old('plate', $vehicle->plate) }}" required
                               class="block w-full rounded-xl border border-slate-700/50 bg-slate-800/60 backdrop-blur text-white text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Marca</label>
                        <input type="text" name="brand" maxlength="50" value="{{ old('brand', $vehicle->brand) }}" required
                               class="block w-full rounded-xl border border-slate-700/50 bg-slate-800/60 backdrop-blur text-white text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Modelo</label>
                        <input type="text" name="model" maxlength="50" value="{{ old('model', $vehicle->model) }}" required
                               class="block w-full rounded-xl border border-slate-700/50 bg-slate-800/60 backdrop-blur text-white text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                    </div>

                    <div class="md:col-span-2 flex justify-between mt-4">
                        <a href="{{ route('vehicles.index') }}"
                           class="px-4 py-2 bg-slate-800/60 backdrop-blur border border-slate-700/50 text-slate-400 rounded-xl hover:bg-slate-700/60 hover:text-white transition-all duration-300 font-bold text-sm">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-5 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-500/20 text-sm">
                            <i class="fa-solid fa-save mr-1"></i> Actualizar Vehículo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
