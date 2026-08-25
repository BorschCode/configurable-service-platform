<?php

use App\Http\Controllers\Catalog\ContactController;
use App\Http\Controllers\Catalog\DirectoryController;
use App\Http\Controllers\Catalog\HomeController;
use App\Http\Controllers\Catalog\ProjectController;
use App\Http\Controllers\Catalog\ServiceController;
use App\Support\ReservedCatalogSlugs;
use Illuminate\Support\Facades\Route;

Route::get('/', DirectoryController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::pattern('business', ReservedCatalogSlugs::routePattern());

Route::scopeBindings()->group(function () {
    Route::get('/{business}', HomeController::class)->name('catalog.home');
    Route::get('/{business}/services', [ServiceController::class, 'index'])->name('catalog.services.index');
    Route::get('/{business}/services/{service}', [ServiceController::class, 'show'])->name('catalog.services.show');
    Route::get('/{business}/portfolio', [ProjectController::class, 'index'])->name('catalog.portfolio.index');
    Route::get('/{business}/portfolio/{project}', [ProjectController::class, 'show'])->name('catalog.portfolio.show');
    Route::get('/{business}/contact', ContactController::class)->name('catalog.contact');
});
