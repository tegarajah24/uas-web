<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            <aside class="fixed inset-y-0 left-0 z-40 w-64 flex-col bg-sidebar text-white transform transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

                <livewire:layout.sidebar />
            </aside>

            <div class="flex-1 flex flex-col min-w-0">
                <livewire:layout.navigation />

                <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-auto">
                    {{ $slot }}
                </main>
            </div>


            <div x-show="sidebarOpen"
                 class="fixed inset-0 z-30 bg-black/50 lg:hidden"
                 @click="sidebarOpen = false"
                 style="display: none;">
            </div>
        </div>
    </body>
</html>
