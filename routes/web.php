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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

Route::group(['middleware' => ['auth']], function () {

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(App\Http\Controllers\ImportController::class)->group(function(){
    Route::get('/import', 'index')->name('import');
    Route::get('/import/create', 'create')->name('import.create');
    Route::get('/import/list', 'getImports')->name('import.list');
    Route::post('/import', 'store')->name('store');
    //Route::get('/import/download', 'getDownload')->name('import.download');
});

Route::controller(App\Http\Controllers\CustomerController::class)->group(function(){
    Route::get('/customer', 'index')->name('customer');
});

Route::controller(App\Http\Controllers\ProductController::class)->group(function(){
    Route::get('/product', 'index')->name('product');
});

Route::controller(App\Http\Controllers\OrderController::class)->group(function(){
    Route::get('/order', 'index')->name('order');
    Route::get('/order/{id}', 'show')->name('show');
});

});
Auth::routes();
