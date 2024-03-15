<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'getUser')->name('user.data');
    Route::post('/user/create', 'create')->name('user.create');
    Route::post('/user/delete', 'delete')->name('user.delete');
    Route::post('/user/detail', 'detail')->name('user.detail');
});

Route::controller(RoleController::class)->group(function() {
    Route::get('/role', 'getRole')->name('user.role');
});

Route::controller(SizeController::class)->group(function() {
    Route::get('/size', 'getAllSize')->name('size.data');
});


Route::controller(CategoryController::class)->group(function() {
    Route::get('/category', 'getCategory')->name('category.data');
    Route::post('/category/create', 'create')->name('category.create');
    Route::post('/category/delete', 'delete')->name('category.delete');
    Route::post('/category/detail', 'detail')->name('category.detail');
});

Route::controller(ListCategoryController::class)->group(function() {
    Route::get('/category/list', 'getListCategory')->name('category.list.data');
    Route::post('/category/list/create', 'create')->name('category.list.create');
    Route::post('/category/list/delete', 'delete')->name('category.list.delete');
    Route::post('/category/list/detail', 'detail')->name('category.list.detail');
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/product', 'getProduct')->name('product.data');
    Route::get('/product/item-list', 'getPaginateProduct')->name('product.item-list');
    Route::post('/product/create', 'create')->name('product.create');
    Route::post('/product/update', 'update')->name('product.update');
    Route::post('/product/delete', 'delete')->name('product.delete');
    Route::post('/product/detail', 'detail')->name('product.detail');
    Route::get('/product/list-product', 'listProduct')->name('product.list');
});