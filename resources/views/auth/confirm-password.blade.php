<x-guest-layout>
    <div class="mb-4 text-sm text-slate-400">
        {{ __('Esta es una zona segura de la aplicación. Confirma tu contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-dark.input-label for="password" :value="__('Contraseña')" />

            <x-dark.text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

            <x-dark.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-dark.primary-button>
                {{ __('Confirmar') }}
            </x-dark.primary-button>
        </div>
    </form>
</x-guest-layout>
