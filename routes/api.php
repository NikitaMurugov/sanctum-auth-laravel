<?php

use App\Http\Controllers\ProductController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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



//Route::apiResource('products',ProductController::class);
Route::get('/products',[ProductController::class, 'index']);
Route::get('/products/{product}',[ProductController::class, 'show']);
Route::get('/products/search/{name}',[ProductController::class, 'search']);

Route::group(['prefix'=>'products', 'middleware'=>'auth:sanctum'], function () {
    Route::post('{product}',[ProductController::class, 'show']);
    Route::match(array('PUT', 'PATCH'),'{product}',[ProductController::class, 'update']);
    Route::delete('{product}',[ProductController::class, 'destroy']);
});
