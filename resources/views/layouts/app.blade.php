<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="aura">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="drawer lg:drawer-open">
            <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />

            <div class="drawer-content flex flex-col">
                <livewire:layout.navigation />
                <main class="flex-1 p-4 sm:p-6">
                    {{ $slot }}
                </main>
            </div>

            <div class="drawer-side z-40">
                <label for="sidebar-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <livewire:layout.sidebar />
            </div>
        </div>
    </body>
</html>
