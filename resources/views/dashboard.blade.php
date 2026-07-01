<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-8 py-6">
        <!-- Selamat Datang Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-linear-to-r from-blue-600 to-indigo-600 p-6 text-white shadow-lg">
            <div class="relative z-10 space-y-2">
                <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-md">
                    {{ now()->format('l, d F Y') }}
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>
                <p class="text-blue-100 max-w-xl text-sm">
                    Anda masuk sebagai <span class="font-bold underline decoration-indigo-300 decoration-2">{{ auth()->user()->roles->first()?->name ?? 'Pengguna' }}</span>. Berikut adalah ringkasan aktivitas dan pintasan tugas Anda hari ini.
                </p>
            </div>
            <!-- Decorative background elements -->
            <div class="absolute right-0 bottom-0 -mb-10 -mr-10 h-48 w-48 rounded-full bg-white/10 blur-xl"></div>
            <div class="absolute right-1/4 top-0 -mt-10 h-32 w-32 rounded-full bg-white/5 blur-lg"></div>
        </div>

        @role('admin_resepsionis')
            <!-- SECTION FOR RECEPTIONIST -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pasien Baru Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Patient::whereDate('created_at', today())->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Antrian Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Queue::whereDate('created_at', today())->whereIn('status', ['waiting', 'called'])->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Antrian Selesai Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Queue::whereDate('created_at', today())->where('status', 'done')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @endrole

        @role('dokter')
            <!-- SECTION FOR DOCTORS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat Card 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Antrian Saya (Belum Diperiksa)</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Queue::where('doctor_id', auth()->id())->whereDate('created_at', today())->whereIn('status', ['waiting', 'called'])->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pasien Selesai Diperiksa</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Queue::where('doctor_id', auth()->id())->whereDate('created_at', today())->where('status', 'done')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @endrole

        @role('farmasi')
            <!-- SECTION FOR PHARMACY -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Resep Menunggu Diproses</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Prescription::where('status', 'menunggu')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Resep Sedang Disiapkan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Prescription::where('status', 'disiapkan')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Stok Obat Menipis (< 10)</p>
                            <p class="text-2xl font-bold text-rose-600">{{ \App\Models\Medicine::where('stock', '<', 10)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @endrole

        @role('kasir')
            <!-- SECTION FOR CASHIER -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Antrian Billing (Siap Bayar)</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \App\Models\MedicalRecord::whereDoesntHave('invoices')->where(function($q){ $q->whereHas('prescriptions', fn($p) => $p->where('status', 'diserahkan'))->orWhereDoesntHave('prescriptions'); })->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Invoice Terbit Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Invoice::whereDate('created_at', today())->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format(\App\Models\Invoice::whereDate('created_at', today())->sum('total'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @endrole

        @role('super_admin')
            <!-- SECTION FOR SUPER ADMIN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pasien</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Patient::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Antrian Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Queue::whereDate('created_at', today())->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-teal-600 shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Master Obat</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Medicine::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @endrole
</div>
</x-app-layout>
