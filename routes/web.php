<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/send-email', [App\Http\Controllers\MailController::class, 'index']);

// middleware auth utk membatasi akses routing tertentu harus melewati login terlebih dahulu
Route::group(['middleware' => ['auth'] ], function(){

    // isi kan dengan routing yg ingin dibatasi
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'add'])->name('add-user');
    Route::post('/store-user', [App\Http\Controllers\UserController::class, 'store'])->name('store-user');
    Route::get('/edit-user/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit-user');
    Route::post('/update-user', [App\Http\Controllers\UserController::class, 'update'])->name('update-user');
    Route::get('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('delete-user');

    Route::get('/merk', [App\Http\Controllers\MerkController::class, 'index'])->name('merk');
    Route::get('/add-merk', [App\Http\Controllers\MerkController::class, 'add'])->name('add-merk');
    Route::post('/store-merk', [App\Http\Controllers\MerkController::class, 'store'])->name('store-merk');
    Route::get('/edit-merk/{id}', [App\Http\Controllers\MerkController::class, 'edit'])->name('edit-merk');
    Route::post('/update-merk', [App\Http\Controllers\MerkController::class, 'update'])->name('update-merk');
    Route::get('/delete-merk/{id}', [App\Http\Controllers\MerkController::class, 'delete'])->name('delete-merk');

    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
    Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'add'])->name('add-product');
    Route::post('/store-product', [App\Http\Controllers\ProductController::class, 'store'])->name('store-product');
    Route::get('/edit-product/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit-product');
    Route::post('/update-product', [App\Http\Controllers\ProductController::class, 'update'])->name('update-product');
    Route::get('/delete-product/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('delete-product');

    Route::get('/pemesanan', [App\Http\Controllers\CheckoutController::class, 'index'])->name('pemesanan');
    Route::get('/detail/{id}', [App\Http\Controllers\CheckoutController::class, 'detail'])->name('detail-pemesanan');
    Route::post('/update-status-pemesanan', [App\Http\Controllers\CheckoutController::class, 'updateStatus'])->name('update-status-pemesanan');

} );

