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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () { return Inertia::render('Dashboard');})->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::post('categories/list', [CategoryController::class, 'list'])->name('categories.list');
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'verified', 'role:super_admin,inventory_manager'])->group(function () {
    Route::resource('manufacturers', ManufacturerController::class)->except(['create', 'edit']);
    Route::resource('locations', LocationController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'verified', 'role:super_admin,inventory_user'])->group(function () {
    Route::resource('assets', AssetController::class)->except(['create', 'edit']);
});

// Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
// Route::resource('manufacturers', ManufacturerController::class)->except(['create', 'edit']);
// Route::resource('locations', LocationController::class)->except(['create', 'edit']);
// Route::resource('assets', AssetController::class)->except(['create', 'edit']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
