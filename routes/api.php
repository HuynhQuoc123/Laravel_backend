<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthAdminController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;





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


//login user
Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('allCustomer', 'index');

});

//login admin
Route::controller(AuthAdminController::class)->group(function(){
    Route::post('loginAdmin', 'login');
    Route::post('registerAdmin', 'register');
    Route::get('allEmployee', 'index');

});



//curd 
Route::apiResource('categories', CategoryController::class);
Route::apiResource('producers', ProducerController::class);
Route::apiResource('products', ProductController::class);

Route::get('/images/{productId}', [ImageController::class, 'index']);
Route::apiResource('images', ImageController::class);





// cart
Route::get('/cart/{userId}', [CartController::class, 'index']);
Route::post('/cart/{userId}', [CartController::class, 'store']);
Route::delete('/cart/{cartId}', [CartController::class, 'destroy']);

//contact
Route::get('/contact/{userId}', [ContactController::class, 'index']);
Route::post('/contact/{userId}', [ContactController::class, 'store']);
Route::put('/contact/{contactId}', [ContactController::class, 'update']);


//address
Route::get('/cities', [AddressController::class, 'city']);
Route::get('/districts/{city_id}', [AddressController::class, 'district']);
Route::get('/wards/{district_id}', [AddressController::class, 'ward']);

//order
Route::get('/orders', [OrderController::class, 'index']); // lay tat ca don hang
Route::post('/order/update-{orderId}', [OrderController::class, 'updateStatus']); // xu ly don hang
Route::get('/order/order-{orderId}', [OrderController::class, 'show']); // chi tiet don hang

Route::post('/order/{userId}', [OrderController::class, 'store']); // taoj don hang
Route::get('/order/{userId}', [OrderController::class, 'getOrderUser']);  // lay don hang cua user





