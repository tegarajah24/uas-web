<?php

use App\Livewire\Admin\UserManagement;
use App\Livewire\Farmasi\MedicineStock;
use App\Livewire\Farmasi\PrescriptionQueue;
use App\Livewire\FrontOffice\PatientRegistration;
use App\Livewire\FrontOffice\QueueBoard;
use App\Livewire\Kasir\BillingForm;
use App\Livewire\Kasir\InvoiceList;
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

Route::middleware(['auth', 'verified', 'role:farmasi'])
    ->prefix('farmasi')
    ->name('farmasi.')
    ->group(function () {
        Route::get('/prescriptions', PrescriptionQueue::class)->name('prescriptions');
        Route::get('/stock', MedicineStock::class)->name('stock');
    });

Route::middleware(['auth', 'verified', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {
        Route::get('/billing', BillingForm::class)->name('billing');
        Route::get('/history', InvoiceList::class)->name('history');
    });

Route::middleware(['auth', 'verified', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', UserManagement::class)->name('users');
    });

require __DIR__.'/auth.php';
