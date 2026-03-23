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

    //routes for properties
    Route::get('/admin/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/admin/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/admin/properties', [PropertyController::class, 'store'])->name('properties.store');

    Route::get('/admin/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/admin/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
});

require __DIR__.'/auth.php';
