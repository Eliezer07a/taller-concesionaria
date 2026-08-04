<x-guest-layout>
    <div class="mb-4 text-sm text-slate-400">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Indícanos tu correo y te enviaremos un enlace para restablecerla.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-emerald-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-dark.input-label for="email" :value="__('Email')" />
            <x-dark.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-dark.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-dark.primary-button>
                {{ __('Enviar enlace de restablecimiento') }}
            </x-dark.primary-button>
        </div>
    </form>
</x-guest-layout>
