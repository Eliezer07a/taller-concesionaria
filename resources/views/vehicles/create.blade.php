<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-400"></i> Registrar Nuevo Vehículo
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-slate-800 border border-slate-700 rounded-xl">

                @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-300 rounded-xl bg-red-500/10 border border-red-500/20">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('vehicles.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Propietario del Auto</label>
                        <select name="user_id" required class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccionar propietario...</option>
                            @foreach(\App\Models\User::where('role', 'propietario')->get() as $client)
                                <option value="{{ $client->id }}" {{ old('user_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Año</label>
                        <input type="number" name="year" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('year') }}" required placeholder="2024" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Patente</label>
                        <input type="text" name="plate" maxlength="10" value="{{ old('plate') }}" required placeholder="ABC-1234" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Marca</label>
                        <input type="text" name="brand" maxlength="50" value="{{ old('brand') }}" required placeholder="Toyota" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Modelo</label>
                        <input type="text" name="model" maxlength="50" value="{{ old('model') }}" required placeholder="Corolla" class="block w-full rounded-lg border-slate-600 bg-slate-900 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2 flex justify-between mt-4">
                        <a href="{{ route('vehicles.index') }}" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition font-bold text-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition text-sm">
                            <i class="fa-solid fa-save mr-1"></i> Guardar Vehículo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
