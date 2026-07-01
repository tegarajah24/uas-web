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
    <div class="flex min-h-screen flex-col lg:flex-row">

        {{-- LEFT PANEL — 70% --}}
        <div class="relative flex min-h-[40vh] w-full flex-col justify-between overflow-hidden bg-gradient-to-br from-primary via-primary-700 to-primary-hover p-8 sm:p-12 lg:min-h-screen lg:w-[70%]">
            <div class="absolute inset-0 -z-10">
                <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
            </div>

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-lg font-bold text-white shadow-sm backdrop-blur-sm">
                    S
                </div>
                <span class="text-xl font-bold text-white">SIMRS</span>
            </div>

            {{-- Center Content --}}
            <div class="mx-auto max-w-lg">
                <div class="mb-6 flex justify-center">
                    <svg class="h-24 w-24 text-white/80" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6"/>
                    </svg>
                </div>

                <h1 class="text-center text-3xl font-extrabold text-white sm:text-4xl">
                    Sistem Informasi<br>Manajemen Rumah Sakit
                </h1>

                <p class="mt-4 text-center text-base leading-relaxed text-primary-100">
                    Platform terintegrasi yang menghubungkan seluruh alur kerja rumah sakit 
                    — dari pendaftaran pasien, rekam medis elektronik, resep obat, 
                    hingga pembayaran — dalam satu ekosistem digital yang efisien dan modern.
                </p>

                <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-3 text-center backdrop-blur-sm">
                        <div class="text-lg font-bold text-white">01</div>
                        <div class="text-xs font-medium text-primary-100">Pendaftaran</div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-3 text-center backdrop-blur-sm">
                        <div class="text-lg font-bold text-white">02</div>
                        <div class="text-xs font-medium text-primary-100">RME</div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-3 text-center backdrop-blur-sm">
                        <div class="text-lg font-bold text-white">03</div>
                        <div class="text-xs font-medium text-primary-100">Farmasi</div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-3 text-center backdrop-blur-sm">
                        <div class="text-lg font-bold text-white">04</div>
                        <div class="text-xs font-medium text-primary-100">Kasir</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <p class="text-center text-sm text-primary-200">
                &copy; {{ date('Y') }} SIMRS. All rights reserved.
            </p>
        </div>

        {{-- RIGHT PANEL — 30% --}}
        <div class="flex w-full items-center justify-center bg-white px-6 py-12 lg:w-[30%] lg:px-10">
            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>