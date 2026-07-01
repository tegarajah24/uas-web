<div class="flex flex-col h-full bg-white border-r border-gray-200">
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" wire:navigate class="text-xl font-bold text-gray-900 tracking-tight">
            SIMRS
        </a>
        <span class="text-xs text-gray-400">v1.0</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <a href="{{ route('dashboard') }}" wire:navigate
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        @auth
            @hasanyrole('admin_resepsionis|super_admin')
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Front-Office</p>
                </div>
                <a href="{{ route('front-office.register') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('front-office.register') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Pendaftaran
                </a>
                <a href="{{ route('front-office.queue') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('front-office.queue') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Antrian
                </a>
            @endrole

            @hasanyrole('dokter|super_admin')
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">RME</p>
                </div>
                <a href="{{ route('rme.dashboard') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('rme.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pemeriksaan
                </a>
            @endrole

            @hasanyrole('farmasi|super_admin')
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Farmasi</p>
                </div>
                <a href="{{ route('farmasi.prescriptions') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('farmasi.prescriptions') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Resep Masuk
                </a>
                <a href="{{ route('farmasi.stock') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('farmasi.stock') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Stok Obat
                </a>
            @endrole

            @hasanyrole('kasir|super_admin')
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Kasir</p>
                </div>
                <a href="{{ route('kasir.billing') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('kasir.billing') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pembayaran
                </a>
                <a href="{{ route('kasir.history') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('kasir.history') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Riwayat
                </a>
            @endrole

            @role('super_admin')
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Super Admin</p>
                </div>
                <a href="{{ route('admin.users') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                          {{ request()->routeIs('admin.users') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kelola Pengguna
                </a>
            @endrole
        @endauth
    </nav>

    @auth
        <div class="border-t border-gray-200 px-4 py-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-primary text-white text-sm font-bold shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->roles->first()?->name ?? 'User' }}</p>
                </div>
            </div>
        </div>
    @endauth
</div>
