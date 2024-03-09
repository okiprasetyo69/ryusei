<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;

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


Route::controller(CategoryController::class)->group(function() {
    Route::get('/category', 'getCategory')->name('category.data');
    Route::post('/category/create', 'create')->name('category.create');
    Route::post('/category/delete', 'delete')->name('category.delete');
    Route::post('/category/detail', 'detail')->name('category.detail');
});