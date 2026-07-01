<nav class="flex items-center gap-3">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="inline-flex items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:text-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
        >
            Masuk
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
            >
                Daftar
            </a>
        @endif
    @endauth
</nav>
