<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-car mr-2 text-indigo-500"></i> Registrar Nuevo Vehículo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Propietario del Auto</label>
                        <select name="user_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                            <option value="">Seleccionar propietario...</option>
                            @foreach(\App\Models\User::where('role', 'propietario')->get() as $client)
                                <option value="{{ $client->id }}" {{ old('user_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Año</label>
                        <input type="number" name="year" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('year') }}" required placeholder="2024" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Patente</label>
                        <input type="text" name="plate" maxlength="10" value="{{ old('plate') }}" required placeholder="ABC-1234" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">VIN</label>
                        <input type="text" name="vin" maxlength="17" value="{{ old('vin') }}" required placeholder="17 caracteres" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                        <input type="text" name="brand" maxlength="50" value="{{ old('brand') }}" required placeholder="Toyota" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modelo</label>
                        <input type="text" name="model" maxlength="50" value="{{ old('model') }}" required placeholder="Corolla" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div class="md:col-span-2 flex justify-between mt-4">
                        <a href="{{ route('vehicles.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition font-bold">
                            Cancelar
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                            <i class="fa-solid fa-save mr-1"></i> Guardar Vehículo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
