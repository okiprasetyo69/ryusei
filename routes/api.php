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
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\InvoiceCategoryController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DataWarehouseInvoiceController;
use App\Http\Controllers\DataWarehouseSalesOrderController;
use App\Http\Controllers\SalesReturnController;

use App\Http\Controllers\WebhookController;
use App\Http\Middleware\VerifyWebhookSecret;

use App\Http\Controllers\HomePageController;

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

// Home Page
Route::controller(HomePageController::class)->group(function() {
    Route::get('/gsheet/data', 'getDataGSheet')->name('gsheet.data');
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
    Route::get('/product/list/invoice/select2', 'getProductSelect2Invoice')->name('product.list.invoice.select2');
    Route::get('/product/item-unit', 'getItemUnit')->name('item.unit');
    Route::get('/jubelio/inventory', 'getDataFromJubelio')->name('inventory');
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
    Route::post('/import/transaction', 'importTransaction')->name('transaction.import');
});

// Dashboard
Route::controller(DashboardController::class)->group(function() {
    Route::get('/analytics/total-qty', 'totalQty')->name('analytics.total_qty');
    Route::get('/analytics/best-store', 'bestSellingChannelStore')->name('analytics.best_store');
    Route::get('/analytics/best-product', 'bestSellingProduct')->name('analytics.best_product');
    Route::get('/analytics/chart-performance', 'getChartSelling')->name('analytics.chart_performance');
    Route::get('/analytics/monitoring-stock', 'monitoringStock')->name('analytics.monitoring-stock');
});

// Warehouse
Route::controller(WarehouseController::class)->group(function() {
    Route::get('/warehouse', 'getWarehouse')->name('warehouse.data');
    Route::post('/warehouse/create', 'create')->name('warehouse.create');
    Route::post('/warehouse/delete', 'delete')->name('warehouse.delete');
    Route::post('/warehouse/detail', 'detail')->name('warehouse.detail');
});

// Manage Item Stock
Route::controller(ItemStockController::class)->group(function() {
    Route::get('/item-stock', 'getItemStock')->name('stock.data');
    Route::post('/item-stock/create', 'create')->name('stock.create');
    Route::post('/item-stock/delete', 'delete')->name('stock.delete');
    Route::post('/item-stock/detail', 'detail')->name('stock.detail');
    Route::post('/item-stock/import', 'importItemStock')->name('stock.import');
});

// Manage invoice category
Route::controller(InvoiceCategoryController::class)->group(function() {
    Route::get('/invoice/category', 'getAllInvoiceCategory')->name('invoice.category.data');
});

// Manage sales invoice
Route::controller(SalesInvoiceController::class)->group(function() {
    Route::get('/sales-invoice', 'getAllSalesInvoice')->name('sales-invoice.data');
    Route::post('/sales-invoice/create', 'create')->name('sales-invoice.create');
    Route::post('/sales-invoice/update', 'update')->name('sales-invoice.update');
    Route::post('/sales-invoice/delete', 'delete')->name('sales-invoice.delete');
    Route::post('/sales-invoice/detail', 'detail')->name('sales-invoice.detail');
    Route::post('/sales-invoice/detail-invoice-item', 'detailInvoice')->name('sales-invoice.detail.invoice-item');
    Route::post('/sales-invoice/detail-invoice-item/delete', 'deleteDetailInvoice')->name('sales-invoice.detail.invoice-item.delete');
});

// Manage Vendor
Route::controller(VendorController::class)->group(function() {
    Route::get('/vendor', 'getVendor')->name('vendor.data');
    Route::get('/vendors', 'getVendors')->name('vendors.data');
    Route::post('/vendor/create', 'create')->name('vendor.create');
    Route::post('/vendor/delete', 'delete')->name('vendor.delete');
    Route::post('/vendor/detail', 'detail')->name('vendor.detail');
});

// Manage purchasing invoice
Route::controller(PurchasingController::class)->group(function() {
    Route::get('/purchasing-invoice', 'getPurchasingInvoice')->name('purchasing-invoice.data');
    Route::post('/purchasing-invoice/create', 'create')->name('purchasing-invoice.create');
    Route::post('/purchasing-invoice/update', 'update')->name('purchasing-invoice.update');
    Route::post('/purchasing-invoice/delete', 'delete')->name('purchasing-invoice.delete');
    Route::post('/purchasing-invoice/detail', 'detail')->name('purchasing-invoice.detail');
    Route::post('/purchasing-invoice/detail-invoice-item', 'detailInvoice')->name('purchasing-invoice.detail.invoice-item');
    Route::post('/purchasing-invoice/detail-invoice-item/delete', 'deleteDetailInvoice')->name('purchasing-invoice.detail.invoice-item.delete');
});

// Manage purchase order
Route::controller(PurchaseOrderController::class)->group(function() {
    Route::get('/purchase/order', 'getPurchaseOrder')->name('purchase-order.data');
    // Route::post('/purchasing-invoice/create', 'create')->name('purchasing-invoice.create');
    // Route::post('/purchasing-invoice/update', 'update')->name('purchasing-invoice.update');
    // Route::post('/purchasing-invoice/delete', 'delete')->name('purchasing-invoice.delete');
    // Route::post('/purchasing-invoice/detail', 'detail')->name('purchasing-invoice.detail');
    Route::post('/purchase/order/detail', 'detailPurchaseOrder')->name('purchase.order.detail');
    // Route::post('/purchasing-invoice/detail-invoice-item/delete', 'deleteDetailInvoice')->name('purchasing-invoice.detail.invoice-item.delete');
});

// Manage Datawarehouse
Route::controller(DataWarehouseInvoiceController::class)->group(function() {
    Route::get('/data-warehouse/invoice', 'getAllDataWarehouseInvoice')->name('data-warehouse.invoice');
    Route::get('/data-warehouse/invoice/total', 'totalInvoiceTransaction')->name('data-warehouse.invoice.total');
    Route::get('/data-warehouse/invoice/detail', 'detailInvoice')->name('data-warehouse.invoice.detail');
});

Route::controller(DataWarehouseSalesOrderController::class)->group(function() {
    Route::get('/data-warehouse/sales/order/completed', 'getAllDataWarehouseOrder')->name('data-warehouse.sales.order.completed');
    Route::get('/data-warehouse/sales/order/total', 'totalSalesOrderCompleted')->name('data-warehouse.sales.order.completed.total');
    Route::get('/data-warehouse/sales/order/detail', 'detailSalesOrderCompleted')->name('data-warehouse.sales.order.completed.detail');
});

Route::controller(SalesReturnController::class)->group(function() {
    Route::get('/data-warehouse/sales/return', 'getAllSalesReturn')->name('sales.return');
    Route::get('/data-warehouse/sales/return/total', 'totalSalesReturn')->name('data-warehouse.sales.return.total');
    Route::get('/data-warehouse/sales/return/detail', 'detailSalesReturn')->name('data-warehouse.sales.return.detail');
});

// Web Hook
Route::controller(WebhookController::class)->group(function() {
    Route::post('/webhook/jubelio/product', 'handleProduct')->name('webhook.jubelio.product')->middleware(VerifyWebhookSecret::class);
});