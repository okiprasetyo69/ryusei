<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SalesChannelController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\WarehouseController;

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

// Sales Channel Menu
Route::controller(SalesChannelController::class)->group(function() {
    Route::get('/sales-channel', 'salesChannelPage')->name('sales-channel');
});

// Locality Menu
Route::controller(LocalityController::class)->group(function() {
    Route::get('/city-list', 'cityPage')->name('city-list');
    Route::get('/city-list/import', 'importLocalityPage')->name('city-list-import');
});

// Product Menu
Route::controller(ProductController::class)->group(function() {
    Route::get('/product', 'index')->name('product');
    Route::get('/product/add', 'add')->name('product.add');
    Route::get('/product/edit/{code}', 'edit')->name('product.edit');
    Route::get('/product/download/import', 'downloadFormatImportProduct')->name('product.download.import');
});

// Transaction Menu
Route::controller(TransactionController::class)->group(function() {
    Route::get('/transaction', 'index')->name('transaction');
    Route::get('/transaction/add', 'add')->name('transaction.add');
    Route::get('/transaction/edit/{id}', 'edit')->name('transaction.edit');
    Route::get('/transaction/download/import', 'downloadFormatImportTransaksi')->name('transaction.download.import');
});

Route::controller(WarehouseController::class)->group(function() {
    Route::get('/warehouse', 'warehousePage')->name('warehouse');
});