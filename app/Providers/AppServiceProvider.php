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
