<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="navbar bg-base-100 border-b border-base-200 px-4">
    <div class="navbar-start">
        <label for="sidebar-drawer" class="btn btn-ghost btn-circle drawer-button lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
        <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight" wire:navigate>
            SIMRS
        </a>
    </div>

    <div class="navbar-end">
        @auth
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-10">
                        <span class="text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-50 w-52 p-2 shadow">
                    <li><a href="{{ route('profile') }}" wire:navigate>Profil</a></li>
                    <li><button wire:click="logout">Logout</button></li>
                </ul>
            </div>
        @endauth
    </div>
</div>
