<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-white mb-1">Bienvenido de vuelta</h2>
        <p class="text-sm text-slate-400">Ingresa tus credenciales para acceder al taller</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-envelope text-slate-500 text-sm"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="tu@email.com"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
            <x-dark.input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-500 text-sm"></i>
                </div>
                <input type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
            <x-dark.input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-600 bg-slate-800 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-0">
                <span class="text-sm text-slate-400">Recordarme</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-500/30 flex items-center justify-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i> Ingresar
        </button>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-700/50"></div></div>
            <div class="relative flex justify-center text-xs"><span class="bg-slate-900 px-3 text-slate-500">o</span></div>
        </div>

        <p class="text-center text-sm text-slate-400">
            ¿No tienes cuenta?
            <a class="text-indigo-400 hover:text-indigo-300 font-semibold transition" href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </form>
</x-guest-layout>
