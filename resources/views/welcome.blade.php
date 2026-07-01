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

    <style>
        /* === Animations === */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-24px); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(2deg); }
        }
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.15; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.05); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(60px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-up-sm {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.85); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            14% { transform: scale(1.15); }
            28% { transform: scale(1); }
            42% { transform: scale(1.1); }
            56% { transform: scale(1); }
        }
        @keyframes progress-bar {
            from { width: 0%; }
            to { width: 100%; }
        }
        @keyframes bg-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 10s ease-in-out infinite; }
        .animate-float-delayed { animation: float 7s ease-in-out 2s infinite; }
        .animate-pulse-soft { animation: pulse-soft 5s ease-in-out infinite; }
        .animate-fade-in { animation: fade-in 1s ease-out forwards; }
        .animate-scale-in { animation: scale-in 0.7s ease-out forwards; }
        .animate-heartbeat { animation: heartbeat 2s ease-in-out infinite; }

        .animate-slide-up { animation: slide-up 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-up-sm { animation: slide-up-sm 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .reveal { opacity: 0; }
        .reveal.visible { animation: slide-up 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .reveal-left { opacity: 0; }
        .reveal-left.visible { animation: slide-left 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .reveal-scale { opacity: 0; }
        .reveal-scale.visible { animation: scale-in 0.7s ease-out forwards; }

        /* === Medical SVG Pattern === */
        .medical-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232A8473' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .medical-pattern-light {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232A8473' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* === Gradient Mesh === */
        .mesh-gradient {
            background:
                radial-gradient(ellipse 80% 60% at 0% 20%, rgba(42,132,115,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 100% 40%, rgba(30,107,94,0.1) 0%, transparent 50%),
                radial-gradient(ellipse 70% 40% at 50% 80%, rgba(42,132,115,0.06) 0%, transparent 50%);
        }

        /* === Custom Scrollbar === */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #2A8473; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #1E6B5E; }

        /* === Smooth Scroll === */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased" x-data="{ scrolled: 0 }" @scroll.window="scrolled = window.scrollY">
    {{-- DECORATIVE LAYER --}}
    <div class="fixed inset-0 -z-20 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 medical-pattern"></div>
        <div class="absolute top-1/4 left-1/6 w-96 h-96 rounded-full bg-primary/5 blur-[120px]"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 rounded-full bg-primary-100/30 blur-[100px]"></div>
        <div class="absolute top-2/3 left-1/3 w-64 h-64 rounded-full bg-primary/5 blur-[80px]"></div>
    </div>

    {{-- NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
            :class="scrolled > 80 ? 'bg-white/90 backdrop-blur-xl border-b border-primary-100/40 shadow-sm' : 'bg-transparent'">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-white font-bold shadow-lg shadow-primary/25 transition group-hover:shadow-primary/40 group-hover:scale-105">
                    S
                </div>
                <span class="text-lg font-bold transition"
                      :class="scrolled > 80 ? 'text-gray-900' : 'text-white'">SIMRS</span>
            </a>
            @if (Route::has('login'))
                <div :class="scrolled > 80 ? '' : 'lg:[&_a]:text-white [&_.btn-outline]:border-white/40 [&_.btn-outline]:text-white/90'">
                    <livewire:welcome.navigation />
                </div>
            @endif
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        {{-- Background Layers --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-primary-700 to-gray-900"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent"></div>
            <div class="absolute inset-0 medical-pattern opacity-20"></div>

            {{-- Animated Gradient Orbs --}}
            <div class="absolute top-20 -left-20 w-[500px] h-[500px] rounded-full bg-primary/20 blur-[150px] animate-pulse-soft"></div>
            <div class="absolute bottom-20 -right-20 w-[400px] h-[400px] rounded-full bg-teal-400/15 blur-[120px] animate-float-slow"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-primary/10 blur-[180px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full relative z-10 pt-32 pb-20">
            <div class="mx-auto max-w-4xl text-center">

                {{-- Badge --}}
                <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/90 backdrop-blur-sm animate-fade-in">
                    <span class="flex h-2 w-2 rounded-full bg-green-400 animate-heartbeat"></span>
                    Platform Manajemen Rumah Sakit Modern
                </div>

                {{-- Headline --}}
                <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl leading-tight">
                    <span class="inline-block animate-slide-up">Kelola Rumah Sakit</span>
                    <br>
                    <span class="inline-block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-teal-200 via-white to-teal-100 animate-slide-up">
                        Lebih Efisien
                    </span>
                </h1>

                {{-- Subtitle --}}
                <p class="mt-6 text-lg leading-relaxed text-primary-100/80 sm:text-xl max-w-2xl mx-auto animate-slide-up">
                    SIMRS menghubungkan seluruh alur kerja rumah sakit — dari pendaftaran pasien,
                    rekam medis elektronik, resep obat, hingga pembayaran — dalam satu platform terintegrasi.
                </p>

                {{-- CTA Buttons --}}
                <div class="mt-10 flex items-center justify-center gap-4 animate-slide-up">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="group relative inline-flex items-center gap-2.5 rounded-xl bg-white px-8 py-4 text-sm font-semibold text-primary shadow-2xl shadow-primary/30 transition-all hover:scale-105 hover:shadow-primary/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zm0 9.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zm0 9.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="group relative inline-flex items-center gap-2.5 rounded-xl bg-white px-8 py-4 text-sm font-semibold text-primary shadow-2xl shadow-primary/30 transition-all hover:scale-105 hover:shadow-primary/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            Masuk
                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('register') }}"
                           class="group inline-flex items-center gap-2.5 rounded-xl border-2 border-white/30 px-8 py-4 text-sm font-semibold text-white transition-all hover:border-white/60 hover:bg-white/10 hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary">
                            Daftar
                        </a>
                    @endauth
                </div>


            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-float">
            <div class="flex flex-col items-center gap-2 text-white/40 text-xs">
                <span>Scroll</span>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </div>
        </div>
    </section>

    {{-- FITUR --}}
    <section class="relative py-28 overflow-hidden" id="fitur"
             x-init="$el.querySelectorAll('.reveal, .reveal-scale').forEach(el => {
                 new IntersectionObserver(entries => {
                     entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible') });
                 }, { threshold: 0.15 }).observe(el);
             })">
        <div class="absolute inset-0 -z-10 mesh-gradient"></div>
        <div class="absolute inset-0 -z-10 medical-pattern-light"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="inline-block rounded-full bg-primary-50 px-4 py-1.5 text-xs font-semibold text-primary-700 mb-4">FITUR</span>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Modul Lengkap untuk Rumah Sakit
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Empat modul utama yang saling terintegrasi untuk mengoptimalkan seluruh operasional rumah sakit.
                </p>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Pendaftaran --}}
                <div class="group relative rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-2 reveal-scale"
                     style="animation-delay: 0.1s">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50/0 via-primary-50/0 to-primary-50/0 group-hover:from-primary-50/40 group-hover:via-primary-50/20 group-hover:to-primary-50/0 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-600 text-white shadow-lg shadow-primary/20 group-hover:shadow-primary/40 transition-all duration-500 group-hover:scale-110">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Pendaftaran</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Registrasi pasien baru & lama, pencarian NIK/No. RM,
                            pemilihan poli & dokter, serta nomor antrian otomatis.
                        </p>
                    </div>
                </div>

                {{-- RME --}}
                <div class="group relative rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-2 reveal-scale"
                     style="animation-delay: 0.2s">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50/0 via-primary-50/0 to-primary-50/0 group-hover:from-primary-50/40 group-hover:via-primary-50/20 group-hover:to-primary-50/0 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-600 text-white shadow-lg shadow-primary/20 group-hover:shadow-primary/40 transition-all duration-500 group-hover:scale-110">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">RME</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Rekam Medis Elektronik — pemeriksaan, diagnosis,
                            ICD-10, riwayat pasien, dan pembuatan e-resep terintegrasi.
                        </p>
                    </div>
                </div>

                {{-- Farmasi --}}
                <div class="group relative rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-2 reveal-scale"
                     style="animation-delay: 0.3s">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50/0 via-primary-50/0 to-primary-50/0 group-hover:from-primary-50/40 group-hover:via-primary-50/20 group-hover:to-primary-50/0 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-600 text-white shadow-lg shadow-primary/20 group-hover:shadow-primary/40 transition-all duration-500 group-hover:scale-110">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Farmasi</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Kelola resep masuk, siapkan obat, stok obat lengkap
                            dengan validasi otomatis dan pengurangan stok real-time.
                        </p>
                    </div>
                </div>

                {{-- Kasir --}}
                <div class="group relative rounded-2xl border border-gray-200 bg-white/70 backdrop-blur-sm p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-2 reveal-scale"
                     style="animation-delay: 0.4s">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50/0 via-primary-50/0 to-primary-50/0 group-hover:from-primary-50/40 group-hover:via-primary-50/20 group-hover:to-primary-50/0 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-600 text-white shadow-lg shadow-primary/20 group-hover:shadow-primary/40 transition-all duration-500 group-hover:scale-110">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">Kasir</h3>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Pembayaran pasien dengan invoice otomatis
                            (biaya konsultasi + obat), riwayat transaksi lengkap.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ALUR --}}
    <section class="relative py-28 overflow-hidden"
             x-init="$el.querySelectorAll('.reveal').forEach(el => {
                 new IntersectionObserver(entries => {
                     entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible') });
                 }, { threshold: 0.2 }).observe(el);
             })">
        {{-- Background Layer --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary to-primary-600"></div>
            <div class="absolute inset-0 medical-pattern opacity-10"></div>
            <div class="absolute top-10 -left-20 w-[400px] h-[400px] rounded-full bg-white/5 blur-[120px]"></div>
            <div class="absolute bottom-10 -right-20 w-[500px] h-[500px] rounded-full bg-primary-100/10 blur-[150px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mx-auto max-w-2xl text-center reveal">
                <span class="inline-block rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold text-white/90 mb-4 backdrop-blur-sm">ALUR KERJA</span>
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Alur Kerja Terintegrasi
                </h2>
                <p class="mt-4 text-lg text-primary-100/80">
                    Dari pendaftaran hingga pembayaran, semua terhubung dalam satu ekosistem.
                </p>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-4 relative">
                {{-- Connecting Line --}}
                <div class="absolute top-8 left-[12%] right-[12%] h-0.5 hidden sm:block">
                    <div class="h-full bg-gradient-to-r from-white/20 via-white/40 to-white/20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/60 animate-progress" style="animation: progress-bar 3s ease-in-out infinite; width: 0%;"></div>
                    </div>
                </div>

                <div class="relative text-center reveal" style="animation-delay: 0.1s">
                    <div class="mx-auto relative">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm text-white text-xl font-bold shadow-lg ring-1 ring-white/20 transition-all duration-500 hover:bg-white/25 hover:scale-110 hover:shadow-xl">
                            1
                        </div>
                        <div class="absolute -bottom-1 -right-1 h-5 w-5 rounded-full bg-green-400 ring-2 ring-primary-700 animate-heartbeat"></div>
                    </div>
                    <div class="mt-6 rounded-xl bg-white/10 backdrop-blur-sm p-4 ring-1 ring-white/10">
                        <h4 class="font-semibold text-white">Pendaftaran</h4>
                        <p class="mt-1 text-sm text-primary-200/80">Pasien mendaftar di front-office</p>
                    </div>
                </div>

                <div class="relative text-center reveal" style="animation-delay: 0.2s">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm text-white text-xl font-bold shadow-lg ring-1 ring-white/20 transition-all duration-500 hover:bg-white/25 hover:scale-110 hover:shadow-xl">
                        2
                    </div>
                    <div class="mt-6 rounded-xl bg-white/10 backdrop-blur-sm p-4 ring-1 ring-white/10">
                        <h4 class="font-semibold text-white">RME</h4>
                        <p class="mt-1 text-sm text-primary-200/80">Dokter melakukan pemeriksaan</p>
                    </div>
                </div>

                <div class="relative text-center reveal" style="animation-delay: 0.3s">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm text-white text-xl font-bold shadow-lg ring-1 ring-white/20 transition-all duration-500 hover:bg-white/25 hover:scale-110 hover:shadow-xl">
                        3
                    </div>
                    <div class="mt-6 rounded-xl bg-white/10 backdrop-blur-sm p-4 ring-1 ring-white/10">
                        <h4 class="font-semibold text-white">Farmasi</h4>
                        <p class="mt-1 text-sm text-primary-200/80">Obat disiapkan oleh farmasi</p>
                    </div>
                </div>

                <div class="relative text-center reveal" style="animation-delay: 0.4s">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm text-white text-xl font-bold shadow-lg ring-1 ring-white/20 transition-all duration-500 hover:bg-white/25 hover:scale-110 hover:shadow-xl">
                        4
                    </div>
                    <div class="mt-6 rounded-xl bg-white/10 backdrop-blur-sm p-4 ring-1 ring-white/10">
                        <h4 class="font-semibold text-white">Kasir</h4>
                        <p class="mt-1 text-sm text-primary-200/80">Pembayaran & penyelesaian</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 -z-10 mesh-gradient"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-3">
                <div class="group relative rounded-2xl border border-gray-200 bg-white/60 backdrop-blur-sm p-8 text-center transition-all duration-500 hover:shadow-lg hover:border-primary/20 hover:-translate-y-1">
                    <div class="text-4xl font-extrabold text-primary">100%</div>
                    <div class="mt-2 text-sm font-medium text-gray-600">Digital & Terintegrasi</div>
                    <div class="mt-4 h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary to-primary-300 transition-all duration-1000" style="width: 100%"></div>
                    </div>
                </div>
                <div class="group relative rounded-2xl border border-gray-200 bg-white/60 backdrop-blur-sm p-8 text-center transition-all duration-500 hover:shadow-lg hover:border-primary/20 hover:-translate-y-1">
                    <div class="text-4xl font-extrabold text-primary">24/7</div>
                    <div class="mt-2 text-sm font-medium text-gray-600">Akses Kapan Saja</div>
                    <div class="mt-4 h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary to-primary-300 transition-all duration-1000" style="width: 100%"></div>
                    </div>
                </div>
                <div class="group relative rounded-2xl border border-gray-200 bg-white/60 backdrop-blur-sm p-8 text-center transition-all duration-500 hover:shadow-lg hover:border-primary/20 hover:-translate-y-1">
                    <div class="text-4xl font-extrabold text-primary">Real-time</div>
                    <div class="mt-2 text-sm font-medium text-gray-600">Update Data Langsung</div>
                    <div class="mt-4 h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary to-primary-300 transition-all duration-1000" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative py-28 overflow-hidden"
             x-init="$el.querySelectorAll('.reveal').forEach(el => {
                 new IntersectionObserver(entries => {
                     entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible') });
                 }, { threshold: 0.2 }).observe(el);
             })">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary to-primary-600"></div>
            <div class="absolute inset-0 medical-pattern opacity-10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] rounded-full bg-white/5 blur-[180px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mx-auto max-w-3xl text-center reveal">
                <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    Siap Modernisasi Rumah Sakit Anda?
                </h2>
                <p class="mt-6 text-lg text-primary-100/80 sm:text-xl max-w-2xl mx-auto">
                    Mulai gunakan SIMRS sekarang dan rasakan kemudahan mengelola
                    seluruh operasional rumah sakit dalam satu platform.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="group relative inline-flex items-center gap-2.5 rounded-xl bg-white px-8 py-4 text-sm font-semibold text-primary shadow-2xl transition-all hover:scale-105 hover:shadow-white/30 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-primary-50 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="group relative inline-flex items-center gap-2.5 rounded-xl bg-white px-8 py-4 text-sm font-semibold text-primary shadow-2xl transition-all hover:scale-105 hover:shadow-white/30 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-primary-50 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            Daftar Sekarang
                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="relative border-t border-gray-200 bg-white/80 backdrop-blur-sm">
        <div class="absolute inset-0 -z-10 medical-pattern-light"></div>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-6 sm:flex-row">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-600 text-white text-sm font-bold shadow-md">
                        S
                    </div>
                    <span class="text-base font-semibold text-gray-700">SIMRS</span>
                </div>

                <div class="flex items-center gap-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 transition hover:text-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 transition hover:text-primary">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-500 transition hover:text-primary">Daftar</a>
                    @endauth
                </div>

                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SIMRS') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth reveal on scroll for any elements not caught by Alpine init
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal, .reveal-scale, .reveal-left').forEach(el => {
                if (!el.hasAttribute('x-init')) {
                    new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) entry.target.classList.add('visible');
                        });
                    }, { threshold: 0.15 }).observe(el);
                }
            });
        });
    </script>
</body>
</html>