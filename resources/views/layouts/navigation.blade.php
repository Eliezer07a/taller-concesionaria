<div x-data="{ sidebarOpen: true, mobileOpen: false }" class="flex min-h-screen bg-slate-900">

    <!-- Sidebar Desktop -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="hidden lg:flex flex-col bg-slate-800 border-r border-slate-700 transition-all duration-300 ease-in-out fixed inset-y-0 left-0 z-30">
        <!-- Logo + Toggle -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-slate-700">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                <div class="bg-indigo-600 rounded-xl p-2 shrink-0">
                    <i class="fa-solid fa-car-side text-white text-lg"></i>
                </div>
                <span x-show="sidebarOpen" x-transition class="text-white font-bold whitespace-nowrap text-sm">{{ config('app.name', 'NavaMotor') }}</span>
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transition hidden lg:block">
                <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-sm"></i>
            </button>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 py-4 space-y-1 px-3 overflow-y-auto">
            @if(Auth::user()->role === 'mecanico')
                <a href="{{ route('vehicles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('vehicles.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-car text-base w-5 text-center shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition>Vehículos</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-gauge-high text-base w-5 text-center shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-gauge-high text-base w-5 text-center shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            @endif
        </nav>

        <!-- User Info -->
        <div class="border-t border-slate-700 p-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-indigo-400 font-semibold uppercase">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
            <div x-show="sidebarOpen" x-transition class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-700/50 transition">
                    <i class="fa-solid fa-user-gear"></i> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-700/50 transition w-full">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Sidebar Mobile Overlay -->
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 lg:hidden" @click="mobileOpen = false"></div>

    <!-- Sidebar Mobile -->
    <aside x-show="mobileOpen" x-transition:enter="transition transform duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 w-64 bg-slate-800 border-r border-slate-700 z-50 lg:hidden flex flex-col">
        <div class="flex items-center justify-between h-16 px-4 border-b border-slate-700">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="bg-indigo-600 rounded-xl p-2">
                    <i class="fa-solid fa-car-side text-white"></i>
                </div>
                <span class="text-white font-bold text-sm">{{ config('app.name', 'NavaMotor') }}</span>
            </a>
            <button @click="mobileOpen = false" class="text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <nav class="flex-1 py-4 space-y-1 px-3">
            @if(Auth::user()->role === 'mecanico')
                <a href="{{ route('vehicles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('vehicles.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-car w-5 text-center"></i> Vehículos
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
                </a>
            @endif
        </nav>

        <div class="border-t border-slate-700 p-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-indigo-400 font-semibold uppercase">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-700/50 transition">
                    <i class="fa-solid fa-user-gear"></i> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-700/50 transition w-full">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">
        <!-- Top Bar -->
        <header class="bg-slate-800 border-b border-slate-700 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <!-- Mobile hamburger -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                @isset($header)
                    {{ $header }}
                @endisset
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center gap-1.5 text-xs bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded-full font-semibold border border-indigo-500/20">
                    <i class="fa-solid fa-shield-halved text-[10px]"></i> {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>
