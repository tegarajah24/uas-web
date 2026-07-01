<?php

use App\Livewire\FrontOffice\PatientRegistration;
use App\Livewire\FrontOffice\QueueBoard;
use App\Livewire\Rme\RmeDashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified', 'role:admin_resepsionis'])
    ->prefix('front-office')
    ->name('front-office.')
    ->group(function () {
        Route::get('/register', PatientRegistration::class)->name('register');
        Route::get('/queue', QueueBoard::class)->name('queue');
    });

Route::middleware(['auth', 'verified', 'role:dokter'])
    ->prefix('rme')
    ->name('rme.')
    ->group(function () {
        Route::get('/', RmeDashboard::class)->name('dashboard');
    });

require __DIR__.'/auth.php';
