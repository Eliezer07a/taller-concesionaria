<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">
            <i class="fa-solid fa-user-plus mr-2 text-indigo-400"></i> Crear Cuenta
        </h2>
        <p class="text-xs text-slate-400 mt-1">Regístrate para dar seguimiento a tus reparaciones</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-dark.input-label for="name" :value="__('Nombre')" />
            <x-dark.text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-dark.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-dark.input-label for="email" :value="__('Email')" />
            <x-dark.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-dark.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div>
            <x-dark.input-label for="role" :value="__('Soy')" />
            <select id="role" name="role" required class="block mt-1 w-full rounded-lg border-slate-600 bg-slate-900 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="propietario" {{ old('role') == 'propietario' ? 'selected' : '' }}>Propietario del Auto</option>
                <option value="mecanico" {{ old('role') == 'mecanico' ? 'selected' : '' }}>Mecánico / Asesor</option>
            </select>
            <x-dark.input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-dark.input-label for="password" :value="__('Contraseña')" />
            <x-dark.text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-dark.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-dark.input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-dark.text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-dark.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-dark.primary-button class="w-full">
            <i class="fa-solid fa-user-plus mr-2"></i> {{ __('Registrarme') }}
        </x-dark.primary-button>

        <p class="text-center text-sm text-slate-400 pt-2">
            ¿Ya tienes cuenta?
            <a class="text-indigo-400 hover:text-indigo-300 font-semibold" href="{{ route('login') }}">{{ __('Inicia sesión') }}</a>
        </p>
    </form>
</x-guest-layout>
