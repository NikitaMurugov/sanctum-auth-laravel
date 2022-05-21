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



Route::apiResource('products',ProductController::class);
Route::get('/products/search/{name}',[ProductController::class, 'search']);


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
