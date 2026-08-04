<x-guest-layout>
    <div class="mb-4 text-sm text-slate-400">
        {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu correo haciendo clic en el enlace que te enviamos? Si no lo recibiste, con gusto te enviaremos otro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-emerald-400">
            {{ __('Se ha enviado un nuevo enlace de verificación al correo que usaste durante el registro.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-dark.primary-button>
                    {{ __('Reenviar correo de verificación') }}
                </x-dark.primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-slate-400 hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-indigo-500">
                {{ __('Cerrar sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
