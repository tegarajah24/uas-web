<div class="flex flex-col min-h-full w-64 bg-base-200 text-base-content">
    <div class="p-4 border-b border-base-300">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight" wire:navigate>
            SIMRS
        </a>
        <p class="text-xs text-base-content/60 mt-1">Sistem Informasi RS</p>
    </div>

    <ul class="menu p-2 gap-1 flex-1">
        <li>
            <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                <span class="text-lg">📊</span>
                Dashboard
            </a>
        </li>

        @auth
            @role('admin_resepsionis')
                <li class="menu-title mt-2"><span>Front-Office</span></li>
                <li>
                    <a href="{{ route('front-office.register') }}" wire:navigate class="{{ request()->routeIs('front-office.register') ? 'menu-active' : '' }}">
                        <span class="text-lg">📝</span>
                        Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('front-office.queue') }}" wire:navigate class="{{ request()->routeIs('front-office.queue') ? 'menu-active' : '' }}">
                        <span class="text-lg">🔄</span>
                        Antrian
                    </a>
                </li>
            @endrole

            @role('dokter')
                <li class="menu-title mt-2"><span>RME</span></li>
                <li>
                    <a href="{{ route('rme.dashboard') }}" wire:navigate class="{{ request()->routeIs('rme.*') ? 'menu-active' : '' }}">
                        <span class="text-lg">🩺</span>
                        Pemeriksaan
                    </a>
                </li>
            @endrole

            @role('farmasi')
                <li class="menu-title mt-2"><span>Farmasi</span></li>
                <li>
                    <a href="{{ route('farmasi.prescriptions') }}" wire:navigate class="{{ request()->routeIs('farmasi.prescriptions') ? 'menu-active' : '' }}">
                        <span class="text-lg">💊</span>
                        Resep Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('farmasi.stock') }}" wire:navigate class="{{ request()->routeIs('farmasi.stock') ? 'menu-active' : '' }}">
                        <span class="text-lg">📦</span>
                        Stok Obat
                    </a>
                </li>
            @endrole

            @role('kasir')
                <li class="menu-title mt-2"><span>Kasir</span></li>
                <li>
                    <a href="{{ route('kasir.billing') }}" wire:navigate class="{{ request()->routeIs('kasir.billing') ? 'menu-active' : '' }}">
                        <span class="text-lg">💰</span>
                        Pembayaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.history') }}" wire:navigate class="{{ request()->routeIs('kasir.history') ? 'menu-active' : '' }}">
                        <span class="text-lg">📋</span>
                        Riwayat
                    </a>
                </li>
            @endrole
        @endauth
    </ul>

    <div class="p-4 border-t border-base-300">
        @auth
            <div class="flex items-center gap-3">
                <div class="bg-primary text-primary-content rounded-full w-10 h-10 flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="text-sm leading-tight">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-base-content/60">{{ auth()->user()->roles->first()?->name ?? 'User' }}</p>
                </div>
            </div>
        @endauth
    </div>
</div>
