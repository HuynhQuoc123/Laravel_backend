<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;

use App\Http\Resources\UserResource;







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
// Route::group(['middleware' => ['role:admin']], function () {
//     Route::apiResource('categories', CategoryController::class);

// });

//lay thong tin user qua token
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//lay thong tin admin qua token
Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {
    return new UserResource($request->user());
});


//login user
Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
});

//login admin
Route::post('loginAdmin', [LoginController::class, 'login']);
Route::post('registerAdmin', [RegisterController::class, 'register']);


//curd 
Route::apiResource('categories', CategoryController::class);
Route::apiResource('producers', ProducerController::class);
Route::apiResource('products', ProductController::class);


// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('/cart', [CartController::class, 'store']);
//     Route::put('/cart/{id}', [CartController::class, 'update']);
//     Route::delete('/cart/{id}', [CartController::class, 'destroy']);
// });


// cart
Route::get('/cart/{id}', [CartController::class, 'index']);
Route::post('/cart/{id}', [CartController::class, 'store']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);


