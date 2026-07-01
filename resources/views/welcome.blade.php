<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMRS') }} — Sistem Informasi Manajemen Rumah Sakit</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-surface">

        {{-- NAVBAR --}}
        <header class="fixed inset-x-0 top-0 z-50 border-b border-primary-100/60 bg-white/80 backdrop-blur-lg">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white text-sm font-bold shadow-sm">
                        S
                    </div>
                    <span class="text-lg font-bold text-gray-900">SIMRS</span>
                </a>
                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </div>
        </header>

        {{-- HERO --}}
        <section class="relative overflow-hidden pt-28 pb-20 sm:pt-36 sm:pb-28">
            <div class="absolute inset-0 -z-10">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50/80 via-white to-primary-50/40"></div>
                <div class="absolute top-0 right-0 -mr-40 -mt-40 h-96 w-96 rounded-full bg-primary-100/40 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-40 -ml-40 h-80 w-80 rounded-full bg-primary-100/30 blur-3xl"></div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <div class="mb-6 inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-4 py-1.5 text-xs font-semibold text-primary-700">
                        <span class="flex h-2 w-2 rounded-full bg-primary"></span>
                        Platform Manajemen Rumah Sakit Modern
                    </div>

                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                        Kelola Rumah Sakit
                        <span class="text-primary">Lebih Efisien</span>
                    </h1>

                    <p class="mt-6 text-lg leading-relaxed text-gray-600 sm:text-xl">
                        SIMRS menghubungkan seluruh alur kerja rumah sakit — dari pendaftaran pasien, 
                        rekam medis elektronik, resep obat, hingga pembayaran — dalam satu platform terintegrasi.
                    </p>

                    <div class="mt-10 flex items-center justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zm0 9.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zm0 9.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                                Masuk
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-7 py-3.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        {{-- FITUR --}}
        <section class="py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Modul Lengkap untuk Rumah Sakit
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Empat modul utama yang saling terintegrasi untuk mengoptimalkan seluruh operasional rumah sakit.
                    </p>
                </div>

                <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    {{-- Pendaftaran --}}
                    <div class="group rounded-2xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-primary-100">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary group-hover:bg-primary group-hover:text-white transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Pendaftaran</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Registrasi pasien baru & lama, pencarian NIK/No. RM, 
                            pemilihan poli & dokter, serta nomor antrian otomatis.
                        </p>
                    </div>

                    {{-- RME --}}
                    <div class="group rounded-2xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-primary-100">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary group-hover:bg-primary group-hover:text-white transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">RME</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Rekam Medis Elektronik — pemeriksaan, diagnosis, 
                            ICD-10, riwayat pasien, dan pembuatan e-resep terintegrasi.
                        </p>
                    </div>

                    {{-- Farmasi --}}
                    <div class="group rounded-2xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-primary-100">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary group-hover:bg-primary group-hover:text-white transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Farmasi</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Kelola resep masuk, siapkan obat, stok obat lengkap 
                            dengan validasi otomatis dan pengurangan stok real-time.
                        </p>
                    </div>

                    {{-- Kasir --}}
                    <div class="group rounded-2xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-primary-100">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary group-hover:bg-primary group-hover:text-white transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Kasir</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Pembayaran pasien dengan invoice otomatis 
                            (biaya konsultasi + obat), riwayat transaksi lengkap.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ALUR --}}
        <section class="bg-primary-50/60 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Alur Kerja Terintegrasi
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Dari pendaftaran hingga pembayaran, semua terhubung dalam satu ekosistem.
                    </p>
                </div>

                <div class="mt-16 grid gap-6 sm:grid-cols-4">
                    <div class="relative text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary text-white text-lg font-bold shadow-lg shadow-primary/20">
                            1
                        </div>
                        <h4 class="mt-4 font-semibold text-gray-900">Pendaftaran</h4>
                        <p class="mt-1 text-sm text-gray-600">Pasien mendaftar di front-office</p>
                    </div>

                    <div class="relative text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary text-white text-lg font-bold shadow-lg shadow-primary/20">
                            2
                        </div>
                        <h4 class="mt-4 font-semibold text-gray-900">RME</h4>
                        <p class="mt-1 text-sm text-gray-600">Dokter melakukan pemeriksaan</p>
                    </div>

                    <div class="relative text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary text-white text-lg font-bold shadow-lg shadow-primary/20">
                            3
                        </div>
                        <h4 class="mt-4 font-semibold text-gray-900">Farmasi</h4>
                        <p class="mt-1 text-sm text-gray-600">Obat disiapkan oleh farmasi</p>
                    </div>

                    <div class="relative text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary text-white text-lg font-bold shadow-lg shadow-primary/20">
                            4
                        </div>
                        <h4 class="mt-4 font-semibold text-gray-900">Kasir</h4>
                        <p class="mt-1 text-sm text-gray-600">Pembayaran & penyelesaian</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-3xl bg-primary px-8 py-16 shadow-xl sm:px-16">
                    <div class="absolute inset-0 -z-10">
                        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                    </div>
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            Siap Modernisasi Rumah Sakit Anda?
                        </h2>
                        <p class="mt-4 text-lg text-primary-100">
                            Mulai gunakan SIMRS sekarang dan rasakan kemudahan mengelola 
                            seluruh operasional rumah sakit dalam satu platform.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-white px-7 py-3.5 text-sm font-semibold text-primary shadow-lg transition hover:bg-primary-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary">
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-white px-7 py-3.5 text-sm font-semibold text-primary shadow-lg transition hover:bg-primary-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary">
                                    Daftar Sekarang
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="border-t border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white text-xs font-bold shadow-sm">
                            S
                        </div>
                        <span class="text-sm font-semibold text-gray-700">SIMRS</span>
                    </div>

                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'SIMRS') }}. All rights reserved.
                    </p>

                    <div class="flex items-center gap-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 transition hover:text-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-500 transition hover:text-primary">Masuk</a>
                            <a href="{{ route('register') }}" class="text-sm text-gray-500 transition hover:text-primary">Daftar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>