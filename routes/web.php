<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

// Route::get('/', function () {
//     return view('index');
// });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [LoginController::class, 'loginPage']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [HomePageController::class, 'dashboard'])->name('dashboard')->middleware('super_admin');

// User Menu
Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'index')->name('user');
});

// Category Menu
Route::controller(CategoryController::class)->group(function() {
    Route::get('/category', 'index')->name('user');
});

// Product Menu
Route::controller(ProductController::class)->group(function() {
    Route::get('/product', 'index')->name('product');
});