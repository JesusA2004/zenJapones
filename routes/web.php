<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Public/Home');
})->name('home');

Route::get('/menu', function () {
    return Inertia::render('Public/Menu/Index');
})->name('menu.index');

Route::get('/sucursales', function () {
    return Inertia::render('Public/Branches/Index');
})->name('branches.index');

Route::get('/eventos', function () {
    return Inertia::render('Public/Events/Index');
})->name('events.index');

Route::get('/aviso-de-privacidad', function () {
    return Inertia::render('Public/Privacy/Show');
})->name('privacy.show');

Route::get('/bolsa-de-trabajo', function () {
    return Inertia::render('Public/Jobs/Show');
})->name('jobs.show');

/*
|--------------------------------------------------------------------------
| Facturación
|--------------------------------------------------------------------------
| Si todavía no tienes vista, puedes redirigir o dejar temporal.
*/

Route::get('/facturacion', function () {
    return redirect('/');
})->name('billing');

/*
|--------------------------------------------------------------------------
| Panel admin
|--------------------------------------------------------------------------
*/

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
