<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;
use App\Http\Controllers\Api\DeveloperApiController;

Route::get('/properties', [PropertyApiController::class, 'index']);
Route::get('/developers', [DeveloperApiController::class, 'index']);
Route::get('/properties/featured', [PropertyApiController::class, 'featured']);
