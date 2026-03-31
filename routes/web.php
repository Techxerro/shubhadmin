<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {

        // Property Routes
        Route::get('/properties', [PropertyController::class, 'list'])->name('properties.list');
        Route::get('/properties/add', [PropertyController::class, 'add'])->name('properties.add');
        Route::post('/properties/store', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/edit/{id}', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::post('/properties/update/{id}', [PropertyController::class, 'update'])->name('properties.update');
        Route::post('/properties/delete/{id}', [PropertyController::class, 'delete'])->name('properties.delete');

        // Developer Routes
        // Route::get('/developers', [DeveloperController::class, 'list'])->name('developers.list');
        // Route::get('/developers/add', [DeveloperController::class, 'add'])->name('developers.add');
        // Route::post('/developers/store', [DeveloperController::class, 'store'])->name('developers.store');
        // Route::get('/developers/edit/{id}', [DeveloperController::class, 'edit'])->name('developers.edit');
        // Route::post('/developers/update/{id}', [DeveloperController::class, 'update'])->name('developers.update');
        // Route::post('/developers/delete/{id}', [DeveloperController::class, 'delete'])->name('developers.delete');
    });
});

require __DIR__.'/auth.php';
