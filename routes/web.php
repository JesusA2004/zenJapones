<?php

use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicSiteController::class, 'home'])->name('home');

Route::middleware('no-store')->group(function () {
    Route::get('/menu', [PublicSiteController::class, 'menu'])->name('menu.index');
});

Route::get('/sucursales', [PublicSiteController::class, 'branches'])->name('branches.index');
Route::get('/eventos', [PublicSiteController::class, 'events'])->name('events.index');
Route::get('/aviso-de-privacidad', [PublicSiteController::class, 'privacy'])->name('privacy.show');
Route::get('/bolsa-de-trabajo', [PublicSiteController::class, 'jobs'])->name('jobs.show');

Route::get('/facturacion', function () {
    return redirect('https://factura-zugacloud.zugatech.com/?Cliente=ZEN');
})->name('billing');

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect('/admin');
})->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    Route::get('/sucursales', function () {
        return Inertia::render('Admin/Branches/Index');
    })->name('branches.index');

    Route::get('/categorias-menu', function () {
        return Inertia::render('Admin/MenuCategories/Index');
    })->name('menu-categories.index');

    Route::get('/menu-items', function () {
        return Inertia::render('Admin/MenuItems/Index');
    })->name('menu-items.index');

    Route::get('/eventos', function () {
        return Inertia::render('Admin/Events/Index');
    })->name('events.index');

    Route::get('/settings', function () {
        return Inertia::render('Admin/Settings/Index');
    })->name('settings.index');
});

require __DIR__.'/settings.php';
