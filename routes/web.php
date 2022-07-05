<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::post('/addProduct', [ProductController::class, 'store'])->name('storeProduct');
Route::post('/withdrawBalance', [HomeController::class, 'withdraw'])->name('withdrawBalance');
