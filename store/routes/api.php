<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductsController::class);