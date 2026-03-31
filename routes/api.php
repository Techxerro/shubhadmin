<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;

Route::get('/properties', [PropertyApiController::class, 'index']);
