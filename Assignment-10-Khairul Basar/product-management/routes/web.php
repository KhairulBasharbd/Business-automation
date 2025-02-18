<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

Route::get('/cart', [CartController::class, 'showCart']);
Route::post('/cart/add/{id}', [CartController::class, 'addToCart']);
Route::post('/cart/update', [CartController::class, 'updateCart']);
Route::post('/cart/pay', [CartController::class, 'pay']);







Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
