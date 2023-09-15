<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDataController;
use App\Http\Controllers\SubcategoryController;
use App\Models\ProductData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::apiResource('category', CategoryController::class)->middleware('auth:sanctum')->except(['index', 'show']);
Route::apiResource('subcategory', SubcategoryController::class)->middleware('auth:sanctum')->except(['index', 'show']);
Route::apiResource('product', ProductController::class)->middleware('auth:sanctum')->except(['index', 'show']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('product_data', [ProductDataController::class, 'store'])->name('product_data.store');
    Route::put('product_data/{product_data}', [ProductDataController::class, 'update'])->name('product_data.update');
    Route::delete('product_data/{product_data}', [ProductDataController::class, 'destroy'])->name('product_data.destroy');
});

// Route::resource('product_data', ProductDataController::class)->middleware('auth:sanctum')->except(['index', 'show']);

Route::apiResource('category', CategoryController::class)->only(['index', 'show']);
Route::apiResource('subcategory', SubcategoryController::class)->only(['index', 'show']);
Route::apiResource('product', ProductController::class)->only(['index', 'show']);
Route::get('product_data', [ProductDataController::class, 'index'])->name('product_data.index');
Route::get('product_data/{product_data}', [ProductDataController::class, 'show'])->name('product_data.show');
Route::get('product-list/{subcategory}', [ProductController::class, 'list']);
