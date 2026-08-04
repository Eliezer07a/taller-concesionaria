<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">
            <i class="fa-solid fa-right-to-bracket mr-2 text-indigo-400"></i> Iniciar Sesión
        </h2>
        <p class="text-xs text-slate-400 mt-1">Accede al taller para gestionar reparaciones</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-dark.input-label for="email" :value="__('Email')" />
            <x-dark.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-dark.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-dark.input-label for="password" :value="__('Password')" />
            <x-dark.text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-dark.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-600 bg-slate-900 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-slate-400">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 font-medium" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <x-dark.primary-button class="w-full">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> {{ __('Ingresar') }}
        </x-dark.primary-button>

        <p class="text-center text-sm text-slate-400 pt-2">
            ¿No tienes cuenta?
            <a class="text-indigo-400 hover:text-indigo-300 font-semibold" href="{{ route('register') }}">{{ __('Regístrate aquí') }}</a>
        </p>
    </form>
</x-guest-layout>
