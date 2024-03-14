<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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
    Route::get('/category', 'index')->name('category');
});

// Category List Menu
Route::controller(ListCategoryController::class)->group(function() {
    Route::get('/category/list', 'index')->name('category.list');
});

// Product Menu
Route::controller(ProductController::class)->group(function() {
    Route::get('/product', 'index')->name('product');
    Route::get('/product/add', 'add')->name('product.add');
    Route::get('/product/edit/{code}', 'edit')->name('product.edit');
});

// Transaction Menu
Route::controller(TransactionController::class)->group(function() {
    Route::get('/transaction', 'index')->name('transaction');
});
