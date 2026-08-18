<div x-data="{ sidebarOpen: true, mobileOpen: false }" class="flex min-h-screen">

    <!-- Sidebar Desktop -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="hidden lg:flex flex-col bg-slate-900/95 backdrop-blur-xl border-r border-slate-800/80 transition-all duration-300 ease-in-out fixed inset-y-0 left-0 z-30">
        <div class="flex items-center justify-between h-16 px-4 border-b border-slate-800/80">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl p-2 shadow-lg shadow-indigo-500/20 shrink-0">
                    <i class="fa-solid fa-car-side text-white text-lg"></i>
                </div>
                <span x-show="sidebarOpen" x-transition class="text-white font-extrabold whitespace-nowrap text-sm tracking-tight">NavaMotor</span>
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-white transition hidden lg:block p-1.5 rounded-lg hover:bg-slate-800">
                <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-xs"></i>
            </button>
        </div>

        <nav class="flex-1 py-4 space-y-1 px-3 overflow-y-auto">
            <p x-show="sidebarOpen" x-transition class="text-[10px] font-bold text-slate-600 uppercase tracking-widest px-3 mb-2">Menu</p>

            @if(Auth::user()->role === 'mecanico')
                <a href="{{ route('vehicles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('vehicles.*') ? 'bg-indigo-500/15 text-indigo-400 shadow-sm shadow-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('vehicles.*') ? 'bg-indigo-500/20' : 'bg-slate-800/60' }} flex items-center justify-center shrink-0 transition">
                        <i class="fa-solid fa-car text-xs {{ request()->routeIs('vehicles.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition>Vehiculos</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-500/15 text-indigo-400 shadow-sm shadow-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-500/20' : 'bg-slate-800/60' }} flex items-center justify-center shrink-0 transition">
                        <i class="fa-solid fa-gauge-high text-xs {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-500/15 text-indigo-400 shadow-sm shadow-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-500/20' : 'bg-slate-800/60' }} flex items-center justify-center shrink-0 transition">
                        <i class="fa-solid fa-gauge-high text-xs {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            @endif
        </nav>

        <div class="border-t border-slate-800/80 p-3">
            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/60 transition cursor-pointer" @click="$refs.userMenu.classList.toggle('hidden')">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-lg shadow-indigo-500/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="overflow-hidden flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-indigo-400 font-semibold uppercase tracking-wider">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <i x-show="sidebarOpen" class="fa-solid fa-ellipsis-vertical text-slate-600 text-xs"></i>
            </div>
            <div x-ref="userMenu" x-show="sidebarOpen" class="hidden mt-2 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-user-gear w-4 text-center"></i> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-800/60 transition w-full">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Cerrar Sesion
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Sidebar Mobile Overlay -->
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" @click="mobileOpen = false"></div>

    <!-- Sidebar Mobile -->
    <aside x-show="mobileOpen" x-transition:enter="transition transform duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 w-72 bg-slate-900/98 backdrop-blur-xl border-r border-slate-800/80 z-50 lg:hidden flex flex-col shadow-2xl">
        <div class="flex items-center justify-between h-16 px-4 border-b border-slate-800/80">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl p-2 shadow-lg shadow-indigo-500/20">
                    <i class="fa-solid fa-car-side text-white"></i>
                </div>
                <span class="text-white font-extrabold text-sm">NavaMotor</span>
            </a>
            <button @click="mobileOpen = false" class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <nav class="flex-1 py-4 space-y-1 px-3">
            @if(Auth::user()->role === 'mecanico')
                <a href="{{ route('vehicles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('vehicles.*') ? 'bg-indigo-500/15 text-indigo-400' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-car w-5 text-center"></i> Vehiculos
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-500/15 text-indigo-400' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-500/15 text-indigo-400' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
                </a>
            @endif
        </nav>

        <div class="border-t border-slate-800/80 p-3">
            <div class="flex items-center gap-3 p-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-indigo-400 font-semibold uppercase">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
            <div class="mt-2 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-user-gear w-4 text-center"></i> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-800/60 transition w-full">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Cerrar Sesion
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">
        <!-- Top Bar -->
        <header class="bg-slate-900/80 backdrop-blur-xl border-b border-slate-800/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                @isset($header)
                    {{ $header }}
                @endisset
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] bg-indigo-500/10 text-indigo-400 px-3 py-1.5 rounded-full font-semibold border border-indigo-500/20">
                    <i class="fa-solid fa-shield-halved text-[9px]"></i> {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>
