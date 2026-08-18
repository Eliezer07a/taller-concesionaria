<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-white mb-1">Crear cuenta</h2>
        <p class="text-sm text-slate-400">Regístrate para dar seguimiento a tus reparaciones</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Nombre completo</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-user text-slate-500 text-sm"></i>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Tu nombre"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
            <x-dark.input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-envelope text-slate-500 text-sm"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="tu@email.com"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
            <x-dark.input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">¿Quién eres?</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-id-badge text-slate-500 text-sm"></i>
                </div>
                <select name="role" required class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition appearance-none">
                    <option value="propietario" {{ old('role') == 'propietario' ? 'selected' : '' }}>Propietario del Auto</option>
                    <option value="mecanico" {{ old('role') == 'mecanico' ? 'selected' : '' }}>Mecánico / Asesor</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-slate-500 text-xs"></i>
                </div>
            </div>
            <x-dark.input-error :messages="$errors->get('role')" class="mt-1.5" />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-500 text-sm"></i>
                </div>
                <input type="password" name="password" required autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
            <x-dark.input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Confirmar contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-500 text-sm"></i>
                </div>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repite tu contraseña"
                       class="block w-full pl-10 pr-4 py-3 rounded-xl border-slate-700 bg-slate-800/80 border text-white text-sm placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 transition">
            </div>
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-500/30 flex items-center justify-center gap-2 mt-6">
            <i class="fa-solid fa-user-plus"></i> Crear Mi Cuenta
        </button>

        <div class="relative my-5">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-700/50"></div></div>
            <div class="relative flex justify-center text-xs"><span class="bg-slate-900 px-3 text-slate-500">o</span></div>
        </div>

        <p class="text-center text-sm text-slate-400">
            ¿Ya tienes cuenta?
            <a class="text-indigo-400 hover:text-indigo-300 font-semibold transition" href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </form>
</x-guest-layout>
