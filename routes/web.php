<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Públicas
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Compatibilidad starter kit
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/hero-slides', [AdminController::class, 'heroSlides'])->name('hero-slides.index');
        Route::post('/hero-slides', [AdminController::class, 'storeHeroSlide'])->name('hero-slides.store');
        Route::post('/hero-slides/{heroSlide}', [AdminController::class, 'updateHeroSlide'])->name('hero-slides.update');
        Route::delete('/hero-slides/{heroSlide}', [AdminController::class, 'destroyHeroSlide'])->name('hero-slides.destroy');

        Route::get('/secciones', [AdminController::class, 'contentSections'])->name('content-sections.index');
        Route::post('/secciones/{contentSection}', [AdminController::class, 'updateContentSection'])->name('content-sections.update');

        Route::get('/sucursales', [AdminController::class, 'branches'])->name('branches.index');
        Route::post('/sucursales', [AdminController::class, 'storeBranch'])->name('branches.store');
        Route::post('/sucursales/{branch}', [AdminController::class, 'updateBranch'])->name('branches.update');
        Route::delete('/sucursales/{branch}', [AdminController::class, 'destroyBranch'])->name('branches.destroy');

        Route::get('/categorias-menu', [AdminController::class, 'menuCategories'])->name('menu-categories.index');
        Route::post('/categorias-menu', [AdminController::class, 'storeMenuCategory'])->name('menu-categories.store');
        Route::post('/categorias-menu/{menuCategory}', [AdminController::class, 'updateMenuCategory'])->name('menu-categories.update');
        Route::delete('/categorias-menu/{menuCategory}', [AdminController::class, 'destroyMenuCategory'])->name('menu-categories.destroy');

        Route::get('/menu-items', [AdminController::class, 'menuItems'])->name('menu-items.index');
        Route::post('/menu-items', [AdminController::class, 'storeMenuItem'])->name('menu-items.store');
        Route::post('/menu-items/{menuItem}', [AdminController::class, 'updateMenuItem'])->name('menu-items.update');
        Route::delete('/menu-items/{menuItem}', [AdminController::class, 'destroyMenuItem'])->name('menu-items.destroy');

        Route::get('/eventos', [AdminController::class, 'events'])->name('events.index');
        Route::post('/eventos', [AdminController::class, 'storeEvent'])->name('events.store');
        Route::post('/eventos/{event}', [AdminController::class, 'updateEvent'])->name('events.update');
        Route::delete('/eventos/{event}', [AdminController::class, 'destroyEvent'])->name('events.destroy');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

        Route::post('/menu/publicar', [AdminController::class, 'publishMenu'])->name('menu.publish');
    });

require __DIR__ . '/settings.php';
