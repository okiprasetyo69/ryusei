<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\Paginator;

use App\Services\Interfaces\UserService;
use App\Services\Interfaces\RoleService;
use App\Services\Interfaces\CategoryService;
use App\Services\Interfaces\CategoryListService;
use App\Services\Interfaces\ProductService;
use App\Services\Interfaces\SizeService;
use App\Services\Interfaces\SalesChannelService;
use App\Services\Interfaces\PaymentMethodService;
use App\Services\Interfaces\TransactionService;
use App\Services\Interfaces\DashboardService;
use App\Services\Interfaces\LocalityService;
use App\Services\Interfaces\ImportProductService;
use App\Services\Interfaces\WarehouseService;
use App\Services\Interfaces\ItemStockService;
use App\Services\Interfaces\InvoiceCategoryService;
use App\Services\Interfaces\SalesInvoiceService;
use App\Services\Interfaces\VendorService;
use App\Services\Interfaces\PurchasingInvoiceService;
use App\Services\Interfaces\PurchaseOrderService;
use App\Services\Interfaces\DataWarehouseInvoiceService;
use App\Services\Interfaces\DataWarehouseSalesOrderService;
use App\Services\Interfaces\SalesReturnService;
use App\Services\Interfaces\DevelopmentService;
use App\Services\Interfaces\DashboardProductionService;

use App\Services\Repositories\UserRepositoryEloquent;
use App\Services\Repositories\RoleRepositoryEloquent;
use App\Services\Repositories\CategoryRepositoryEloquent;
use App\Services\Repositories\CategoryListRepositoryEloquent;
use App\Services\Repositories\ProductRepositoryEloquent;
use App\Services\Repositories\SizeRepositoryEloquent;
use App\Services\Repositories\SalesChannelRepositoryEloquent;
use App\Services\Repositories\PaymentMethodRepositoryEloquent;
use App\Services\Repositories\TransactionRepositoryEloquent;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Services\Repositories\LocalityRepositoryEloquent;
use App\Services\Repositories\ImportProductRepositoryEloquent;
use App\Services\Repositories\WarehouseRepositoryEloquent;
use App\Services\Repositories\ItemStockRepositoryEloquent;
use App\Services\Repositories\InvoiceCategoryRepositoryEloquent;
use App\Services\Repositories\SalesInvoiceRepositoryEloquent;
use App\Services\Repositories\VendorRepositoryEloquent;
use App\Services\Repositories\PurchasingInvoiceRepositoryEloquent;
use App\Services\Repositories\PurchaseOrderRepositoryEloquent;
use App\Services\Repositories\DataWarehouseInvoiceRepositoryEloquent;
use App\Services\Repositories\DataWarehouseSalesOrderRepositoryEloquent;
use App\Services\Repositories\SalesReturnRepositoryEloquent;
use App\Services\Repositories\DevelopmentRepositoryEloquent;
use App\Services\Repositories\DashboardProductionRepositoryEloquent;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * List of all of the container singletons.
     * This properties will inject the key class into value class.
     * Ex. AuthService class will injected into AuthRepository class.
     * 
     */
    public $singletons = [
        UserService::class => UserRepositoryEloquent::class,
        RoleService::class => RoleRepositoryEloquent::class,
        CategoryService::class => CategoryRepositoryEloquent::class,
        CategoryListService::class => CategoryListRepositoryEloquent::class,
        ProductService::class => ProductRepositoryEloquent::class,
        SizeService::class => SizeRepositoryEloquent::class,
        SalesChannelService::class => SalesChannelRepositoryEloquent::class,
        PaymentMethodService::class => PaymentMethodRepositoryEloquent::class,
        TransactionService::class => TransactionRepositoryEloquent::class,
        DashboardService::class => DashboardRepositoryEloquent::class,
        LocalityService::class => LocalityRepositoryEloquent::class,
        ImportProductService::class => ImportProductRepositoryEloquent::class,
        WarehouseService::class => WarehouseRepositoryEloquent::class,
        ItemStockService::class => ItemStockRepositoryEloquent::class,
        InvoiceCategoryService::class => InvoiceCategoryRepositoryEloquent::class,
        SalesInvoiceService::class => SalesInvoiceRepositoryEloquent::class,
        VendorService::class => VendorRepositoryEloquent::class,
        PurchasingInvoiceService::class => PurchasingInvoiceRepositoryEloquent::class,
        PurchaseOrderService::class => PurchaseOrderRepositoryEloquent::class,
        DataWarehouseInvoiceService::class => DataWarehouseInvoiceRepositoryEloquent::class,
        DataWarehouseSalesOrderService::class => DataWarehouseSalesOrderRepositoryEloquent::class,
        SalesReturnService::class => SalesReturnRepositoryEloquent::class,
        DevelopmentService::class => DevelopmentRepositoryEloquent::class,
        DashboardProductionService::class => DashboardProductionRepositoryEloquent::class,
    ];

    /**
     * @author  Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   08 March 2024
     * 
     * Get the services provided by the provider.
     * Return the service container binding.
     * 
     * @return array<int, string>
     */
    public function provides() : array
    {
        return [
            UserService::class,
            RoleService::class,
            CategoryService::class,
            CategoryListService::class,
            ProductService::class,
            SizeService::class,
            SalesChannelService::class,
            PaymentMethodService::class,
            TransactionService::class,
            DashboardService::class,
            LocalityService::class,
            ImportProductService::class,
            WarehouseService::class,
            ItemStockService::class,
            InvoiceCategoryService::class,
            SalesInvoiceService::class,
            VendorService::class,
            PurchasingInvoiceService::class,
            PurchaseOrderService::class,
            DataWarehouseInvoiceService::class,
            DataWarehouseSalesOrderService::class,
            SalesReturnService::class,
            DevelopmentService::class,
            DashboardProductionService::class,
        ];
    }


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
