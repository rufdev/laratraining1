<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ManufacturerController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::get('locations', [LocationController::class, 'index'])->name('locations');
Route::get('assets', [AssetController::class, 'index'])->name('assets');
Route::get('manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
