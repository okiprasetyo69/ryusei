<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SalesChannelController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\ImportProductController;

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

// Manage User
Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'getUser')->name('user.data');
    Route::post('/user/create', 'create')->name('user.create');
    Route::post('/user/update', 'update')->name('user.update');
    Route::post('/user/delete', 'delete')->name('user.delete');
    Route::post('/user/detail', 'detail')->name('user.detail');
});

// Manage Role
Route::controller(RoleController::class)->group(function() {
    Route::get('/role', 'getRole')->name('user.role');
});

// Manage Size
Route::controller(SizeController::class)->group(function() {
    Route::get('/size', 'getAllSize')->name('size.data');
});

// Manage Category
Route::controller(CategoryController::class)->group(function() {
    Route::get('/category', 'getCategory')->name('category.data');
    Route::post('/category/create', 'create')->name('category.create');
    Route::post('/category/delete', 'delete')->name('category.delete');
    Route::post('/category/detail', 'detail')->name('category.detail');
});

// Manage List Category
Route::controller(ListCategoryController::class)->group(function() {
    Route::get('/category/list', 'getListCategory')->name('category.list.data');
    Route::post('/category/list/create', 'create')->name('category.list.create');
    Route::post('/category/list/delete', 'delete')->name('category.list.delete');
    Route::post('/category/list/detail', 'detail')->name('category.list.detail');
});

// Manage Product
Route::controller(ProductController::class)->group(function() {
    Route::get('/product', 'getProduct')->name('product.data');
    Route::get('/product/item-list', 'getPaginateProduct')->name('product.item-list');
    Route::post('/product/create', 'create')->name('product.create');
    Route::post('/product/update', 'update')->name('product.update');
    Route::post('/product/delete', 'delete')->name('product.delete');
    Route::post('/product/detail', 'detail')->name('product.detail');
    Route::get('/product/list-product', 'listProduct')->name('product.list');
    Route::get('/product/list/select2', 'getProductSelect2')->name('product.list.select2');
});

// Manage Import Product
Route::controller(ImportProductController::class)->group(function() {
    Route::post('/import/product', 'importProduct')->name('import.product');
});

// Manage Sales Channel
Route::controller(SalesChannelController::class)->group(function() {
    Route::get('/sales-channel', 'getSalesChannel')->name('sales.channel.data');
    Route::get('/sales-channel/datatable', 'getSalesChannelDatatable')->name('sales.channel.data-table');
    Route::post('/sales-channel/create', 'create')->name('sales.channel.create');
    Route::post('/sales-channel/detail', 'detail')->name('sales.channel.detail');
    Route::post('/sales-channel/delete', 'delete')->name('sales.channel.delete');
});

// Manage Locality
Route::controller(LocalityController::class)->group(function() {
    Route::get('/locality-list', 'getLocality')->name('locality.data');
    Route::post('/locality-list/create', 'create')->name('locality.create');
    Route::post('/locality-list/update', 'update')->name('locality.update');
    Route::post('/locality-list/delete', 'delete')->name('locality.delete');
    Route::post('/locality-list/detail', 'detail')->name('locality.detail');
    Route::post('/locality-list/import-postalcode', 'importPostalCode')->name('locality.import.postalcode');
    Route::get('/locality-list/province', 'getProvince')->name('locality.province');
    Route::get('/locality-list/city', 'getCity')->name('locality.city');
    Route::get('/locality-list/district', 'getDistrict')->name('locality.district');
    Route::get('/locality-list/village', 'getVillage')->name('locality.village');
});


// Manage Payment Method
Route::controller(PaymentMethodController::class)->group(function() {
    Route::get('/payment-method', 'getPaymentMethod')->name('payment.method.data');
});

// Manage Transaction
Route::controller(TransactionController::class)->group(function() {
    Route::get('/transaction', 'getTransaction')->name('transaction.data');
    Route::post('/transaction/create', 'create')->name('transaction.create');
    Route::post('/transaction/update', 'update')->name('transaction.update');
    Route::post('/transaction/delete', 'delete')->name('transaction.delete');
    Route::post('/transaction/detail', 'detail')->name('transaction.detail');
});

// Dashboard
Route::controller(DashboardController::class)->group(function() {
    Route::get('/analytics/total-qty', 'totalQty')->name('analytics.total_qty');
    Route::get('/analytics/best-store', 'bestSellingChannelStore')->name('analytics.best_store');
    Route::get('/analytics/best-product', 'bestSellingProduct')->name('analytics.best_product');
    Route::get('/analytics/chart-performance', 'getChartSelling')->name('analytics.chart_performance');
});