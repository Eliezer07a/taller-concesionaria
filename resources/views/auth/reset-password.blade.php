<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">
            <i class="fa-solid fa-lock mr-2 text-indigo-400"></i> Restablecer Contraseña
        </h2>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-dark.input-label for="email" :value="__('Email')" />
            <x-dark.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-dark.input-error :messages="$errors->get('email')" class="mt-2" />
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
            <x-dark.text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-dark.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-dark.primary-button>
                {{ __('Restablecer contraseña') }}
            </x-dark.primary-button>
        </div>
    </form>
</x-guest-layout>
