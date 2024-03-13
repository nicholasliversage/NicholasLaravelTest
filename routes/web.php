<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('products');
});

// Resourceful routes for ProductController
//Route::resource('product', 'ProductController');

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
Route::post('/save', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::put('/save/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');


