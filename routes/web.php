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
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DataWarehouseInvoiceController;
use App\Http\Controllers\DataWarehouseSalesOrderController;
use App\Http\Controllers\SalesReturnController;

use App\Http\Controllers\WebhookController;
use App\Http\Middleware\VerifyWebhookSecret;

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
    Route::get('/jubelio/inventory', 'getDataFromJubelio')->name('jubelio-inventory');
    Route::get('/jubelio/update-token', 'updateToken')->name('jubelio-update-token');
});

// Transaction Menu
Route::controller(TransactionController::class)->group(function() {
    Route::get('/transaction', 'index')->name('transaction');
    Route::get('/transaction/add', 'add')->name('transaction.add');
    Route::get('/transaction/edit/{id}', 'edit')->name('transaction.edit');
    Route::get('/transaction/download/import', 'downloadFormatImportTransaksi')->name('transaction.download.import');
    Route::get('/jubelio/transaction/invoice', 'getInvoiceTransactionFromJubelio')->name('jubelio.transaction.invoice');
});

// Warehouse Menu
Route::controller(WarehouseController::class)->group(function() {
    Route::get('/warehouse', 'warehousePage')->name('warehouse');
});

// Item Stock
Route::controller(ItemStockController::class)->group(function() {
    Route::get('/stock-position', 'stockPosition')->name('stock-position');
    Route::get('/items-incoming/download/import', 'downloadFormatImportStockItems')->name('items_incoming.download.import');
});

// Sales Invoice
Route::controller(SalesInvoiceController::class)->group(function() {
    Route::get('/sales-invoice', 'index')->name('sales_invoice');
    Route::get('/sales-invoice/add', 'add')->name('sales_invoice.add');
    Route::get('/sales-invoice/{id}', 'edit')->name('sales_invoice.edit');
});

// Vendors
Route::controller(VendorController::class)->group(function() {
    Route::get('/vendors', 'index')->name('vendors');
    Route::get('/vendors/add', 'add')->name('vendors.add');
    Route::get('/vendors/{id}', 'edit')->name('vendors.edit');
    Route::get('/jubelio/suppliers', 'getSupplierFromJubelio')->name('jubelio-suppliers');
});

// Purchasing
Route::controller(PurchasingController::class)->group(function() {
    Route::get('/purchasing', 'index')->name('purchasing');
    Route::get('/purchasing/invoice/add', 'add')->name('purchasing-invoice.add');
    Route::get('/purchasing/invoice/{id}', 'edit')->name('purchasing-invoice.edit');
    Route::get('/jubelio/purchase/invoice', 'getPurchaseInvoiceFromJubelio')->name('jubelio.purchase.invoice');
});

// Purchase Order
Route::controller(PurchaseOrderController::class)->group(function() {
    Route::get('/purchase/order', 'index')->name('purchase.order');
    Route::get('/purchase/order/add', 'add')->name('purchase.order.add');
    Route::get('/purchase/order/{id}', 'edit')->name('purchase.order.edit');
    Route::get('/jubelio/purchase/order', 'getPurchaseOrderFromJubelio')->name('jubelio.purchase.order');
});

// Data Warehouse Invoice
Route::controller(DataWarehouseInvoiceController::class)->group(function() {
    Route::get('/data-warehouse/invoice', 'index')->name('data-warehouse.invoice');
    Route::get('/data-warehouse/invoice/detail/{id}', 'detail')->name('data-warehouse.invoice.detail');
    Route::get('/jubelio/transaction/invoice', 'getInvoiceFromJubelio')->name('jubelio.transaction.invoice');
});

// Data Warehouse Sales Order
Route::controller(DataWarehouseSalesOrderController::class)->group(function() {
    Route::get('/data-warehouse/sales/order/completed', 'index')->name('data-warehouse.order');
    Route::get('/data-warehouse/sales/order/completed/detail/{id}', 'detail')->name('data-warehouse.order.detail');
    Route::get('/jubelio/sales/order/completed', 'getSalesOrderCompletedFromJubelio')->name('jubelio.transaction.order');
});

// Sales Return
Route::controller(SalesReturnController::class)->group(function() {
    Route::get('/data-warehouse/sales-return', 'index')->name('sales-return');
    Route::get('/data-warehouse/sales-return/detail/{id}', 'detail')->name('sales-return.detail');
    Route::get('/jubelio/sales/return', 'getSalesReturnFromJubelio')->name('jubelio.sales.return');
});

// Webhook
Route::post('/jubelio/webhook/product', [WebhookController::class, 'handleProduct'])->middleware(VerifyWebhookSecret::class);