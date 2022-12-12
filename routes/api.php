<?php

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

// end point yang akan didistribusikan ke front end

// PRODUCT
// DONE!
Route::get('/product-rekomendasi', [App\Http\Controllers\Api\ApiProductController::class, 'getRekomendasi']);
Route::get('/product-list', [App\Http\Controllers\Api\ApiProductController::class, 'getAllProduct']);
Route::get('/product-new', [App\Http\Controllers\Api\ApiProductController::class, 'getNewProduct']);
Route::get('/product-search',[App\Http\Controllers\Api\ApiProductController::class, 'searchProduct' ]);
Route::get('/product-detail/{id}', [App\Http\Controllers\Api\ApiProductController::class,'detailProduct']);

// MERK
// DONE!
Route::get('/merk-list', [App\Http\Controllers\Api\ApiProductController::class, 'getMerk']);
Route::get('/product-by-merk', [App\Http\Controllers\Api\ApiProductController::class, 'getProductByMerkId']);

// KERANJANG
// TODO - Keranjang Post(Send data to CartList with ORDER NOW), 
Route::post('/keranjang-post', [App\Http\Controllers\Api\ApiKeranjangController::class, 'postKeranjang']);
// TODO - Keranjang List(collect data from Keranjang-POST),  
Route::get('/keranjang-list', [App\Http\Controllers\Api\ApiKeranjangController::class, 'getAllKeranjang']);
//cancel or delete keranjang
Route::post('/keranjang-delete', [App\Http\Controllers\Api\ApiKeranjangController::class, 'deleteKeranjang']);

// CHECKOUT DONE,
// TODO - checkout-post(send data ORDER NOW to checkOUT),
Route::post('/checkout-post', [App\Http\Controllers\Api\ApiCheckoutController::class, 'postCheckout']);
// TODO - checkout-list-baru(collect data from checkOUT-POST),
Route::get('/checkout-list-baru', [App\Http\Controllers\Api\ApiCheckoutController::class, 'getCheckoutBaru']);
Route::get('/checkout-list-proses', [App\Http\Controllers\Api\ApiCheckoutController::class, 'getCheckoutProses']);
Route::get('/checkout-detail', [App\Http\Controllers\Api\ApiCheckoutController::class, 'getCheckoutDetail']);

// NOTE PAYMENT
// TODO - upload-payment(buktibayar), 
Route::post('/upload-bukti-bayar', [App\Http\Controllers\Api\ApiCheckoutController::class, 'uploadBuktiBayar']);
Route::get('/checkout-list-selesai', [App\Http\Controllers\Api\ApiCheckoutController::class, 'getCheckoutSelesai']);

// AUTHENTICATION
// DONE!
Route::post('/register', [App\Http\Controllers\Api\ApiUserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\ApiUserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Api\ApiUserController::class, 'logout']);
